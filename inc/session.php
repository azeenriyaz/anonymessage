<?php
date_default_timezone_set("Asia/Kolkata");
session_start();

function redirectWith($link, $data) {
	$_SESSION['flashdata'] = $data;
	header("Location: " . $link);
}
function cleanFlashdata(){
	unset($_SESSION['flashdata']);
}
?>