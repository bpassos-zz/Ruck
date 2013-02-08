<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ruck_Controller extends CI_Controller {

	/**
	 * Constructor. Here we setup the templating system, and create standard
	 * content like the sidebar list of projects and top list of contexts.
	 */	
	public function __construct()
	{

		parent::__construct();

		# Configure template to use.
		$this->template->set_layout('gtd');

		# Create template partials, including passing data.
		$this->template->set_partial('header', 'layouts/partial/header');
		$this->template->set_partial('sidebar', 'layouts/partial/sidebar', array(
			'projects_list' => $this->Project->alphabetical_list(),
		));
		$this->template->set_partial('contexts', 'layouts/partial/contexts', array(
			'context_list'	=> $this->Context->alphabetical_list(),
		));

	}
	
}
