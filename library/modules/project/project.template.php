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

function template_project_list()
{
	global $template;

	echo '
		<div class="page-header">
			<div class="pull-right">
				<a class="btn btn-warning" href="', build_url(array('project', 'edit')), '">Add Project</a>
			</div>
			<h2>Project List</h2>
		</div>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Name</th>
					<th>Category</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>';

	if (empty($template['projects']))
	{
		echo '
				<tr>
					<td class="align_center" colspan="3">There are not any projects added yet!</td>
				</tr>';
	}

	foreach ($template['projects'] as $project)
	{
		echo '
				<tr>
					<td>', $project['name'], '</td>
					<td>', $project['category'], '</td>
					<td class="span3 align_center">
						<a class="btn btn-info" href="', build_url(array('peek', 'project', $project['id'])), '">Peek</a>
						<a class="btn btn-primary" href="', build_url(array('project', 'edit', $project['id'])), '">Edit</a>
						<a class="btn btn-danger" href="', build_url(array('project', 'delete', $project['id'])), '">Delete</a>
					</td>
				</tr>';
	}

	echo '
			</tbody>
		</table>';
}

function template_project_edit()
{
	global $user, $template;

	echo '
		<form class="form-horizontal" action="', build_url(array('project', 'edit')), '" method="post">
			<fieldset>
				<legend>', (!$template['project']['is_new'] ? 'Edit' : 'Add'), ' Project</legend>
				<div class="control-group">
					<label class="control-label" for="name">Name:</label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="name" name="name" value="', $template['project']['name'], '" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="id_category">Category:</label>
					<div class="controls">
						<select id="id_category" name="id_category">
							<option value="0"', ($template['project']['category'] == 0 ? ' selected="selected"' : ''), '>Select category</option>';

	foreach ($template['categories'] as $category)
	{
		echo '
							<option value="', $category['id'], '"', ($template['project']['category'] == $category['id'] ? ' selected="selected"' : ''), '>', $category['name'], '</option>';
	}

	echo '
						</select>
					</div>
				</div>
				<div class="form-actions">
					<input type="submit" class="btn btn-primary" name="save" value="Save changes" />
					<input type="submit" class="btn" name="cancel" value="Cancel" />
				</div>
			</fieldset>
			<input type="hidden" name="project" value="', $template['project']['id'], '" />
			<input type="hidden" name="session_id" value="', $user['session_id'], '" />
		</form>';
}

function template_project_delete()
{
	global $user, $template;

	echo '
		<form class="form-horizontal" action="', build_url(array('project', 'delete')), '" method="post">
			<fieldset>
				<legend>Delete Project</legend>
				Are you sure you want to delete the project &quot;', $template['project']['name'], '&quot;?
				<div class="form-actions">
					<input type="submit" class="btn btn-danger" name="delete" value="Delete" />
					<input type="submit" class="btn" name="cancel" value="Cancel" />
				</div>
			</fieldset>
			<input type="hidden" name="project" value="', $template['project']['id'], '" />
			<input type="hidden" name="session_id" value="', $user['session_id'], '" />
		</form>';
}