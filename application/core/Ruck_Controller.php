<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ruck_Controller extends CI_Controller {

	/**
	 * Constructor. Here we setup the templating system, and create standard
	 * content like the sidebar list of projects and top list of contexts.
	 */	
	public function __construct()
	{

		parent::__construct();
		
		# Authentication process.
		if (!$this->ion_auth->logged_in())
		{
			# Redirect user to the login page.
			redirect('auth/login');
		}

		# Configure template to use.
		$this->template->set_layout('gtd');

		# Create template partials, including passing data.
		$this->template->set_partial('head', 'layouts/partial/head');
		$this->template->set_partial('header', 'layouts/partial/header', array(
			'inbox_count' => $this->Task->inbox_count(),
			'user'        => $this->ion_auth->user()->row()
		));
		$this->template->set_partial('menu', 'layouts/partial/menu');
		$this->template->set_partial('capture', 'layouts/partial/capture');
		$this->template->set_partial('contexts', 'layouts/partial/contexts', array(
			'context_list'	=> $this->Context->alphabetical_list(),
		));

		# Load navigation.
		$this->template->set_partial('navigation', 'layouts/partial/navigation', array(
			'active_projects'	=> $this->Project->active_projects(),
			'inactive_projects'	=> $this->Project->inactive_projects(),
		));

		# Create footer links.
		$this->template->set_partial('footer', 'layouts/partial/footer');
		
	}
	
}
