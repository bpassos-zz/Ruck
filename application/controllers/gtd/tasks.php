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
	 * Show an individual task details, and allow editing of the task.
	 */
	public function detail($id = NULL)
	{

		$this->load->library('form_validation');
		
		# Validate the new project form if submitted.
		if ($this->form_validation->run('new_task') != FALSE)
		{
			# Form passes validation, update the task in the database.
			$this->Task->update($id);
		}

		$task = $this->Task->find($id);
		$project = $this->Project->find($task['project_id']);

		# Set page title.
		$this->template->title('GTD', $task['description']);

		# Load the main content of the page.
		$this->template->build('tasks/detail', array(
			'task'		=> $task,
			'project'	=> $project,
		));
			
	}
	
	/**
	 * Creating a new task, optionally assigned to a specific project.
	 */
	public function create($project_id = NULL)
	{
		
		$this->load->library('form_validation');
		
		# Validate the new project form if submitted.
		if ($this->form_validation->run('new_task') == FALSE)
		{

			# Set page title.
			$this->template->title('GTD', 'Create a new Task');
	
			# Load the main content of the page.
			$this->template->build('tasks/new', array(
				'statuses'			=> $this->Status->fetch_statuses('task'),
				'contexts'			=> $this->Context->fetch_contexts(),
				'projects'			=> $this->Project->fetch_projects_for_dropdown(),
				'project_id'		=> $project_id,
				'default_context'	=> $this->Project->find_most_frequent_context($project_id),
			));
			
		}
		else
		{
			
			# Form passes validation, insert the new project into the database.
			$project_id = $this->Task->insert_new();
			
			# Redirect to the Project's page to show the new task.
			redirect('/gtd/projects/' . $project_id);
			
		}

	}
	
	function delete($id = NULL, $location = '')
	{
		# Delete the task row.
		$project_id = $this->Task->delete($id);
		
		# Redirect to the project page.
		if ($location == 'home')
		{
			redirect('/gtd/');
		}
		else
		{
			redirect('/gtd/projects/' . $project_id);
		}
	}

}
