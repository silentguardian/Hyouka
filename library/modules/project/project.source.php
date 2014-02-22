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
	global $core, $template;

	$template['page_title'] = 'Project';
	$core['current_template'] = 'project_main';
}