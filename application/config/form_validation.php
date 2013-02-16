<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Form validation rulesets for all forms throughout the application.
 */
$config = array(

	'projects/create' => array(
		array(
			'field'	=> 'name',
			'label'	=> 'Project name',
			'rules'	=> 'trim|required|max_length[100]|xss_clean',
		),
	),

	'contexts/create' => array(
		array(
			'field'	=> 'name',
			'label'	=> 'Context name',
			'rules'	=> 'trim|required|max_length[100]|is_unique[contexts.name]|xss_clean',
		),
	),

	'new_task' => array(
		array(
			'field'	=> 'description',
			'label'	=> 'Task description',
			'rules'	=> 'trim|required|max_length[255]|xss_clean',
		),
	),

);
