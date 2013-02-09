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

		$active_projects;

		# Retrieve all the active projects, as it's quicker to do the re-ordering in memory than in MySQL.
		$projects = $this->db->order_by('name', 'asc')->get_where('projects', array(
			'status_id' => 3,
		))->result();

		# Loop the parent projects, adding any that have a parent_id to a child array of the parent project.
		foreach ($projects as $project)
		{
			if ($project->parent_project_id > 0)
			{
				$active_projects[$project->parent_project_id]['children'][] = $project;
			}
			else
			{
				$active_projects[$project->id]['parent'] = $project;
			}
		}
		
		# Return the final nested array.
		return $active_projects;

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
