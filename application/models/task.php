<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Task extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function get_tasks_by_project($project_id)
	{
		return $this->db->get_where('tasks', array(
			'project_id' => $project_id
		));
	}
	
}
