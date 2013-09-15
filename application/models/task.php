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
		if ($task->num_rows() > 0)
		{
			return $task->row_array();
		}
		else 
		{
			return 0;
		}
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
		return $this->db->select('tasks.id, tasks.description, tasks.notes, tasks.due, tasks.recurs, tasks.waiting_for, contexts.id AS context_id, contexts.name AS context_name')->join('contexts', 'contexts.id = tasks.context_id')->get_where('tasks', array(
			'project_id'   => $project_id,
			'is_completed' => 0,
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
	 * Return all completed tasks within a specific project/context
	 * that were completed within the last day.
	 */
	function get_completed_tasks($project_id = NULL)
	{
		if (isset($project_id))
		{
			$query = $this->db->select('tasks.id, tasks.description, tasks.due, tasks.recurs, tasks.waiting_for, contexts.id AS context_id, contexts.name AS context_name')->join('contexts', 'contexts.id = tasks.context_id')->get_where('tasks', array(
				'is_completed'        => 1,
				'project_id'          => $project_id,
				'tasks.updated_at >=' => date('Y-m-d H:i:s', time() - ($this->config->item('timezone_offset') * 60 * 60) - (60 * 60 * 24)),
			));
		}
		else
		{
			$query = $this->db->select('tasks.id, tasks.description, tasks.due, tasks.recurs, tasks.waiting_for, contexts.id AS context_id, contexts.name AS context_name')->join('contexts', 'contexts.id = tasks.context_id')->get_where('tasks', array(
				'is_completed'        => 1,
				'tasks.updated_at >=' => date('Y-m-d H:i:s', time() - ($this->config->item('timezone_offset') * 60 * 60) - (60 * 60 * 24)),
			));
		}
		
		return $query->result();
		
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
	
	/**
	 * Get a count of the number of items in the Next Actions list.
	 */
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
				'project_id'   => $project->id,
				'due'          => NULL,
				'is_completed' => 0,
				
			), 1);
			
			# Count the total number of projects/tasks.
			if ($task->num_rows() != 0)
			{
				$count++;
			}

		}
		
		return $count;
		
	}
	
	/**
	 * Find all of the 'next' tasks. These will be the single task within
	 * each project with the lowest id (as we re-insert the tasks each time
	 * their order is updated) that doesn't have a due date or a waiting_for flag. 
	 * We also need to retrieve the related project so we can display a link and name 
	 * for that in the list too.
	 */
	function get_next_tasks()
	{

		# An empty array to hold the next tasks.
		$tasks = array();

		# Retrieve all active projects.
		$projects = $this->db->get_where('projects', array(
			'someday_maybe' => 0,
		));

		# Loop through each project.
		foreach ($projects->result() as $project)
		{
			
			# Retrieve the first task for each project that doesn't have a due date set.
			$task = $this->db->get_where('tasks', array(
				'project_id'   => $project->id,
				'due'          => NULL,
				'waiting_for'  => 0,
				'is_completed' => 0,
			), 1);
			
			# Insert the Task object into the appropriate array, if any were found.
			if ($task->num_rows() != 0)
			{
				$row = $task->row();
				$row->project_name = $project->name;
				$tasks[] = $row;
			}

		}
		
		# Sort the list by last update.
		usort($tasks, 'sort_by_update');
		
		# Return the set of next tasks.
		return $tasks;

	}

	/**
	 * Return a count of items that appear in the calendar list. There can be two numbers; 
	 * the number of items that are due today and tomorrow, and the number of overdue items.
	 */
	function calendar_count()
	{

		# Find all the tasks with a due date that falls between NOW() minus 1 day and NOW() plus 1 day.
		$tasks_due = $this->db->join('projects', 'tasks.project_id = projects.id')->get_where('tasks', array(
			'due >=' => date('Y-m-d H:i:s', time() - (60 * 60 * 24) - ($this->config->item('timezone_offset') * 60 * 60)),
			'due <=' => date('Y-m-d H:i:s', time() + (60 * 60 * 24) - ($this->config->item('timezone_offset') * 60 * 60)),
			'is_completed' => 0,
		))->num_rows();
		
		# Find all the tasks that have a due date before NOW() minus 1 day.
		$tasks_overdue = $this->db->join('projects', 'tasks.project_id = projects.id')->get_where('tasks', array(
			'due <=' => date('Y-m-d H:i:s', time() - (60 * 60 * 24) - ($this->config->item('timezone_offset') * 60 * 60)),
			'is_completed' => 0,
		))->num_rows();
		
		return array(
			'due'     => $tasks_due,
			'overdue' => $tasks_overdue,
		);
	}
	
	/**
	 * Return lists of tasks with due dates that are overdue, due today, or due tomorrow.
	 */
	function find_tasks_due_today()
	{
		# Find all the tasks with a due date that falls after NOW() minus 1 day.
		$query = $this->db->select('tasks.id, tasks.project_id, tasks.notes, tasks.context_id, tasks.recurs, projects.name AS project_name, tasks.due, tasks.description')->join('projects', 'tasks.project_id = projects.id')->order_by('due')->get_where('tasks', array(
			'due >=' => date('Y-m-d H:i:s', time() - (60 * 60 * 24) - ($this->config->item('timezone_offset') * 60 * 60)),
			'due <=' => date('Y-m-d H:i:s', time() - ($this->config->item('timezone_offset') * 60 * 60)),
			'is_completed' => 0,
		))->result();
		return $query;
	}

	function find_tasks_due_tomorrow()
	{
		# Find all the tasks with a due date that falls between NOW() and plus 1 day.
		$query = $this->db->select('tasks.id, tasks.project_id, tasks.notes, tasks.context_id, tasks.recurs, projects.name AS project_name, tasks.due, tasks.description')->join('projects', 'tasks.project_id = projects.id')->order_by('due')->get_where('tasks', array(
			'due >=' => date('Y-m-d H:i:s', time() - ($this->config->item('timezone_offset') * 60 * 60)),
			'due <=' => date('Y-m-d H:i:s', time() + (60 * 60 * 24) - ($this->config->item('timezone_offset') * 60 * 60)),
			'is_completed' => 0,
		))->result();
		return $query;
	}

	function find_overdue_tasks()
	{
		# Find all the tasks with a due date that falls before NOW() minus 1 day.
		$query = $this->db->select('tasks.id, tasks.project_id, tasks.notes, tasks.context_id, tasks.recurs, projects.name AS project_name, tasks.due, tasks.description')->join('projects', 'tasks.project_id = projects.id')->order_by('due')->get_where('tasks', array(
			'due <=' => date('Y-m-d H:i:s', time() - (60 * 60 * 24) - ($this->config->item('timezone_offset') * 60 * 60)),
			'is_completed' => 0,
		))->result();
		return $query;
	}
	
	/**
	 * Find tasks that are flagged as waiting for.
	 */
	function find_tasks_waiting_for()
	{
		$query = $this->db->select('tasks.id, tasks.project_id, tasks.context_id, tasks.recurs, projects.name AS project_name, tasks.due, tasks.description')->join('projects', 'tasks.project_id = projects.id')->get_where('tasks', array(
			'waiting_for' => 1,
			'is_completed' => 0,
		))->result();
		return $query;
	}
	
	function waiting_for_count()
	{
		return $this->db->select('tasks.id, tasks.project_id, tasks.context_id, tasks.recurs, projects.name AS project_name, tasks.due, tasks.description')->join('projects', 'tasks.project_id = projects.id')->get_where('tasks', array(
			'waiting_for' => 1,
			'is_completed' => 0,
		))->num_rows();
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
			'waiting_for'		=> $this->input->post('waiting_for'),
			'context_id'		=> $this->input->post('context_id'),
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
				'waiting_for'		=> $this->input->post('waiting_for'),
				'context_id'		=> $this->input->post('context_id'),
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
	 * Mark a task as complete, unless it is a recurring task.
	 */
	function complete($id)
	{

		# Find the task.
		$task = $this->db->get_where('tasks', array(
			'id' => $id
		))->row_array();
		
		$task['id'] = NULL;
		
		# Check whether or not it has the recurring flag set. If it is recurring, we need to
		# duplicate the task with a new due date, then set the original task as completed.
		if ($task['recurs'])
		{
			# Insert the duplicate task.
			$this->db->insert('tasks', $task);
			$duplicate_task_id = $this->db->insert_id();
			
			# Retrieve the relevant type of recurrence.
			$recurrence = $this->db->get_where('recurring', array(
				'id' => $task['recurs']
			))->row();
			# Check for what type of recurrence it has - daily, weekly, monthly or yearly.
			if ($recurrence->days)
			{
				# Daily task, add X day(s) to the due date.
				$this->db->where('id', $duplicate_task_id)->update('tasks', array(
					'due' => date('Y-m-d H:i:s', strtotime($task['due'] . ' +' . $recurrence->days . ' days')),
					'updated_at'   => date('Y-m-d H:i:s'),
				));
			}
			elseif ($recurrence->weeks)
			{
				# Weekly task, add X week(s) to the due date.
				$this->db->where('id', $duplicate_task_id)->update('tasks', array(
					'due' => date('Y-m-d H:i:s', strtotime($task['due'] . ' +' . $recurrence->weeks . ' weeks')),
					'updated_at'   => date('Y-m-d H:i:s'),
				));
			}
			elseif ($recurrence->months)
			{
				# Monthly task, add X month(s) to the due date.
				$this->db->where('id', $duplicate_task_id)->update('tasks', array(
					'due' => date('Y-m-d H:i:s', strtotime($task['due'] . ' +' . $recurrence->months . ' months')),
					'updated_at'   => date('Y-m-d H:i:s'),
				));
			}
			elseif ($recurrence->years)
			{
				# Annual task, add X year(s) to the due date.
				$this->db->where('id', $duplicate_task_id)->update('tasks', array(
					'due' => date('Y-m-d H:i:s', strtotime($task['due'] . ' +' . $recurrence->years . ' years')),
					'updated_at'   => date('Y-m-d H:i:s'),
				));
			}
		}

		$this->db->where('id', $id)->update('tasks', array(
			'is_completed' => 1,
			'updated_at'   => date('Y-m-d H:i:s'),
		));

		# Return the parent project ID.
		return $task['project_id'];

	}

	/**
	 * Revert completed task status.
	 */
	function uncomplete($id)
	{
		# Find the task.
		$task = $this->db->get_where('tasks', array(
			'id' => $id
		))->row_array();
		
		$this->db->where('id', $id)->update('tasks', array(
			'is_completed' => 0,
			'updated_at'   => date('Y-m-d H:i:s'),
		));

		# Return the parent project ID.
		return $task['project_id'];
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
		
		# Delete it.
		$this->db->delete('tasks', array(
			'id' => $id
		));
		
		# Delete the parent project if it has no other tasks and the same name as the task.
		if ($this->db->get_where('tasks', array('project_id' => $task->project_id))->num_rows() == 0)
		{
			$this->db->delete('projects', array(
				'id'   => $task->project_id,
				'name' => $task->description,
			));
		}

		# Return to the parent project page.
		if ($this->db->affected_rows() == 0)
		{
			return $task->project_id;
		}

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
