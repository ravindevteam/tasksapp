<?php
session_start();
require_once("classes/tasksConnection.php");
require_once("classes/hrConnection.php");
require_once("_inc/mFunctions.php");

$hr_db = new hr();
$db    = new db();

if (!empty($_REQUEST['action']) && $_REQUEST['action'] == "getEmployees") {

	$jobId = $_REQUEST['jobId'];
	$data  = '';

	//get employees under this job
	$q  = "SELECT users.emp_id, users.name FROM `users` 
		   JOIN `employees` on employees.emp_id = users.emp_id
		   WHERE employees.job_id = :jobId ORDER BY emp_id";
	$sq = $hr_db->query($q);
	$hr_db->bind(":jobId", $jobId);
	$sq = $hr_db->execute();
	$getEmployees = $hr_db->fetchAll();
	if(!empty($getEmployees)){
			$data .= "<option value=''>Select...</option>";
		foreach($getEmployees as $Employees){
			$data .= "<option value='".$Employees['emp_id']."'>".$Employees['name']."</option>";
		}
	}

	echo $data;
}

if (!empty($_REQUEST['action']) && $_REQUEST['action'] == "addTask") {

	$creatorId    = $_REQUEST['creatorId'];
	$assigneeId   = $_REQUEST['assigneeId'];
	$locId        = $_REQUEST['locId'];
	$date         = $_REQUEST['date'];
	$repeat       = $_REQUEST['repeat'];
	$title        = $_REQUEST['title'];
	$desc         = $_REQUEST['desc'];
	$attachId     = $_REQUEST['attachId'];
	$formId       = $_REQUEST['formId'];
	if(!empty($_REQUEST['followersIds'])){
		$followersIds = $_REQUEST['followersIds'];
	}else{
		$followersIds = '';
	}
	$followersArr = array();

	if($attachId == 'e'){
		$attachId = '';
	}
	if($date != ''){
		$date_arr  = explode("-", $date);
		$startDate = date("Y-m-d", strtotime($date_arr[0]));
		$endDate   = date("Y-m-d", strtotime($date_arr[1]));
	}else{
		$startDate = '';
		$endDate   = '';
	}

	//get creator of task information
	$q  = "SELECT * FROM `users` WHERE emp_id = :emp_id";
	$sq = $hr_db->query($q);
	$hr_db->bind(":emp_id", $creatorId);
	$sq = $hr_db->execute();
	$getCreator = $hr_db->fetchAll();
	if(!empty($getCreator)){
		foreach($getCreator as $create){
			$craetorName = $create['name'];
		}
	}

	//get creator of task information
	$q  = "SELECT * FROM `users` WHERE emp_id = :emp_id";
	$sq = $hr_db->query($q);
	$hr_db->bind(":emp_id", $assigneeId);
	$sq = $hr_db->execute();
	$getAssignee = $hr_db->fetchAll();
	if(!empty($getAssignee)){
		foreach($getAssignee as $assign){
			$assigneeName = $assign['name'];
		}
	}

	try{
		$db->beginTransaction();
		//adding task details into database
		$q  = "INSERT INTO tasks (creator_id, assignee_id, loc_id, start_date, due_date, `repeat`, title, `desc`, attach_group_id, status)
			   VALUES (:creator_id, :assignee_id, :loc_id, :start_date, :due_date, :repeat, :title, :des, :attach_group_id, 1)";
		$sq = $db->query($q);
		$db->bind(":creator_id", $creatorId);
		$db->bind(":assignee_id", $assigneeId);
		$db->bind(":loc_id", $locId);
		$db->bind(":start_date", $startDate);
		$db->bind(":due_date", $endDate);
		$db->bind(":repeat", $repeat);
		$db->bind(":title", $title);
		$db->bind(":des", $desc);
		$db->bind(":attach_group_id", $attachId);
		$sq = $db->execute();
		if($sq){
			//add followers of task if exist
			if($followersIds != ''){
				$cond = count($followersIds);
				//get task_id 
				$db->query("SET @lastId = (SELECT task_id FROM tasks ORDER BY task_id DESC LIMIT 1)");
				$sql = $db->execute();
				for($i = 0; $i < $cond; $i++){
					array_push($followersArr, $followersIds[$i]);
					$db->query("INSERT INTO tasks_followers (task_id, follower_id)
								 VALUES (@lastId, :follower_id)");
					$db->bind(":follower_id", $followersIds[$i]);
					$sq = $db->execute();
				}
				$notifications = 'You are follower on a task '.$title.' from '.$craetorName.' to '.$assigneeName.' to '.$desc.' with period '.$repeatPeriod.'.';
				mInsertNotification($db,$followersArr,$notifications);
			}
			//add task to notifications
			//first for assignee user
			if($repeat != ''){
				if ($repeat == 1){
					$repeatPeriod = 'daily';
				}else if ($repeat == 2){
					$repeatPeriod = 'weekly';
				}else if ($repeat == 3){
					$repeatPeriod = 'monthly';
				}else{
					$repeatPeriod = 'annually';
				}
			}else{
				$repeatPeriod = 'from '.$startDate.' to '.$endDate.'';
			}
			$nontification = 'You have a task '.$title.' from '.$craetorName.' to '.$desc.' with period '.$repeatPeriod.'.';
			mInsertNotification($db,$assigneeId,$nontification);
		}
		$db->endTransaction();
		$flag = 1;
	}catch (Exception $e) {
		$flag = 0;
		$db->cancelTransaction();
	}

	echo $flag;
}

$db->closeConn();
$hr->closeConn();
////////////////////////////////////////////////////////////////////////////
