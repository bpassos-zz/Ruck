<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		$projects = $this->Task->get_tasks_by_project(6);
		
		foreach ($projects->result() as $project)
		{
			echo $project->description;
			echo '<br>';
		}
	}
}
