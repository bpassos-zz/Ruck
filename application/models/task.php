<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Task extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	/**
	 * Find a specific task.
	 */
	function find($id = NULL)
	{
		$task = $this->db->get_where('tasks', array(
			'id' => $id
		));
		return $task->row_array();
	}

	/**
	 * Find all the tasks under a specific project.
	 */
	function get_tasks_by_project($project_id)
	{
		return $this->db->get_where('tasks', array(
			'project_id' => $project_id
		));
	}
	
	/**
	 * Find all tasks tagged for a specific context.
	 */
	function get_tasks_by_context($context_id)
	{
		return $this->db->get_where('tasks', array(
			'context_id' => $context_id
		));
	}
	
	/**
	 * Find all of the 'next' tasks. These will be the single task within
	 * each project with the lowest id (as we re-insert the tasks each time
	 * their order is updated.) We also need to retrieve the related project
	 * so we can display a link and name for that in the list too.
	 */
	function get_next_tasks()
	{

		# Create an empty array to hold all the results.
		$next_tasks = array();

		# Retrieve all projects.
		$projects = $this->db->get_where('projects', array(
			'status_id' => '3'
		));

		# Loop through each project.
		foreach ($projects->result() as $project)
		{

			# Retrieve the first task for each project.
			$task = $this->db->get_where('tasks', array(
				'project_id' => $project->id
			), 1);
			
			# Insert the Task object into the array, if any were found.
			if ($task->num_rows() != 0)
			{
				$row = $task->row();
				$row->project_name = $project->name;
				$next_tasks[] = $task->row();
			}

		}

		# Return the set of next tasks.
		return $next_tasks;

	}

	/**
	 * Save changes to a task.
	 */
	function update($id)
	{
		$this->db->where('id', $id)->update('tasks', array(
			'description'		=> $this->input->post('description'),
			'notes'				=> strlen($this->input->post('notes')) ? $this->input->post('notes')  : '',
#			'context_id'		=> $this->input->post('context_id'),
#			'status_id'			=> $this->input->post('status_id'),
			'updated_at'		=> date('Y-m-d H:i:s'),
		));
	}
	
	/**
	 * Insert a new task from the New Task form. Might also create a new project
	 * if this task has no parent project specified.
	 */
	function insert_new()
	{

		$project_id = $this->input->post('project_id');

		# If the project_id is set, create a child task.
		if ($project_id)
		{
			$this->db->insert('tasks', array(
				'description'		=> $this->input->post('description'),
				'notes'				=> $this->input->post('notes'),
				'context_id'		=> $this->input->post('context_id'),
				'status_id'			=> $this->input->post('status_id'),
				'project_id'		=> $this->input->post('project_id'),
				'created_at'		=> date('Y-m-d H:i:s'),
				'updated_at'		=> date('Y-m-d H:i:s'),
			));
		}
		else
		{
			# No project provided, so first we create a new project to hold this task.
			$this->db->insert('projects', array(
				'name'				=> $this->input->post('description'),
				'status_id'			=> 0,
				'created_at'		=> date('Y-m-d H:i:s'),
				'updated_at'		=> date('Y-m-d H:i:s'),
			));
			# Now we can create the new task as a child of the new project.
			$project_id = $this->db->insert_id();
			$this->db->insert('tasks', array(
				'description'		=> $this->input->post('description'),
				'notes'				=> $this->input->post('notes'),
				'context_id'		=> $this->input->post('context_id'),
				'status_id'			=> $this->input->post('status_id'),
				'project_id'		=> $project_id,
				'created_at'		=> date('Y-m-d H:i:s'),
				'updated_at'		=> date('Y-m-d H:i:s'),
			));
		}

		# Return to either the original project or the newly created one.
		return $project_id;

	}

	/**
	 * Delete a task.
	 */
	function delete($id)
	{
		$project = $this->db->select('project_id')->get_where('tasks', array(
			'id' => $id
		));
		$this->db->delete('tasks', array(
			'id' => $id
		));
		return $project->row()->project_id;
	}

}
