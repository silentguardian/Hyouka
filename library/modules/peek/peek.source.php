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

function peek_main()
{
	global $core;

	$actions = array('list', 'category', 'project', 'user');

	$core['current_action'] = 'list';
	if (!empty($_REQUEST['action']) && in_array($_REQUEST['action'], $actions))
		$core['current_action'] = $_REQUEST['action'];

	call_user_func($core['current_module'] . '_' . $core['current_action']);
}

function peek_list($filter = "1 = 1")
{
	global $core, $template;

	$request = db_query("
		SELECT
			u.username, p.name AS project, c.name AS category,
			e.total, e.time
		FROM evaluate AS e
			LEFT JOIN project AS p ON (p.id_project = e.id_project)
			LEFT JOIN category AS c ON (c.id_category = p.id_category)
			LEFT JOIN user AS u ON (u.id_user = e.id_user)
		WHERE $filter
		ORDER BY time DESC");
	$template['grades'] = array();
	while ($row = db_fetch_assoc($request))
	{
		$template['grades'][] = array(
			'username' => $row['username'],
			'project' => $row['project'],
			'category' => $row['category'],
			'total' => $row['total'],
			'time' => format_time($row['time']),
		);
	}
	db_free_result($request);

	$template['page_title'] = 'Peek';
	$core['current_template'] = 'peek_list';
}

function peek_category()
{
	$id_category = !empty($_REQUEST['peek']) ? (int) $_REQUEST['peek'] : 0;

	peek_list("p.id_category = $id_category");
}

function peek_project()
{
	$id_project = !empty($_REQUEST['peek']) ? (int) $_REQUEST['peek'] : 0;

	peek_list("e.id_project = $id_project");
}

function peek_user()
{
	$id_user = !empty($_REQUEST['peek']) ? (int) $_REQUEST['peek'] : 0;

	peek_list("e.id_user = $id_user");
}