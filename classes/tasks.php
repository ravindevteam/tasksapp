<?php

class tasks extends db {

	private $task_id         = 'task_id';
	private $creator_id      = 'creator_id';
	private $assignee_id     = 'assignee_id';
	private $loc_id          = 'loc_id';
	private $start_date      = 'start_date';
	private $due_date        = 'due_date';
	private $repeat          = 'repeat';
	private $title           = 'title';
	private $desc            = 'desc';
	private $done_date       = 'done_date';
	private $rating          = 'rating';
	private $attach_group_id = 'attach_group_id';
	private $log_date        = 'log_date';
	private $status          = 'status';
	private $table           = 'tasks';


	/*
	 * method to add
	 * tasks to database
	 */
	public function addTask($creator_id, $assignee_id, $start_date, $due_date, $title, $desc, $status, $loc_id=NULL, $repeat=NULL, $attach_group_id=NULL){
		$q = "INSERT INTO `{$this->table}` SET 
			 {$this->creator_id}  = :creator_id,
			 {$this->assignee_id} = :assignee_id,
			 {$this->start_date}  = :start_date,
			 {$this->due_date}    = :due_date,
			 {$this->title}       = :title,
			 {$this->desc}        = :des,
			 {$this->status}      = :status,
			 {$this->log_date}   =  now()";
		
		if($loc_id != NULL){
			$q .= ",{$this->loc_id} = :loc_id";
		}
		if($repeat != NULL){
			$q .= ",{$this->repeat} = :repeat";
		}
		if($attach_group_id != NULL){
			$q .= ",{$this->attach_group_id} = :attach_group_id";
		}

		try{

			$this->query($q);
			$this->bind(':creator_id',$creator_id);
			$this->bind(':assignee_id',$assignee_id);
			$this->bind(':start_date',$start_date);
			$this->bind(':due_date',$due_date);
			$this->bind(':title',$title);
			$this->bind(':des',$desc);
			$this->bind(':status',$status);
			if($loc_id != NULL){
				$this->bind(':loc_id',$loc_id);
			}
			if($repeat != NULL){
				$this->bind(':repeat',$repeat);
			}
			if($attach_group_id != NULL){
				$this->bind(':attach_group_id',$attach_group_id);
			}
			$check = $this->execute();

		} catch (PDOException $e) {
			$this->error = $e->getMessage();
		}

		return $check;
	}

	/*
	 * method to select
	 * by creator_id
	 */
	public function selectByCreatorId($creator_id){
		$q = "SELECT * FROM {$this->table} WHERE {$this->creator_id} = :id";

		try {

			$this->query($q);
			$this->bind(":id",$creator_id);
			$rows = $this->fetchAll();

		} catch (PDOException $e) {

			$this->error = $e->getMessage();

		}
		return $rows;
	}

	/*
	 * method to select
	 * by assignee_id
	 */
	public function selectByAssigneeId($assignee_id){
		$q = "SELECT * FROM {$this->table} WHERE {$this->assignee_id} = :id";

		try {

			$this->query($q);
			$this->bind(":id",$assignee_id);
			$rows = $this->fetchAll();

		} catch (PDOException $e) {

			$this->error = $e->getMessage();

		}
		return $rows;
	}

	/*
	 * method to update task status
	 * by task_id
	 */

	public function updateTaskStatus($status,$task_id){
        $q = "UPDATE {$this->table} SET 
              {$this->status} = :status
              WHERE  {$this->task_id} = :task_id";
               

        try {

            $this->query($q);
            $this->bind(":status",$status);
            $this->bind(":task_id",$task_id);
            $check = $this->execute();

        } catch(PDOException $e) {

            $this->error = $e->getMessage();

        }
        return $check;
    }

}