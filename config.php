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

$core = array();

$core['title_short'] = 'Hyouka';
$core['title_long'] = 'Hyouka';
$core['version'] = '1.0';
$core['cookie'] = 'hyouka2011';
$core['time_offset'] = 0;
$core['clean_url'] = false;

$core['site_url'] = '';
$core['site_dir'] = dirname(__FILE__);

$core['root_dir'] = $core['site_dir'] . '/library';
$core['includes_dir'] = $core['root_dir'] . '/includes';
$core['modules_dir'] = $core['root_dir'] . '/modules';
$core['storage_dir'] = $core['site_dir'] . '/storage';

$db = array();

$db['server'] = '';
$db['name'] = '';
$db['user'] = '';
$db['password'] = '';