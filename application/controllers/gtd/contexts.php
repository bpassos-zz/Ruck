<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contexts extends Ruck_Controller {
	
	/**
	 * A single project view, showing all tasks associated with that project.
	 */
	public function index($id = NULL)
	{
		
		$context = $this->Context->find($id);
		$tasks = $this->Task->get_tasks_by_context($id);

		# Set page title.
		$this->template->title('GTD', $context['name']);

		# Load the main content of the page.
		$this->template->build('context/list', array(
			'context'		=> $context,
			'tasks'			=> $tasks->result(),
		));

	}
	
	/**
	 * Creating a new context.
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
			$this->template->build('context/new');
			
		}
		else
		{
			
			# Form passes validation, insert the new project into the database.
			$this->Context->insert_new();
			
			# Redirect to the home page.
			redirect('/gtd/');
			
		}

	}
	
	/**
	 * Delete a context. This process should really check whether there are any
	 * outstanding tasks assigned to this context and prompt the user to decide
	 * what to do with them before deleting.
	 */
	function delete($id = NULL)
	{
		# Delete the context row.
		$this->Context->delete($id);
		
		# Redirect to the master page.
		redirect('/gtd/');
	}

}
