<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tasks extends Ruck_Controller {
	
	/**
	 * The default Home view of all Next Actions.
	 */
	public function index()
	{

		# Set page title.
		$this->template->title('GTD', 'Home');
		
		# Load the main content of the page.
		$this->template->build('home', array(
			'next_tasks'	  => $this->Task->get_next_tasks(),
			'completed_tasks' => $this->Task->get_completed_tasks(),
		));
		
	}
	
	public function calendar()
	{

		# Set page title.
		$this->template->title('GTD', 'Calendar');
		
		# Load the main content of the page.
		$this->template->build('calendar', array(
			'today'    => $this->Task->find_tasks_due_today(),
			'tomorrow' => $this->Task->find_tasks_due_tomorrow(),
			'overdue'  => $this->Task->find_overdue_tasks(),
		));
		
	}
	
	/**
	 * The Inbox, for either quick capture of a task for later processing, or processing those captured tasks.
	 */
	public function inbox()
	{
		
		$this->load->library('form_validation');
		
		# Validate the new project form if submitted.
		if ($this->form_validation->run('new_task') == FALSE)
		{

			# Set page title.
			$this->template->title('GTD', 'Quick capture');
	
			# Load the main content of the page.
			$this->template->build('tasks/inbox');

		}
		else
		{
			
			# Form passes validation, insert the new note into the database for later processing.
			$this->Task->insert_note();
			
			# Set a flash message to show on the inbox form.
			$this->session->set_flashdata('message', 'Task "' .  $this->input->post('description') . '" successfully created.');
			
			# Redirect back to the Inbox for more capture.
			redirect('/gtd/tasks/inbox');
			
		}
		
	}
	
	/**
	 * Process the outstanding not_processed tasks by stepping through each one
	 * using the edit form. Show a count of remaining tasks to process.
	 */
	function process_inbox()
	{
		
		$this->load->library('form_validation');
		
		# Validate the form if submitted.
		if ($this->form_validation->run('new_task') != FALSE)
		{
			# Form passes validation, update the task in the database.
			$this->Task->update($this->input->post('id'), TRUE);
		}

		# Find the first not_processed task.
		$task = $this->Task->find_first_not_processed();

		# Set page title.
		$this->template->title('GTD', 'Processing Inbox');

		# Load the main content of the page.
		$this->template->build('tasks/detail', array(
			'task'				=> $task,
			'recurring_labels'	=> $this->Task->fetch_recurring_labels(),
			'contexts'			=> $this->Context->fetch_contexts(),
			'projects'			=> $this->Project->fetch_projects_for_dropdown(TRUE),
		));
		
	}
	
	/**
	 * Tasks that are flagged as waiting for someone else to complete.
	 */
	public function waiting_for()
	{

		# Set page title.
		$this->template->title('GTD', 'Waiting For');
		
		# Load the main content of the page.
		$this->template->build('waiting_for', array(
			'tasks' => $this->Task->find_tasks_waiting_for(),
		));

	}
	
	/**
	 * Show an individual task details, and allow editing of the task.
	 */
	public function detail($id = NULL)
	{

		$task = $this->Task->find($id);

		$this->load->library('form_validation');
		
		# Validate the new project form if submitted.
		if ($this->form_validation->run('new_task') != FALSE)
		{
			# Form passes validation, update the task in the database.
			$this->Task->update($id);
			# and redirect back to the parent project page.
			redirect('/gtd/projects/' . $task['project_id']);
		}

		$project = $this->Project->find($task['project_id']);

		# Set page title.
		$this->template->title('GTD', $task['description']);

		# Load the main content of the page.
		$this->template->build('tasks/detail', array(
			'task'				=> $task,
			'project'			=> $project,
			'recurring_labels'	=> $this->Task->fetch_recurring_labels(),
			'contexts'			=> $this->Context->fetch_contexts(),
			'projects'			=> $this->Project->fetch_projects_for_dropdown(),
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
				'recurring_labels'	=> $this->Task->fetch_recurring_labels(),
				'contexts'			=> $this->Context->fetch_contexts(),
				'projects'			=> $this->Project->fetch_projects_for_dropdown(),
				'project_id'		=> $project_id,
				'default_context'	=> $this->Project->find_most_frequent_context($project_id),
			));
			
		}
		else
		{
			
			# Form passes validation, insert the new task into the database.
			$project_id = $this->Task->insert_new();
			
			# Redirect to the Project's page to show the new task.
			redirect('/gtd/projects/' . $project_id);
			
		}

	}
	
	/**
	 * Complete the task.
	 */
	function complete($id = NULL, $location = '')
	{
		# Update the task's is_completed flag.
		$project_id = $this->Task->complete($id);
		
		# Redirect to either the home page or project page.
		if ($location == 'home')
		{
			redirect('/gtd/');
		}
		elseif ($location)
		{
			redirect('/gtd/' . $location);
		}
		else
		{
			redirect('/gtd/projects/' . $project_id);
		}
	}

	/**
	 * Revert completed task back to incomplete.
	 */
	function uncomplete($id = NULL, $location = '')
	{
		# Update the task's is_completed flag.
		$project_id = $this->Task->uncomplete($id);
		
		# Redirect to either the home page or project page.
		if ($location == 'home')
		{
			redirect('/gtd/');
		}
		elseif ($location)
		{
			redirect('/gtd/' . $location);
		}
		else
		{
			redirect('/gtd/projects/' . $project_id);
		}
	}

	/**
	 * Delete the task entry.
	 */
	function delete($id = NULL, $location = '')
	{
		# Delete the task row.
		$project_id = $this->Task->delete($id);
		
		# Redirect to the project page.
		if ($location == 'home' || !isset($project_id))
		{
			redirect('/gtd/');
		}
		elseif ($location)
		{
			redirect('/gtd/' . $location);
		}
		else
		{
			redirect('/gtd/projects/' . $project_id);
		}
	}

}
