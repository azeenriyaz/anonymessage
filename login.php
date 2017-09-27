<?php
require("inc/db.php");
require("inc/validate.php");
require("inc/session.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$validation = new Validate();

	if (isset($_POST["username"]) && isset($_POST["password"])) {

		if ($validation->isValid(array(
				$_POST["username"] => "text_ns|32",
				$_POST["password"] => "text_ns|32"
			))){

			$username = strtolower($validation->clean($_POST["username"]));
			$password = strtolower($validation->clean($_POST["password"]));

			$query = $db->query("SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$password'");

			if ($query->num_rows == 1) {
				$_SESSION['user'] = $query->fetch_assoc()['id'];
				redirectWith("dashboard.php", array("success", "Login successful."));
			}
			else {
				redirectWith("index.php", array("danger", "The username or password you entered was incorrect."));
			}

		}
		else {
			redirectWith("index.php", array("danger", "The username or password you entered was incorrect."));
		}
	}
	else {
		redirectWith("index.php", array("danger", "Invalid data."));
	}
}
?>