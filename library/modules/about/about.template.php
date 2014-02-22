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

function template_about_main()
{
	echo '
		<div class="page-header">
			<h2>About</h2>
		</div>
		<p class="content">
			Hyouka is a system which enables users to evaluate projects.
		</p>
		<p class="content">
			This tool is coded in <a href="http://php.net">PHP</a> and uses <a href="http://getbootstrap.com">Bootstrap</a> CSS framework. The banner image is from one of the works of <a href="http://pixiv.net/member.php?id=260616">Hsuante</a>.
		</p>';
}