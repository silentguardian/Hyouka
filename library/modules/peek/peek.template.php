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

function template_peek_list()
{
	global $template;

	echo '
		<div class="page-header">
			<h2>Peek</h2>
		</div>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Username</th>
					<th>Project</th>
					<th>Category</th>
					<th>Grade</th>
					<th>Time</th>
				</tr>
			</thead>
			<tbody>';

	if (empty($template['grades']))
	{
		echo '
				<tr>
					<td class="align_center" colspan="5">There are not any grades to list!</td>
				</tr>';
	}

	foreach ($template['grades'] as $grade)
	{
		echo '
				<tr>
					<td>', $grade['username'], '</td>
					<td>', $grade['project'], '</td>
					<td>', $grade['category'], '</td>
					<td class="span2 align_center">', $grade['total'], '</td>
					<td class="span2 align_center">', $grade['time'], '</td>
				</tr>';
	}

	echo '
			</tbody>
		</table>';
}