<?php
//FUNCTION TO INSERT NOTIFICATIONS
/**
** This function take three arguments
** First one ($db) is an object of the database connection
** Second one ($users) is the users who will assign to this notification it could be an array or a normal variable
** Third one ($desc) is the notification description
**/
function mInsertNotification($db,$users,$desc){
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
	return true;
}