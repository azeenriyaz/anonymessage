<?php
require("inc/session.php");
if (isset($_SESSION['user'])) {
	session_unset();
	redirectWith("index.php", array("success", "You have been logged out."));
}
else {
	redirectWith("index.php", array("success", "You need to log in first."));
}
?>