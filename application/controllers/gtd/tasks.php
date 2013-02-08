<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tasks extends CI_Controller {

	/**
	 * Constructor. Here we setup the templating system, and create standard
	 * content like the sidebar list of projects and top list of contexts.
	 */	
	public function __construct()
	{
		parent::__construct();

		# Configure template to use.
		$this->template->set_layout('gtd');

		# Create template partials, including passing data.
		$this->template->set_partial('header', 'layouts/partial/header');
		$this->template->set_partial('sidebar', 'layouts/partial/sidebar', array(
			'projects_list' => $this->Project->alphabetical_list(),
			'context_list'	=> $this->Context->alphabetical_list(),
		));
	}

	public function index()
	{
		
		# Set page title.
		$this->template->title('GTD', 'Home');

		# Load the main content of the page.
		$this->template->build('home', array(
			'next_tasks' => $this->Task->get_next_tasks()
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
	
}
