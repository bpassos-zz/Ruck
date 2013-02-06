<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends CI_Controller {
	
	public $projects_list;
	
	public function __construct()
	{
		parent::__construct();
		$this->projects_list = $this->Project->alphabetical_list();
	}

	public function index($id = NULL)
	{
		
		$project = $this->Project->find($id);
		$tasks = $this->Task->get_tasks_by_project($id);
		
		$this->parser->parse('tasks', array(
			'projects_list'	=> $this->projects_list,
			'project'		=> $project->result(),
			'tasks'			=> $tasks->result(),
		));
		
	}

}
