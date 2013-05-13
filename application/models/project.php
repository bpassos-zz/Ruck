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

		# Retrieve all the active projects, as it's quicker to do the re-ordering in memory than in MySQL.
		$projects = $this->db->order_by('name', 'asc')->get_where('projects', array(
			'someday_maybe' => 0,
		))->result();

		return $this->_build_tree($projects);

	}
	
	/**
	 * Return a nested list of inactive projects.
	 */
	function get_someday_maybe_projects()
	{
		# Retrieve all the inactive projects, as it's quicker to do the re-ordering in memory than in MySQL.
		$projects = $this->db->order_by('name', 'asc')->get_where('projects', array(
			'someday_maybe' => 1,
		))->result();

		return $this->_build_tree($projects);
	}
	
	/**
	 * Return an array of link arrays for the navigation, showing all ancestor projects.
	 */
	function get_project_breadcrumb($id)
	{
		$links = array();
		$project = $this->db->select('name, parent_project_id')->get_where('projects', array(
			'id' => $id,
		))->row();
		$links[] = array(
			'url'	=> '/gtd/projects/' . $id,
			'text'	=> $project->name,
		);
		while ($project->parent_project_id != 0)
		{
			$project = $this->db->select('id, name, parent_project_id')->get_where('projects', array(
				'id' => $project->parent_project_id,
			))->row();
			$links[] = array(
				'url'	=> '/gtd/projects/' . $project->id,
				'text'	=> $project->name,
			);
		}
		return array_reverse($links);
	}
	
	/**
	 * Placeholder for the weekly review process. We will return all 
	 * open projects (i.e. not Someday/Maybe), and list all tasks within
	 * those projects, together with Delete links.
	 */
	function get_projects_for_review()
	{

		$projects_tasks = array();

		$projects = $this->db->order_by('name')->get_where('projects', array(
			'someday_maybe' => 0
		))->result();
		
		foreach ($projects as $project)
		{
			$project->tasks = $this->db->get_where('tasks', array(
				'project_id' => $project->id
			))->result();
			$projects_tasks[$project->id] = $project;
		}

		return $projects_tasks;

	}
	
	/**
	 * Return the previous and next project links for the currently selected one.
	 */
	function get_footer_links($id, $parent_project_id)
	{

		$links = array();

		# Find all the projects that have the same parent and are active. 
		$sibling_projects = $this->db->order_by('name', 'asc')->get_where('projects', array(
			'parent_project_id'	=> $parent_project_id,
			'someday_maybe'		=> 0,
		))->result();

		# Loop through them all to find the previous and next projects.
		$passed_current_project = FALSE;
		$found_next_link = FALSE;
		foreach ($sibling_projects as $project)
		{
			if (!$found_next_link)
			{
				# If the flag for the current project is set, set the next link and set a flag to ignore everything else.
				if ($passed_current_project)
				{
					$links[1] = array(
						'url'	=> '/gtd/projects/' . $project->id,
						'text'	=> $project->name,
					);
					$found_next_link = TRUE;
				}
				# If this is the current project, set a flag to pick up the next link.
				if ($project->id == $id)
				{
					$passed_current_project = TRUE;
				}
				# As long as this is not the current project, make this the previous link.
				else if (!$found_next_link)
				{
					$links[0] = array(
						'url'	=> '/gtd/projects/' . $project->id,
						'text'	=> $project->name,
					);
				}
			}
		}

		if (!isset($links[0]))
		{
			$links[0] = array(
				'url'	=> '/gtd/',
				'text'	=> 'Home',
			);
		}
		
		if ($parent_project_id != 0)
		{
			$links[2] = array(
				'url'	=> '/gtd/projects/' . $parent_project_id,
				'text'	=> 'Parent project',
			);
		}
		else
		{
			$links[2] = array(
				'url'	=> '/gtd/',
				'text'	=> 'Home',
			);
		}

		return $links;

	}
	
	/**
	 * Return the footer link for the homepage.
	 */
	function get_first_project()
	{
		$links = array();
		$first_project = $this->db->order_by('name', 'asc')->limit(1)->get_where('projects', array(
			'parent_project_id' => 0
		))->row();
		$links[1] = array(
			'url'	=> '/gtd/projects/' . $first_project->id,
			'text'	=> $first_project->name,
		);
		return $links;
	}
	
	/**
	 * Recursive tree building function.
	 */
	function _build_tree($projects, $parent_id = 0)
	{
		$branch = array();

		# Loop through every project.
		foreach ($projects as $project)
		{
			# If this project's parent ID is the one we're looking for...
			if ($project->parent_project_id == $parent_id)
			{
				# ...Re-call this function, looking for projects with this project as a parent.
				$children = $this->_build_tree($projects, $project->id);
				# If this project has any (grand)children, add them to the array.
				if ($children)
				{
					$project->children = $children;
				}
				# Add the parent project to the array.
				$branch[] = $project;
			}
		}

		return $branch;

	}
	
	function inactive_projects()
	{
		$projects = $this->db->order_by('name', 'asc')->get_where('projects', array(
			'someday_maybe' => 1
		));
		return $projects->result();
	}
	
	function fetch_projects_for_dropdown($include_create_new = FALSE)
	{
		$projects = array(
			'0' => ($include_create_new) ? 'Create a new project for this task' : 'No parent project',
		);
		$query = $this->db->select('id, name')->order_by('name', 'asc')->get('projects');
		foreach ($query->result() as $row)
		{
			$projects[$row->id] = $row->name;
		}
		return $projects;
	}
	
	/**
	 * Find any parent or grandparent projects and return them in an array.
	 */
	function get_ancestor_projects($id)
	{
		$ancestors = array();
		$query = $this->db->get_where('projects', array(
			'id' => $id,
		));
		if ($query->num_rows() > 0)
		{
			$ancestors[] = $query->row();
			$query = $this->db->get_where('projects', array(
				'id' => $query->row()->parent_project_id,
			));
			if ($query->num_rows() > 0)
			{
				$ancestors[] = $query->row();
			}
		}
		return array_reverse($ancestors);
	}
	
	/**
	 * If a project has any child projects, show details and tasks.
	 */
	function get_child_projects_and_tasks($id)
	{
		$query = $this->db->get_where('projects', array(
			'parent_project_id' => $id
		));
		
		if ($query->num_rows != 0)
		{
			# Found some child projects - let's find their tasks.
			$child_projects = array();
			foreach ($query->result() as $row)
			{
				$row->tasks = $this->db->get_where('tasks', array(
					'project_id' => $row->id
				))->result();
				$child_projects[] = $row;
			}
			return $child_projects;
		}
		else
		{
			return;
		}
	}
	
	/**
	 * For a given project, return the most frequently used context_id or NULL if there are no tasks.
	 */
	function find_most_frequent_context($project_id)
	{
		$query = $this->db->select('context_id, COUNT(context_id) AS count')->group_by('context_id')->order_by('count', 'desc')->get_where('tasks', array(
			'project_id' => $project_id
		), 1);
		if ($query->num_rows())
		{
			return $query->row()->context_id;
		}
	}
	
	/**
	 * Save changes to a project.
	 */
	function update($id)
	{
		$this->db->where('id', $id)->update('projects', array(
			'name'				=> $this->input->post('name'),
			'description'		=> strlen($this->input->post('description')) ? $this->input->post('description')  : '',
#			'parent_project_id'	=> $this->input->post('parent_project_id'),
			'updated_at'		=> date('Y-m-d H:i:s'),
		));
	}
	
	/**
	 * Insert a new project from the New Project form and return the new ID.
	 */
	function insert_new()
	{
		$this->db->insert('projects', array(
			'name'				=> $this->input->post('name'),
			'description'		=> $this->input->post('description'),
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
