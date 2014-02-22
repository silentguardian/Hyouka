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

function project_main()
{
	global $core;

	$actions = array('list', 'edit', 'delete');

	$core['current_action'] = 'list';
	if (!empty($_REQUEST['action']) && in_array($_REQUEST['action'], $actions))
		$core['current_action'] = $_REQUEST['action'];

	call_user_func($core['current_module'] . '_' . $core['current_action']);
}

function project_list()
{
	global $core, $template;

	$request = db_query("
		SELECT p.id_project, p.name, c.name AS category
		FROM project AS p
			LEFT JOIN category AS c ON (c.id_category = p.id_category)
		ORDER BY category, name");
	$template['projects'] = array();
	while ($row = db_fetch_assoc($request))
	{
		$template['projects'][] = array(
			'id' => $row['id_project'],
			'name' => $row['name'],
			'category' => $row['category'],
		);
	}
	db_free_result($request);

	$template['page_title'] = 'Project List';
	$core['current_template'] = 'project_list';
}

function project_edit()
{
	global $core, $template;

	$id_project = !empty($_REQUEST['project']) ? (int) $_REQUEST['project'] : 0;
	$is_new = empty($id_project);

	if ($is_new)
	{
		$template['project'] = array(
			'is_new' => true,
			'id' => 0,
			'category' => 0,
			'name' => '',
		);
	}
	else
	{
		$request = db_query("
			SELECT id_project, id_category, name
			FROM project
			WHERE id_project = $id_project
			LIMIT 1");
		while ($row = db_fetch_assoc($request))
		{
			$template['project'] = array(
				'is_new' => false,
				'id' => $row['id_project'],
				'category' => $row['id_category'],
				'name' => $row['name'],
			);
		}
		db_free_result($request);

		if (!isset($template['project']))
			fatal_error('The project requested does not exist!');
	}

	if (!empty($_POST['save']))
	{
		check_session('project');

		$values = array();
		$fields = array(
			'id_category' => 'int',
			'name' => 'string',
		);

		foreach ($fields as $field => $type)
		{
			if ($type === 'string')
				$values[$field] = !empty($_POST[$field]) ? htmlspecialchars($_POST[$field], ENT_QUOTES) : '';
			elseif ($type === 'int')
				$values[$field] = !empty($_POST[$field]) ? (int) $_POST[$field] : 0;
		}

		if ($values['name'] === '')
			fatal_error('Project name field cannot be empty!');
		elseif ($values['id_category'] === 0)
			fatal_error('Project category field cannot be empty!');

		if ($is_new)
		{
			$insert = array();
			foreach ($values as $field => $value)
				$insert[$field] = "'" . $value . "'";

			db_query("
				INSERT INTO project
					(" . implode(', ', array_keys($insert)) . ")
				VALUES
					(" . implode(', ', $insert) . ")");
		}
		else
		{
			$update = array();
			foreach ($values as $field => $value)
				$update[] = $field . " = '" . $value . "'";

			db_query("
				UPDATE project
				SET " . implode(', ', $update) . "
				WHERE id_project = $id_project
				LIMIT 1");
		}
	}

	if (!empty($_POST['save']) || !empty($_POST['cancel']))
		redirect(build_url('project'));

	$request = db_query("
		SELECT id_category, name
		FROM category
		ORDER BY name");
	$template['categories'] = array();
	while ($row = db_fetch_assoc($request))
	{
		$template['categories'][] = array(
			'id' => $row['id_category'],
			'name' => $row['name'],
		);
	}
	db_free_result($request);

	if (empty($template['categories']))
		fatal_error('There are no categories added yet! You cannot add projects without categories!');

	$template['page_title'] = (!$is_new ? 'Edit' : 'Add') . ' Project';
	$core['current_template'] = 'project_edit';
}

function project_delete()
{
	global $core, $template;

	$id_project = !empty($_REQUEST['project']) ? (int) $_REQUEST['project'] : 0;

	$request = db_query("
		SELECT id_project, name
		FROM project
		WHERE id_project = $id_project
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

	if (!empty($_POST['delete']))
	{
		check_session('project');

		db_query("
			DELETE FROM project
			WHERE id_project = $id_project
			LIMIT 1");
	}

	if (!empty($_POST['delete']) || !empty($_POST['cancel']))
		redirect(build_url('project'));

	$template['page_title'] = 'Delete Project';
	$core['current_template'] = 'project_delete';
}