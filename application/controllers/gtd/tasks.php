<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tasks extends CI_Controller {
	
	public $projects_list;
	
	public function __construct()
	{
		parent::__construct();
		$this->projects_list = $this->Project->alphabetical_list();
	}

	public function index()
	{
		
		$this->parser->parse('tasks', array(
			'projects_list' => $this->projects_list
		));
		
	}

}
