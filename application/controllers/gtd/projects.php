<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends Ruck_Controller {
	
	/**
	 * A single project view, showing all tasks associated with that project.
	 */
	public function index($id = NULL)
	{
		
		$project = $this->Project->find($id);
		$tasks = $this->Task->get_tasks_by_project($id);

		# Set page title.
		$this->template->title('GTD', $project['name']);

		# Load the main content of the page.
		$this->template->build('tasks', array(
			'project'		=> $project,
			'tasks'			=> $tasks->result(),
		));

	}
	
	/**
	 * Creating a new project.
	 */
	public function create()
	{
		
		$this->load->library('form_validation');
		
		# Validate the new project form if submitted.
		if ($this->form_validation->run() == FALSE)
		{

			# Set page title.
			$this->template->title('GTD', 'Create a new Project');
	
			# Load the main content of the page.
			$this->template->build('project/new', array(
				'statuses'	=> $this->Status->fetch_project_statuses(),
				'projects'	=> $this->Project->fetch_projects_for_dropdown(),
			));
			
		}
		else
		{
			
			# Form passes validation, insert the new project into the database.
			$project_id = $this->Project->insert_new();
			
			# Redirect to the new Project's page.
			redirect('/gtd/projects/' . $project_id);
			
		}

	}
	 
}
