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
	
	function alphabetical_list()
	{
		$projects = $this->db->order_by('name', 'asc')->get('projects');
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
	
}
