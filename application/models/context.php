<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Context extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function find($id = NULL)
	{
		$context = $this->db->get_where('contexts', array('id' => $id));
		return $context->row_array();
	}

	/**
	 * Return a list of all contexts in alphabetical order
	 */
	function alphabetical_list()
	{
		$contexts = $this->db->order_by('name', 'asc')->get('contexts');
		return $contexts->result();
	}

	function fetch_contexts()
	{
		$contexts = array(
			0 => 'Select context:',
		);
		$query = $this->db->select('id, name')->get_where('contexts');
		foreach ($query->result() as $row)
		{
			$contexts[$row->id] = $row->name;
		}
		return $contexts;
	}

	/**
	 * Insert a new context from the New Context form and return the new ID.
	 */
	function insert_new()
	{
		# Add an @ symbol if the user hasn't included one.
		$name = $this->input->post('name');
		if ( ! stristr($name, '@'))
		{
			$name = '@' . $name;
		}
		# Insert the new record.
		$this->db->insert('contexts', array(
			'name'				=> $name,
			'description'		=> $this->input->post('description'),
			'created_at'		=> date('Y-m-d H:i:s'),
			'updated_at'		=> date('Y-m-d H:i:s'),
		));
		return;
	}
	
	/**
	 * Delete a context.
	 */
	function delete($id)
	{
		$this->db->delete('contexts', array(
			'id' => $id
		));
		return;
	}

}
