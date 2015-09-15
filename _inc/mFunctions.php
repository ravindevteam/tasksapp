<?php
require_once("../classes/tasksConnection.php");
require_once("../classes/hrConnection.php");
//FUNCTION TO INSERT NOTIFICATIONS
function mInsertNotification($users,$desc){
	try {
		$db->beginTransaction();
		$q = '';
		$db->query("INSERT INTO notifications SET notif_desc = :dsc");
		$db->bind(":dsc",$desc);
		$db->execute();
		$getLast = $db->lastInsertId();
		$q .= 'INSERT INTO notification_user (notif_id, user_id) VALUES ';
		if(is_array($users)){
			for($i = 0; $i < count($users); $i++){
				$q .= '(:not, :usr'.$i.')';
				if(count($users) - $i > 1){
					$q .= ',';
				}
			}
		}else{
			$q .= '(:not,:usr)';
		}
		$db->query($q);
		$db->bind(":not",$getLast);
		if(is_array($users)){
			for($i = 0; $i < count($users); $i++){
				$db->bind(":usr".$i,$users[$i]);
			}
		}else{
			$db->bind(":usr",$users);
		}
		$db->execute();
		$db->endTransaction();
		return true;
	} catch (Exception $e) {
		$db->cancelTransaction();
		return false;
	}
}
$db->closeConn();
$hr->closeConn();