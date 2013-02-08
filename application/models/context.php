<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Context extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	/**
	 * Return a list of all contexts in alphabetical order
	 */
	function alphabetical_list()
	{
		$contexts = $this->db->order_by('name', 'asc')->get('contexts');
		return $contexts->result();
	}

}
