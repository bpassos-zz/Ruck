<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function find($id = NULL)
	{
		$project = $this->db->get_where('projects', array('id' => $id));
		return $project->row_array();
	}
	
	/**
	 * Return a nested list of active projects.
	 */
	function active_projects()
	{

		# Retrieve all the active projects, as it's quicker to do the re-ordering in memory than in MySQL.
		$projects = $this->db->order_by('name', 'asc')->get_where('projects', array(
			'status_id' => 3,
		))->result();

		return $this->_build_tree($projects);

	}
	
	/**
	 * Recursive tree building function.
	 */
	function _build_tree($projects, $parent_id = 0)
	{
		$branch = array();

		# Loop through every project.
		foreach ($projects as $project)
		{
			# If this project's parent ID is the one we're looking for...
			if ($project->parent_project_id == $parent_id)
			{
				# ...Re-call this function, looking for projects with this project as a parent.
				$children = $this->_build_tree($projects, $project->id);
				# If this project has any (grand)children, add them to the array.
				if ($children)
				{
					$project->children = $children;
				}
				# Add the parent project to the array.
				$branch[] = $project;
			}
		}

		return $branch;

	}
	
	function inactive_projects()
	{
		$projects = $this->db->order_by('name', 'asc')->get_where('projects', array(
			'status_id' => 4
		));
		return $projects->result();
	}
	
	function fetch_projects_for_dropdown()
	{
		$projects = array(
			'0' => 'No parent project',
		);
		$query = $this->db->select('id, name')->order_by('name', 'asc')->get('projects');
		foreach ($query->result() as $row)
		{
			$projects[$row->id] = $row->name;
		}
		return $projects;
	}
	
	/**
	 * If a project has any child projects, show details and tasks.
	 */
	function get_child_projects_and_tasks($id)
	{
		$query = $this->db->get_where('projects', array(
			'parent_project_id' => $id
		));
		
		if ($query->num_rows != 0)
		{
			# Found some child projects - let's find their tasks.
			$child_projects = array();
			foreach ($query->result() as $row)
			{
				$row->tasks = $this->db->get_where('tasks', array(
					'project_id' => $row->id
				))->result();
				$child_projects[] = $row;
			}
			return $child_projects;
		}
		else
		{
			return;
		}
	}
	
	/**
	 * Insert a new project from the New Project form and return the new ID.
	 */
	function insert_new()
	{
		$this->db->insert('projects', array(
			'name'				=> $this->input->post('name'),
			'description'		=> $this->input->post('description'),
			'status_id'			=> $this->input->post('status_id'),
			'parent_project_id'	=> $this->input->post('parent_project_id'),
			'created_at'		=> date('Y-m-d H:i:s'),
			'updated_at'		=> date('Y-m-d H:i:s'),
		));
		return $this->db->insert_id();
	}
	
	/**
	 * Delete a project.
	 */
	function delete($id)
	{
		$this->db->delete('projects', array(
			'id' => $id
		));
		return;
	}

}
