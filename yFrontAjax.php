<?php
session_start();
require_once("classes/tasksConnection.php");
require_once("classes/hrConnection.php");

$hr_db = new hr();

if (!empty($_REQUEST['action']) && $_REQUEST['action'] == "getEmployees") {

	$jobId = $_REQUEST['jobId'];
	$data  = '';

	//get employees under this job
	$q  = "SELECT * FROM `employees` WHERE job_id = :jobId ORDER BY emp_id";
	$sq = $hr_db->query($q);
	$hr_db->bind(":jobId", $jobId);
	$sq = $hr_db->execute();
	$getEmployees = $hr_db->fetchAll();
	if(!empty($getEmployees)){
			$data .= "<option value=''>Select...</option>";
		foreach($getEmployees as $Employees){
			$data .= "<option value='".$Employees['emp_id']."'>".$Employees['emp_name']."</option>";
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
	$followersIds = $_REQUEST['followersIds']

	if($attachId == 'e'){
		$attachId = '';
	}
	if($date != ''){
		$date_arr  = explode("-", $date);
		$startDate = date_format($date_arr[0], 'Y-m-d');
		$endDate   = date_format($date_arr[1], 'Y-m-d');
	}else{
		$startDate = '';
		$endDate   = '';
	}

	try{
		$db->beginTransaction();
		$q  = "INSERT INTO tasks (creator_id, assignee_id, loc_id, start_date, due_date, repeat, title, 'desc', attach_group_id, status)
			   VALUES (:creator_id, :assignee_id, :loc_id, :start_date, :due_date, :repeat, :title, :des, :attach_group_id, 1)";
		$sq = $db1->query($q);
		$db1->bind(":creator_id", $creatorId);
		$db1->bind(":assignee_id", $assigneeId);
		$db1->bind(":loc_id", $locId);
		$db1->bind(":start_date", $startDate);
		$db1->bind(":due_date", $endDate);
		$db1->bind(":repeat", $repeat);
		$db1->bind(":title", $title);
		$db1->bind(":des", $desc);
		$db1->bind(":attach_group_id", $attachId);
		$sq = $db1->execute();
		if($sq){
			if($followersIds != ''){
				$cond = count($followersIds);
				$db->query("SET @lastId = (SELECT task_id FROM tasks ORDER BY task_id DESC LIMIT 1)");
				$sql = $db->execute();
				for($i = 0; $i < $cond; $i++){
					$db->query("INSERT INTO tasks_followers (task_id, follower_id)
								 VALUES (@lastId, :follower_id)");
					$db->bind(":follower_id", $followersIds[$i]);
					$sq = $db->execute();
				}
			}
		}
	}catch (Exception $e) {
			$flag = 0;
			$db->cancelTransaction();
	}
	

}

$db->closeConn();
$hr->closeConn();
////////////////////////////////////////////////////////////////////////////
