<?php
$conf = array("localhost", "root", "", "anonymessage");
$db = new mysqli($conf[0], $conf[1], $conf[2], $conf[3]);
function getUser($id, $db){
	$query = $db->query("SELECT * FROM `users` WHERE `id`='".$id."'");
	if ($query->num_rows > 0) {
		return $query->fetch_assoc();
	}
	else {	
		return false;
	}
}
?>