<?php
session_start();
require_once("classes/tasksConnection.php");
require_once("classes/hrConnection.php");
require_once("_inc/mFunctions.php");
if(!empty($_POST['action']) && $_POST['action'] == "showAttachs"){
	$attachId = $_POST['attachId'];
	$images   = array();
	$others   = array();
	$res      = "";
	if(!empty($attachId)){
		$db->query("SELECT * FROM attachments WHERE attach_group_id = :atid");
		$db->bind(":atid",$attachId);
		$getAttaches = $db->fetchAll();
		if(!empty($getAttaches)){
			foreach($getAttaches AS $row){
				$ext = pathinfo($row['attach_desc'], PATHINFO_EXTENSION);
				if(strtolower($ext) == "jpg" || strtolower($ext) == "jpeg" || strtolower($ext) == "png" || strtolower($ext) == "gif"){
					array_push($images, $row['attach_desc']);
				}else{
					array_push($others, $row['attach_desc']);
				}
			}
		}
		if(!empty($images)){
			$res .= '<ul id="Grid" class="list-unstyled" style="min-height: 300px">';
			for($i = 0; $i < count($images); $i++){
				$res .= '<li class="col-md-3 col-sm-6 col-xs-12 mix category_1 gallery-img" data-cat="1" style="display:block">
								<div class="portfolio-item">
									<a class="thumb-info" href="taskFiles/'.$images[$i].'" data-lightbox="gallery" data-title="'.$images[$i].'">
										<img src="taskFiles/'.$images[$i].'" class="img-responsive" alt="">
										<span class="thumb-info-title"> '.$images[$i].' </span>
									</a>
									<div class="tools tools-bottom">
										<a href="taskFiles/'.$images[$i].'" download>
											<i class="fa fa-download"></i>
										</a>
										<!-- a href="#">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#">
											<i class="fa fa-trash-o"></i>
										</a -->
									</div>
								</div>
							</li>';
			}
			$res .= '</ul>';
			$res .= '<br />';
		}

		if(!empty($others)){
			for($i = 0; $i < count($others); $i++){
				if(strtolower(pathinfo($others[$i], PATHINFO_EXTENSION)) == 'pdf'){
					$icon = 'filesIcons/pdfIcon.png';
				}elseif(strtolower(pathinfo($others[$i], PATHINFO_EXTENSION)) == 'txt'){
					$icon = 'filesIcons/textIcon.png';
				}elseif(strtolower(pathinfo($others[$i], PATHINFO_EXTENSION)) == 'xlsx' || strtolower(pathinfo($others[$i], PATHINFO_EXTENSION)) == 'csv'){
					$icon = 'filesIcons/excel.png';
				}elseif(strtolower(pathinfo($others[$i], PATHINFO_EXTENSION)) == 'docx'){
					$icon = 'filesIcons/wordIcon.png';
				}else{
					$icon = 'filesIcons/unknown.png';
				}
				$res .= '<div style="min-width:50px">';
				$res .= '<div style="width:8%;height: 100%;float: left;">';
				$res .= '<img style="width:100%;height: 115px" src="'.$icon.'" />';
				$res .= '</div>';
				$res .= '<span style="float:left;margin: 57px 13px;font-size:16px"><a href="taskFiles/'.$others[$i].'" target="_blankg">'.$others[$i].'</a></span>';
				$res .= '</div>';
				$res .= '<br style="clear:both" />';
			}
		}
		
	}

	echo $res;
}if(!empty($_POST['action']) && $_POST['action'] == "RateTask"){
	$taskId   = $_POST['taskId'];
	$value    = $_POST['value'];
	$assignee = $_POST['assignee'];
	try {
		$db->beginTransaction();
		$db->query("UPDATE tasks SET rating = :rte WHERE task_id = :tid");
		$db->bind(":rte",$value);
		$db->bind(":tid",$taskId);
		$update = $db->execute();
		if($value == NULL){
			$desc = 'There is a rate on a task that you assigned is cleared <a href="taskDetails.php?k='.$taskId.'">GO?</a>';
		}else{
			$desc = 'There is a task that you assigned to is rated <a href="taskDetails.php?k='.$taskId.'">GO?</a>';
		}
		mInsertNotification($db,$assignee,$desc);
		$db->endTransaction();
		$res = 1;
	} catch (Exception $e) {
		$db->cancelTransaction();
		$res = 2;
	}
	echo $res;
}if(!empty($_POST['action']) && $_POST['action'] == "commentOnTask"){
	$commentarea = $_POST['commentarea'];
	$attach_id   = $_POST['attach_id'];
	$usr         = $_POST['usr'];
	$task        = $_POST['task'];
	$commentors  = $_POST['commentors'];
	$commentors  = array_values(array_unique($commentors));
	if(($key = array_search($usr, $commentors)) !== false) {
	    unset($commentors[$key]);
	}
	$commentors = array_values(array_unique($commentors));
	$data = '';
	if($attach_id == "e"){
		$attach_id = 0;
	}
	try {
		$db->beginTransaction();
		$db->query("INSERT INTO comments 
					SET 
					`comment_desc`    = :cmnt,
					`user_id`         = :usr,
					`task_id`      	  = :tsk,
					`attach_group_id` = :atch");
		$db->bind(":cmnt",$commentarea);
		$db->bind(":usr",$usr);
		$db->bind(":tsk",$task);
		$db->bind(":atch",$attach_id);
		$insert = $db->execute();
		if(!empty($commentors)){
			$desc = 'There is a comment in a task that related to you';
			mInsertNotification($db,$commentors,$desc);
		}
		$db->endTransaction();
		$flag = 1;
	} catch (Exception $e) {
		$db->cancelTransaction();
		$flag = 2;
	}
	
	if($flag == 1){
		$db->query("SELECT * FROM comments WHERE task_id = :tsk");
		$db->bind(":tsk",$task);
		$comments = $db->fetchAll();
		if(!empty($comments)){
			foreach($comments AS $row){
				$hr->query("SELECT users.*, jobs.job FROM users
							INNER JOIN employees ON users.emp_id = employees.emp_id
							INNER JOIN jobs ON employees.job_id = jobs.jobId
							WHERE users.emp_id = :emp");
				$hr->bind(":emp",$row['user_id']);
				$getUser = $hr->fetch();
				if(!empty($getUser)){
					$userName = $getUser['name'];
					$userImg  = "http://iravin.com/devteam/attendance/assets/profileImages/".$getUser['img'];
					$userJob  = $getUser['job'];
				}else{
					$userName = "User Name";
					$userImg  = "http://iravin.com/devteam/attendance/assets/profileImages/avatar-1-xl.jpg";
					$userJob  = "User Role";
				}

				$data .= '<li class="messages-item">
							<img class="messages-item-avatar" src="'.$userImg.'" alt="">
							<span class="messages-item-from">'.$userName.'</span>';
							
				if($row['attach_group_id'] != 0){
		            $data .= '<span class="messages-item-attachment">
								<i class="fa fa-paperclip mAttachs" data-attach="'.$row['attach_group_id'].'"></i>
							</span>';
				}
							
				$data .= '<span class="messages-item-subject">'.$userJob.'</span>
							<span class="messages-item-preview">'.$row['comment_desc'].'<input type="hidden" name="commentor" class="commentor" value="'.$row['user_id'].'" /></span>
						</li>';
			}
		}
	}
	echo $data;
}elseif(!empty($_GET['aid'])){
	$aid = $_GET['aid'];
	if(!empty($_FILES)){
		foreach($_FILES as $file)
		{
			$file_name = "comment-".time().".".pathinfo($file['name'],PATHINFO_EXTENSION);
			if(move_uploaded_file($file['tmp_name'], "taskFiles/".$file_name))
			{
				$flag = 1;
				try {
					$db->beginTransaction();
					if($aid == "e"){
						$db->query("SELECT IFNULL(MAX(attach_group_id),0) + 1 AS newId FROM attachments");
						$newId = $db->fetch();
						if(!empty($newId)){
							$newId = $newId['newId'];
						}else{
							$newId = 1;
						}
					}else{
						$newId = $aid;
					}
					$db->query("INSERT INTO attachments SET attach_group_id = :n, attach_desc = :d");
					$db->bind(":n",$newId);
					$db->bind(":d",$file_name);
					$db->execute();
					$db->endTransaction();
					$flag = 1;
					$status = "The file uploaded successuflly";
				} catch (Exception $e) {
					$db->cancelTransaction();
					$flag = 2;
					$status = "Failed to add the file please try again later";
				}
			} 
			else 
			{
				$status = "Failed to upload file please try again later";
			    $flag = 2;
			}
		}
	}else{
		$status = "";
		$flag   = "";
		$newId  = "";
	}
	$array_res = array(
			"status" => $status,
			"flag"   => $flag,
			"naid"   => $newId
		);
	echo json_encode($array_res);
}if(!empty($_POST['action']) && $_POST['action'] == "disputAction"){
	$task    = $_POST['task'];
	$creator = $_POST['creator'];
	$emps    = array();
	$hr->query("SELECT emp_loc.emp_id FROM emp_loc
				INNER JOIN employees ON emp_loc.job_id = employees.job_id
				WHERE employees.emp_id = :emp");
	$hr->bind(":emp",$creator);
	$getManagers = $hr->fetchAll();
	if(!empty($getManagers)){
		foreach($getManagers AS $row){
			array_push($emps, $row['emp_id']);
		}
	}

	if(!empty($emps)){
		try {
			$db->beginTransaction();
			for($i = 0; $i < count($emps); $i++){
				//HERE WE GONNA INSERT THE FOLLOWERS AND SEND A NOTIFICATION
				$db->query("SELECT id FROM tasks_followers WHERE task_id = :tid AND follower_id = :fid LIMIT :lmt");
				$db->bind(":tid", $task);
				$db->bind(":fid", $emps[$i]);
				$db->bind(":lmt", 1);
				$get = $db->fetch();
				if(empty($get)){
					$db->query("INSERT INTO tasks_followers (task_id,follower_id) VALUES (:tsk,:flowr)");
					$db->bind(":tsk",$task);
					$db->bind(":flowr",$emps[$i]);
					$db->execute();
				}
			}
			$desc = 'You are called in a task by the assignee of that task <a href="taskDetails.php?k='.$task.'">GO?</a>';
			mInsertNotification($db,$emps,$desc);
			$db->endTransaction();
			$res = 1;
		} catch (Exception $e) {
			$db->cancelTransaction();
			$res = 3;
		}
	}else{
		$res = 2;
	}
	echo $res;
}
//CLOSE ALL CONNECTIONS
$db->closeConn();
$hr->closeConn();
////////////////////////////////////////////////////////////////////////////
