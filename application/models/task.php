<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Task extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	/**
	 * Find a specific task.
	 */
	function find($id = NULL)
	{
		$task = $this->db->get_where('tasks', array(
			'id' => $id
		));
		return $task->row_array();
	}
	
	/**
	 * Find the first unprocessed task, ordered by creation date.
	 */
	function find_first_not_processed()
	{
		$task = $this->db->order_by('created_at')->limit(1)->get_where('tasks', array(
			'not_processed' => 1
		));
		return $task->row_array();
	}
	
	/**
	 * Count the number of items in the inbox.
	 */
	function inbox_count()
	{
		return $this->db->get_where('tasks', array(
			'not_processed' => 1
		))->num_rows();
	}

	/**
	 * Find all the tasks under a specific project.
	 */
	function get_tasks_by_project($project_id)
	{
		return $this->db->select('tasks.id, tasks.description, tasks.due, tasks.recurs, contexts.id AS context_id, contexts.name AS context_name')->join('contexts', 'contexts.id = tasks.context_id')->get_where('tasks', array(
			'project_id' => $project_id
		));
	}
	
	/**
	 * Find all tasks tagged for a specific context.
	 */
	function get_tasks_by_context($context_id)
	{
		return $this->db->get_where('tasks', array(
			'context_id' => $context_id
		));
	}
	
	/**
	 * Return the options for recurring tasks.
	 */
	function fetch_recurring_labels()
	{
		$recurring_labels = array();
		$query = $this->db->get('recurring');
		foreach ($query->result() as $row)
		{
			$recurring_labels[$row->id] = $row->label;
		}
		return $recurring_labels;
	}
	
	function next_actions_count()
	{

		$count = 0;

		# Retrieve all active projects.
		$projects = $this->db->get_where('projects', array(
			'someday_maybe' => 0
		));

		# Loop through each project.
		foreach ($projects->result() as $project)
		{

			# Retrieve the first task for each project.
			$task = $this->db->get_where('tasks', array(
				'project_id' => $project->id
			), 1);
			
			# Insert the Task object into the appropriate array, if any were found.
			if ($task->num_rows() != 0 && !isset($task->row()->due))
			{
				$count++;
			}

		}
		
		return $count;
		
	}
	
	/**
	 * Find all of the 'next' tasks. These will be the single task within
	 * each project with the lowest id (as we re-insert the tasks each time
	 * their order is updated.) We also need to retrieve the related project
	 * so we can display a link and name for that in the list too.
	 */
	function get_next_tasks()
	{

		# Create an empty array to hold all the results - we're going to use four categories:
		# 1. Overdue tasks with due dates (in date order)
		# 2. Tasks with a due date of today
		# 3. All tasks with no due date (in reverse order of last update)
		# 4. Tasks with a due date in the future (in date order)
		$overdue_tasks = array();
		$todays_tasks = array();
		$no_due_date_tasks = array();
		$future_tasks = array();

		# Retrieve all active projects.
		$projects = $this->db->get_where('projects', array(
			'someday_maybe' => 0
		));

		# Loop through each project.
		foreach ($projects->result() as $project)
		{

			# Retrieve the first task for each project.
			$task = $this->db->get_where('tasks', array(
				'project_id' => $project->id
			), 1);
			
			# Insert the Task object into the appropriate array, if any were found.
			if ($task->num_rows() != 0)
			{
				$row = $task->row();
				$row->project_name = $project->name;
				# If it has no due date, put it into the right list.
				if (!isset($row->due))
				{
					$no_due_date_tasks[] = $row;
				}
				else
				{
					$due = substr($row->due, 0, 10);
					$now = date('Y-m-d');
					# Is the due date today?
					if ($due == $now)
					{
						$todays_tasks[] = $row;
					}
					else if ($due < $now)
					{
						$overdue_tasks[] = $row;
					}
					else
					{
						$future_tasks[] = $row;
					}
				}
			}

		}
		
		# Sort the overdue and future date lists by due date.
		usort($overdue_tasks, 'sort_by_date');
		usort($future_tasks, 'sort_by_date');
		
		# Sort the other lists by last update.
		usort($no_due_date_tasks, 'sort_by_update');
		usort($todays_tasks, 'sort_by_update');
		
		# Combine the four categories of next tasks into one single list.
		$next_tasks = array_merge($overdue_tasks, $todays_tasks, $no_due_date_tasks, $future_tasks);
		
		# Return the set of next tasks.
		return $next_tasks;

	}

	function calendar_count()
	{
		# Find all the tasks with a due date that falls after NOW() minus 1 day.
		return $this->db->select('tasks.id, tasks.project_id, tasks.context_id, tasks.recurs, projects.name AS project_name, tasks.due, tasks.description')->join('projects', 'tasks.project_id = projects.id')->get_where('tasks', array(
			'due >=' => date('Y-m-d H:i:s', time() - (60 * 60 * 24)),
		))->num_rows();
	}
	
	/**
	 * Return a list of tasks with due dates that are within the next few weeks.
	 */
	function find_upcoming_due_dates()
	{
		# Find all the tasks with a due date that falls after NOW() minus 1 day.
		$query = $this->db->select('tasks.id, tasks.project_id, tasks.context_id, tasks.recurs, projects.name AS project_name, tasks.due, tasks.description')->join('projects', 'tasks.project_id = projects.id')->get_where('tasks', array(
			'due >=' => date('Y-m-d H:i:s', time() - (60 * 60 * 24)),
		))->result();
		return $query;
	}

	/**
	 * Return the previous and next task links for the currently viewed task.
	 */
	function get_footer_links($id, $project_id)
	{

		$links = array();

		# Find all the tasks that have the same parent and are active. 
		$sibling_tasks = $this->db->order_by('id')->get_where('tasks', array(
			'project_id' => $project_id,
		))->result();
		
		# Loop through them all to find the previous and next projects.
		$passed_current_task = FALSE;
		$found_next_task = FALSE;
		foreach ($sibling_tasks as $task)
		{
			if (!$found_next_task)
			{
				# If the flag for the current task is set, set the next link and set a flag to ignore everything else.
				if ($passed_current_task)
				{
					$links[1] = array(
						'url'	=> '/gtd/tasks/detail/' . $task->id,
						'text'	=> $task->description,
					);
					$found_next_task = TRUE;
				}
				# If this is the current task, set a flag to pick up the next link.
				if ($task->id == $id)
				{
					$passed_current_task = TRUE;
				}
				# As long as this is not the current task, make this the previous link.
				else if (!$found_next_task)
				{
					$links[0] = array(
						'url'	=> '/gtd/tasks/detail/' . $task->id,
						'text'	=> $task->description,
					);
				}
			}
		}
		
		$links[2] = array(
			'url'	=> '/gtd/projects/' .  $project_id,
			'text'	=> 'Parent project',
		);

		return $links;

	}

	/**
	 * Save changes to a task.
	 */
	function update($id, $create_new_project = FALSE)
	{
		
		# For new tasks being assigned through inbox processing, we might need to create a new project.
		if ($create_new_project && $this->input->post('project_id') == 0)
		{
			# No project provided, so first we create a new project to hold this task.
			$this->db->insert('projects', array(
				'name'				=> $this->input->post('description'),
				'created_at'		=> date('Y-m-d H:i:s'),
				'updated_at'		=> date('Y-m-d H:i:s'),
			));
			# Now we can create the new task as a child of the new project.
			$project_id = $this->db->insert_id();
		}
		
		$this->db->where('id', $id)->update('tasks', array(
			'description'		=> $this->input->post('description'),
			'notes'				=> strlen($this->input->post('notes')) ? $this->input->post('notes')  : '',
			'not_processed'		=> 0,
			'context_id'		=> $this->input->post('context_id'),
			'status_id'			=> $this->input->post('status_id'),
			'project_id'		=> (isset($project_id)) ? $project_id : $this->input->post('project_id'),
			'due'				=> ($this->input->post('due')) ? date('Y-m-d H:i:s', strtotime($this->input->post('due'))) : NULL,
			'recurs'			=> ($this->input->post('recurs') > 0) ? $this->input->post('recurs') : NULL,
			'updated_at'		=> date('Y-m-d H:i:s'),
		));

	}
	
	/**
	 * Insert a new task from the New Task form. Might also create a new project
	 * if this task has no parent project specified.
	 */
	function insert_new()
	{
		$project_id = $this->input->post('project_id');

		# If the project_id is set, create a child task.
		if ($project_id)
		{
			$this->db->insert('tasks', array(
				'description'		=> $this->input->post('description'),
				'notes'				=> $this->input->post('notes'),
				'context_id'		=> $this->input->post('context_id'),
				'status_id'			=> $this->input->post('status_id'),
				'project_id'		=> $this->input->post('project_id'),
				'due'				=> ($this->input->post('due')) ? date('Y-m-d H:i:s', strtotime($this->input->post('due'))) : NULL,
				'recurs'			=> ($this->input->post('recurs') > 0) ? $this->input->post('recurs') : 0,
				'created_at'		=> date('Y-m-d H:i:s'),
				'updated_at'		=> date('Y-m-d H:i:s'),
			));
		}
		else
		{
			# No project provided, so first we create a new project to hold this task.
			$this->db->insert('projects', array(
				'name'				=> $this->input->post('description'),
				'created_at'		=> date('Y-m-d H:i:s'),
				'updated_at'		=> date('Y-m-d H:i:s'),
			));
			# Now we can create the new task as a child of the new project.
			$project_id = $this->db->insert_id();
			$this->db->insert('tasks', array(
				'description'		=> $this->input->post('description'),
				'notes'				=> $this->input->post('notes'),
				'context_id'		=> $this->input->post('context_id'),
				'status_id'			=> $this->input->post('status_id'),
				'project_id'		=> $project_id,
				'due'				=> ($this->input->post('due')) ? date('Y-m-d H:i:s', strtotime($this->input->post('due'))) : NULL,
				'recurs'			=> ($this->input->post('recurs') > 0) ? $this->input->post('recurs') : 0,
				'created_at'		=> date('Y-m-d H:i:s'),
				'updated_at'		=> date('Y-m-d H:i:s'),
			));
		}

		# Return to either the original project or the newly created one.
		return $project_id;

	}

	/**
	 * Insert a new note from the inbox. These tasks have no project, status, context, etc.
	 */
	function insert_note()
	{
		$this->db->insert('tasks', array(
			'description'		=> $this->input->post('description'),
			'notes'				=> $this->input->post('notes'),
			'not_processed'		=> 1,
			'created_at'		=> date('Y-m-d H:i:s'),
			'updated_at'		=> date('Y-m-d H:i:s'),
		));
	}

	/**
	 * Delete a task, unless it is a recurring task.
	 */
	function delete($id)
	{

		# Find the task.
		$task = $this->db->get_where('tasks', array(
			'id' => $id
		))->row();

		# Check whether or not it has the recurring flag set.
		if ($task->recurs)
		{
			# Retrieve the relevant type of recurrence.
			$recurrence = $this->db->get_where('recurring', array(
				'id' => $task->recurs
			))->row();
			# Check for what type of recurrence it has - daily, weekly, monthly or yearly.
			if ($recurrence->days)
			{
				# Daily task, add X day(s) to the due date.
				$this->db->where('id', $id)->update('tasks', array(
					'due' => date('Y-m-d H:i:s', strtotime($task->due . ' +' . $recurrence->days . ' days'))
				));
			}
			elseif ($recurrence->weeks)
			{
				# Weekly task, add X week(s) to the due date.
				$this->db->where('id', $id)->update('tasks', array(
					'due' => date('Y-m-d H:i:s', strtotime($task->due . ' +' . $recurrence->weeks . ' weeks'))
				));
			}
			elseif ($recurrence->months)
			{
				# Monthly task, add X month(s) to the due date.
				$this->db->where('id', $id)->update('tasks', array(
					'due' => date('Y-m-d H:i:s', strtotime($task->due . ' +' . $recurrence->months . ' months'))
				));
			}
			elseif ($recurrence->years)
			{
				# Annual task, add X year(s) to the due date.
				$this->db->where('id', $id)->update('tasks', array(
					'due' => date('Y-m-d H:i:s', strtotime($task->due . ' +' . $recurrence->years . ' years'))
				));
			}
		}
		else
		{
			$this->db->delete('tasks', array(
				'id' => $id
			));
		}

		# Return to the parent project page.
		return $task->project_id;

	}

}

function sort_by_date($a, $b)
{
	return ($a->due < $b->due) ? -1 : 1;
}

function sort_by_update($a, $b)
{
	return ($a->updated_at > $b->updated_at) ? -1 : 1;
}
