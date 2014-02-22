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

function category_main()
{
	global $core, $template;

	$template['page_title'] = 'Category';
	$core['current_template'] = 'category_main';
}