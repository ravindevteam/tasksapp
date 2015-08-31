<?php

class tasks_followers extends db {

	private $id          = 'id';
	private $task_id     = 'task_id';
	private $follower_id = 'follower_id';
	private $table       = 'tasks_followers';


	/*
	 * method to add
	 * task followers to database
	 */
	public function addTaskFollower($task_id, $follower_id){
		$q = "INSERT INTO `{$this->table}` SET 
			 {$this->task_id}  = :task_id,
			 {$this->follower_id} = :follower_id";

		try{

			$this->query($q);
			$this->bind(':task_id',$task_id);
			$this->bind(':follower_id',$follower_id);
			$check = $this->execute();

		} catch (PDOException $e) {
			$this->error = $e->getMessage();
		}

		return $check;
	}

	/*
	 * method to select
	 * by task_id
	 */
	public function selectByTaskId($task_id){
		$q = "SELECT * FROM {$this->table} WHERE {$this->task_id} = :id";

		try {

			$this->query($q);
			$this->bind(":id",$task_id);
			$rows = $this->fetchAll();

		} catch (PDOException $e) {

			$this->error = $e->getMessage();

		}
		return $rows;
	}

	/*
	 * method to select
	 * by follower_id
	 */
	public function selectByFollowerId($follower_id){
		$q = "SELECT * FROM {$this->table} WHERE {$this->follower_id} = :id";

		try {

			$this->query($q);
			$this->bind(":id",$follower_id);
			$rows = $this->fetchAll();

		} catch (PDOException $e) {

			$this->error = $e->getMessage();

		}
		return $rows;
	}
}