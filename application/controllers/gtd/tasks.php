<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tasks extends CI_Controller {
	
	public $projects_list;
	
	public function __construct()
	{
		parent::__construct();
		$this->projects_list = $this->Project->alphabetical_list();
	}

	public function index()
	{
		
		$this->parser->parse('tasks', array(
			'projects_list' => $this->projects_list
		));
		
	}
	
	public function detail($id = NULL)
	{
		$task = $this->Task->find($id);
		$this->parser->parse('tasks/detail', array(
			'projects_list' => $this->projects_list,
			'task'			=> $task->result()
		));
	}
	
	public function test()
	{
		$this->template->set_layout('gtd');
		$this->template->title('Blog', 'Test');
		$this->template->set_partial('header', 'layouts/partial/header');
		$this->template->build('tasks', array(
			'projects_list' => $this->projects_list
		));
	}

}
