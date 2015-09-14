<?php
session_start();
require_once("classes/tasksConnection.php");
require_once("classes/hrConnection.php");
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
	$taskId = $_POST['taskId'];
	$value  = $_POST['value'];
	$db->query("UPDATE tasks SET rating = :rte WHERE task_id = :tid");
	$db->bind(":rte",$value);
	$db->bind(":tid",$taskId);
	$update = $db->execute();
	if($update){
		$res = 1;
	}else{
		$res = 2;
	}
	echo $res;
}if(!empty($_POST['action']) && $_POST['action'] == "commentOnTask"){
	$commentarea = $_POST['commentarea'];
	$attach_id   = $_POST['attach_id'];
	$usr         = $_POST['usr'];
	$task        = $_POST['task'];
	$data = '';
	if($attach_id == "e"){
		$attach_id = 0;
	}
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
	if($insert){
		$db->query("SELECT * FROM comments WHERE task_id = :tsk");
		$db->bind(":tsk",$task);
		$comments = $db->fetchAll();
		if(!empty($comments)){
			foreach($comments AS $row){
				$hr->query("SELECT * FROM users WHERE emp_id = :emp");
				$hr->bind(":emp",$row['user_id']);
				$getUser = $hr->fetch();
				if(!empty($getUser)){
					$userName = $getUser['name'];
				}else{
					$userName = "User Name";
				}

				$data .= '<li class="messages-item">
							<img class="messages-item-avatar" src="assets/images/avatar-1.jpg" alt="">
							<span class="messages-item-from">'.$userName.'</span>';
							
				if($row['attach_group_id'] != 0){
		            $data .= '<span class="messages-item-attachment">
								<i class="fa fa-paperclip mAttachs" data-attach="'.$row['attach_group_id'].'"></i>
							</span>';
				}
							
				$data .= '<span class="messages-item-subject">User role</span>
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
	// $task = $_POST['task'];
	// $creator = $_POST['creator'];
	// $hr->query("SELECT users.emp_id FROM users
	// 			INNER JOIN emp_loc ON users.job_id = emp_loc.job_id
	// 			INNER JOIN 
	// 			WHERE ");
}
$db->closeConn();
$hr->closeConn();
////////////////////////////////////////////////////////////////////////////
