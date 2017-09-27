<?php
require("inc/db.php");
require("inc/validate.php");
require("inc/session.php");

if (isset($_SESSION['user'])){
	$user = getUser($_SESSION['user'], $db);
}
else {
	redirectWith("index.php", array("info", "You need to log in first."));
	exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user'])) {

	$validation = new Validate();

	if (isset($_POST["name"]) && isset($_POST["bio"]) && isset($_POST['password'])) {

		if ($validation->isValid(array(
				$_POST["name"] => "text|32"
			))){

			$full_name = $validation->clean($_POST["name"]);
			$bio = $validation->clean($_POST['bio']);
			
			if (!empty($_POST['password'])) {
				$password = $validation->clean($_POST["password"]);
			}
			else {
				$password = $user['password'];
			}


			$db->query("UPDATE `users` SET `password` = '$password',
			 `full_name` = '$full_name', `bio` = '$bio'
			 WHERE `users`.`id` = ". $user['id']);

			redirectWith("profile.php", array("success", "Changes saved."));	

		}
		else {
			redirectWith("index.php", array("danger", "Some fields were left empty or invalid data entered."));
		}
	}
	else {
		redirectWith("index.php", array("danger", "Invalid form submission."));
	}
}
else {
	redirectWith("index.php", array("primary", "Register here."));
}

?>