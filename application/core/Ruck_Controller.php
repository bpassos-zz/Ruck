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
			'user'        => $this->ion_auth->user()->row()
		));
		$this->template->set_partial('menu', 'layouts/partial/menu', array(
			'next_actions'       => $this->uri->segment(2),
			'current_page'		 => $this->uri->segment(3),
			'inbox_count'        => $this->Task->inbox_count(),
			'calendar_count'     => $this->Task->calendar_count(),
			'next_actions_count' => $this->Task->next_actions_count(),
			'waiting_for_count'  => $this->Task->waiting_for_count(),
		));
		$this->template->set_partial('capture', 'layouts/partial/capture');
		$this->template->set_partial('contexts', 'layouts/partial/contexts', array(
			'context_list'	=> $this->Context->alphabetical_list(),
		));

	}
	
}
