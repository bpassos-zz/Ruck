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
	
}
