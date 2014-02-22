<?php

/**
 * @package Hyouka
 *
 * @author Selman Eser
 * @copyright 2014 Selman Eser
 * @license BSD 2-clause
 *
 * @version 1.0
 */

if (!defined('CORE'))
	exit();

function evaluate_main()
{
	global $core;

	$actions = array('list', 'do');

	$core['current_action'] = 'list';
	if (!empty($_REQUEST['action']) && in_array($_REQUEST['action'], $actions))
		$core['current_action'] = $_REQUEST['action'];

	call_user_func($core['current_module'] . '_' . $core['current_action']);
}

function evaluate_list()
{
	global $core, $template, $user;

	if (empty($user['category']))
		$user['category'] = array('-1');
	$filter = implode(',', $user['category']);

	$request = db_query("
		SELECT p.id_project, p.name, c.name AS category, e.total
		FROM project AS p
			LEFT JOIN category AS c ON (c.id_category = p.id_category)
			LEFT JOIN evaluate AS e ON (e.id_project = p.id_project AND e.id_user = $user[id])
		WHERE p.id_category IN ($filter)
		ORDER BY category, name");
	$template['projects'] = array();
	while ($row = db_fetch_assoc($request))
	{
		$template['projects'][] = array(
			'id' => $row['id_project'],
			'name' => $row['name'],
			'category' => $row['category'],
			'grade' => empty($row['total']) ? 'N/A' : $row['total'],
		);
	}
	db_free_result($request);

	$template['page_title'] = 'Evaluate Projects';
	$core['current_template'] = 'evaluate_list';
}

function evaluate_do()
{
	global $core, $template, $user;

	$template['criteria'] = array(
		1 => 'Creativity',
		2 => 'Genre',
		3 => 'Structure',
		4 => 'Style',
		5 => 'Relevance',
		6 => 'Theme',
		7 => 'Concrete Detail',
		8 => 'Organization',
		9 => 'Eloquence',
		10 => 'Originality'
	);

	$template['grades'] = array(
		1 => '1 - Poor',
		2 => '2 - Fair',
		3 => '3 - Good',
		4 => '4 - Very Good',
		5 => '5 - Excellent',
	);

	if (empty($user['category']))
		$user['category'] = array('-1');
	$filter = implode(',', $user['category']);

	$id_project = !empty($_REQUEST['evaluate']) ? (int) $_REQUEST['evaluate'] : 0;

	$request = db_query("
		SELECT id_project, name
		FROM project
		WHERE id_project = $id_project
			AND id_category IN ($filter)
		LIMIT 1");
	while ($row = db_fetch_assoc($request))
	{
		$template['project'] = array(
			'id' => $row['id_project'],
			'name' => $row['name'],
		);
	}
	db_free_result($request);

	if (!isset($template['project']))
		fatal_error('The project requested does not exist!');

	$request = db_query("
		SELECT *
		FROM evaluate
		WHERE id_project = $id_project
			AND id_user = $user[id]
		LIMIT 1");
	$template['evaluation'] = array();
	while ($row = db_fetch_assoc($request))
	{
		foreach ($template['criteria'] as $id => $label)
			$template['evaluation'][$id] = !empty($row['c' . $id]) ? $row['c' . $id] : 0;
	}
	db_free_result($request);

	if (!empty($_POST['save']))
	{
		check_session('evaluate');

		$grades = array();

		if (!empty($_POST['criteria']) && is_array($_POST['criteria']))
		{
			foreach ($template['criteria'] as $id => $label)
			{
				$value = !empty($_POST['criteria'][$id]) ? (int) $_POST['criteria'][$id] : 0;

				if ($value > -1 && $value < 6)
					$grades[$id] = $value;
			}
		}
		else
			fatal_error('Invalid form submission!');

		db_query("
			DELETE FROM evaluate
			WHERE id_project = $id_project
				AND id_user = $user[id]
			LIMIT 1");

		$insert = array(
			'id_project' => $id_project,
			'id_user' => $user['id'],
			'total' => array_sum($grades),
			'time' => time(),
		);

		foreach ($grades as $id => $value)
			$insert['c' . $id] = $value;

		db_query("
			INSERT INTO evaluate
				(" . implode(', ', array_keys($insert)) . ")
			VALUES
				(" . implode(', ', $insert) . ")");
	}

	if (!empty($_POST['save']) || !empty($_POST['cancel']))
		redirect(build_url('evaluate'));

	$template['page_title'] = 'Evaluate Project';
	$core['current_template'] = 'evaluate_do';
}