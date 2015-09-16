<?php // You need to add server side validation and better error handling here
require_once("classes/tasksConnection.php");
require_once("classes/hrConnection.php");
//object to use users class
$db = new db();
$attach_id  = $_GET['attach_id'];
$error      = false;
$returnData = '';
$others     = array();
$images     = array();

$uploaddir = 'taskFiles/';

foreach($_FILES as $file){
	$file_name = "task-" . time().".".pathinfo($file['name'],PATHINFO_EXTENSION);
	if(move_uploaded_file($file['tmp_name'], $uploaddir.$file_name)){
		//add data to attachments table
		try{
			$db->beginTransaction();
			if($attach_id == 'e'){
				$db->query("SELECT  IFNULL(MAX(attach_group_id),0) + 1 as max_id FROM attachments");
				$res = $db->fetch();
				if(!empty($res)){
					$new_attach_id = $res['max_id'];
				}else{
					$new_attach_id = 1;
				}
			}else{
				$new_attach_id = $attach_id;
			}
			$db->query("INSERT INTO attachments (attach_group_id, attach_desc)
				VALUES (:attach_group_id, :attach_desc)");
			$db->bind(":attach_group_id", $new_attach_id);
			$db->bind(":attach_desc", $file_name);
			$sq = $db->execute();
			$db->endTransaction();
			$flag = 1;
		}catch (Exception $e) {
			$flag = 2;
			$db->cancelTransaction();
		}
	} else {
	    $flag = 3;
	}
}

$db->query("SELECT * FROM attachments WHERE attach_group_id = :id");
$db->bind(":id", $new_attach_id);
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
    $returnData .= '<ul id="Grid" class="list-unstyled" style="min-height: 300px">';
    for($i = 0; $i < count($images); $i++){
        $returnData .= '<li class="col-md-3 col-sm-6 col-xs-12 mix category_1 gallery-img" data-cat="1" style="display:block">
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
    $returnData .= '</ul>';
    $returnData .= '<br />';
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
        $returnData .= '<div style="min-width:50px">';
        $returnData .= '<div style="width:8%;height: 100%;float: left;">';
        $returnData .= '<img style="width:100%;height: 115px" src="'.$icon.'" />';
        $returnData .= '</div>';
        $returnData .= '<span style="float:left;margin: 57px 13px;font-size:16px"><a href="taskFiles/'.$others[$i].'" target="_blankg">'.$others[$i].'</a></span>';
        $returnData .= '</div>';
        $returnData .= '<br style="clear:both" />';
    }
}

$response = array(
			'flag'=>$flag,
			'new_attach_id'=>$new_attach_id,
			'returnData'=>$returnData
		); 

echo json_encode($response);
