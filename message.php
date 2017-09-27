<?php
require("inc/db.php");
require("inc/validate.php");
require("inc/session.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user'])) {

	$validation = new Validate();

	if (isset($_POST["message"]) && isset($_POST['user'])) {

		if (!$validation->isValid(array($_POST['user'] => "text_ns|32"))){
			redirectWith($_SERVER['HTTP_REFERER'], array("danger", "An error occured."));
		}


		$query = $db->query("SELECT * FROM `users` WHERE `username`='" . $validation->clean($_POST['user']) . "'");

		if ($query->num_rows == 0) {
			redirectWith($_SERVER['HTTP_REFERER'], array("danger", "User doesn't exist."));
			exit;
		}
		else {
			$currentUser = $query->fetch_assoc();
		}

		$message = $validation->clean($_POST['message'], true);

		if (!empty($_POST['message']) && count($message) <= 320){

			$user = getUser($_SESSION['user'], $db);

			$query = $db->query("INSERT INTO `messages`
				(`id`, `from_user`, `to_user`, `content`, `date`)
				VALUES (NULL, '".$user['id']."', '".$currentUser['id']."', '".$message."', '".time()."');");

			redirectWith($_SERVER['HTTP_REFERER'], array("success", "Message sent."));

		}
		else {
			redirectWith($_SERVER['HTTP_REFERER'], array("danger", "Message was too long or empty."));
		}
	}
	else {
		redirectWith($_SERVER['HTTP_REFERER'], array("danger", "Form data missing."));
	}
}
else {
	redirectWith($_SERVER['HTTP_REFERER'], array("danger", "Bad request method."));
}

?>