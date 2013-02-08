<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Form validation rulesets for all forms throughout the application.
 */
$config = array(

	'projects/create' => array(
		array(
			'field'	=> 'name',
			'label'	=> 'Project name',
			'rules'	=> 'trim|required|max_length[100]|is_unique[projects.name]|xss_clean',
		),
	),

);
