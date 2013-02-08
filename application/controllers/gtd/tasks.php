<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tasks extends Ruck_Controller {

	public function index()
	{
		
		# Set page title.
		$this->template->title('GTD', 'Home');

		# Load the main content of the page.
		$this->template->build('home', array(
			'next_tasks' => $this->Task->get_next_tasks()
		));
		
	}
	
	/**
	 * Show an individual task details.
	 */
	public function detail($id = NULL)
	{

		$task = $this->Task->find($id);

		# Set page title.
		$this->template->title('GTD', $task['description']);

		# Load the main content of the page.
		$this->template->build('tasks/detail', array(
			'task' => $task,
		));

	}
	
}
