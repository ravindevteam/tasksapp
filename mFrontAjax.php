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
}
$db->closeConn();
$hr->closeConn();
////////////////////////////////////////////////////////////////////////////
