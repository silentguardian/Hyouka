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

function template_evaluate_list()
{
	global $template;

	echo '
		<div class="page-header">
			<h2>Evaluate Projects</h2>
		</div>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Name</th>
					<th>Category</th>
					<th>Grade</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>';

	if (empty($template['projects']))
	{
		echo '
				<tr>
					<td class="align_center" colspan="4">There are not any projects to evaluate!</td>
				</tr>';
	}

	foreach ($template['projects'] as $project)
	{
		echo '
				<tr>
					<td>', $project['name'], '</td>
					<td>', $project['category'], '</td>
					<td class="span2 align_center">', $project['grade'], '</td>
					<td class="span3 align_center">
						<a class="btn btn-', $project['grade'] == 'N/A' ? 'warning' : 'info', '" href="', build_url(array('evaluate', 'do', $project['id'])), '">', $project['grade'] == 'N/A' ? '' : 'Re-', 'Evaluate</a>
					</td>
				</tr>';
	}

	echo '
			</tbody>
		</table>';
}

function template_evaluate_do()
{
	global $user, $template;

	echo '
		<form class="form-horizontal" action="', build_url(array('evaluate', 'do')), '" method="post">
			<fieldset>
				<legend>Evaluate Project - ', $template['project']['name'], '</legend>';

	foreach ($template['criteria'] as $id => $label)
	{
		$value = !empty($template['evaluation'][$id]) ? $template['evaluation'][$id] : 0;

		echo '
				<div class="control-group">
					<label class="control-label" for="criteria_', $id, '">', $label, ':</label>
					<div class="controls">
						<select id="criteria_', $id, '" name="criteria[', $id, ']">
							<option value="0"', ($value == 0 ? ' selected="selected"' : ''), '>Select grade</option>';

		foreach ($template['grades'] as $id => $label)
		{
			echo '
							<option value="', $id, '"', ($value == $id ? ' selected="selected"' : ''), '>', $label, '</option>';
		}

		echo '
						</select>
					</div>
				</div>';
	}

	echo '
				<div class="form-actions">
					<input type="submit" class="btn btn-primary" name="save" value="Save changes" />
					<input type="submit" class="btn" name="cancel" value="Cancel" />
				</div>
			</fieldset>
			<input type="hidden" name="evaluate" value="', $template['project']['id'], '" />
			<input type="hidden" name="session_id" value="', $user['session_id'], '" />
		</form>';
}