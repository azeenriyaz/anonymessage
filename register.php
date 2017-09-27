<?php
require("inc/db.php");
require("inc/validate.php");
require("inc/session.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION['user'])) {

	$validation = new Validate();

	if ( isset($_POST["email"]) && isset($_POST["full_name"]) && isset($_POST["username"]) && isset($_POST["password"])) {

		if ($validation->isValid(array(
				$_POST["full_name"] => "text|32",
				$_POST["username"] => "text_ns|32",
				$_POST["password"] => "text_ns|32",
				$_POST["email"] => "email|32"
			))){

			$full_name = $validation->clean($_POST["full_name"]);
			$username = strtolower($validation->clean($_POST["username"]));
			$password = $validation->clean($_POST["password"]);
			$email = strtolower($validation->clean($_POST["email"]));

			$query = $db->query("SELECT * FROM `users` WHERE `username` = '$username' OR `email` = '$email'");

			if ($query->num_rows > 0) {
				redirectWith("index.php", array("danger", "The username or email you entered already exists."));
			}
			else {
				$db->query("INSERT INTO `users` (`id`, `full_name`, `username`, `password`, `email`) VALUES (NULL, '$full_name', '$username', '$password', '$email')");

				redirectWith("index.php", array("success", "You have been registered. You can login now."));
			}

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