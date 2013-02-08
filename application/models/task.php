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
		return $task->row();
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
	 * Find all of the 'next' tasks. These will be the single task within
	 * each project with the lowest id (as we re-insert the tasks each time
	 * their order is updated.)
	 */
	function get_next_tasks()
	{

		# Create an empty array to hold all the results.
		$next_tasks = array();

		# Retrieve all projects.
		$projects = $this->db->get('projects');

		# Loop through each project.
		foreach ($projects->result() as $project)
		{

			# Retrieve the first task for each project.
			$task = $this->db->get_where('tasks', array(
				'project_id' => $project->id
			), 1);
			
			# Insert the Task object into the array.
			$next_tasks[] = $task->row();			

		}

		# Return the set of next tasks.
		return $next_tasks;

	}
	
}
