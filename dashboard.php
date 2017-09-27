<?php
$title = "Dashboard";
require("partials/header.php");
require("inc/db.php");
require("inc/session.php");

if (isset($_SESSION['user'])){
	$user = getUser($_SESSION['user'], $db);
}
else {
	redirectWith("index.php", array("info", "You need to log in first."));
	exit;
}
require("partials/header.auth.php");
?>
	<div class="message_tabs">
		<div class="btn-group" role="group">
			<button type="button" class="btn btn-primary active" id="recv-b">Recieved</button>
			<button type="button" class="btn btn-primary" id="sent-b">Sent</button>
		</div>
	</div>
	<table class="table table-striped" id="received">
		<?php
		$query = $db->query("SELECT * FROM `messages` WHERE `to_user`='".$user['id']."'");
		while ($result = $query->fetch_assoc()){
			echo "<tr><td>" . $result['content'] ."<span style='float: right;'>".
			date("d-M-y, h:i a", $result['date'])."</span></td></tr>";
		}
		if ($query->num_rows == 0){
			echo "<tr><td>You have no messages in your inbox</td></tr>";
		}
		?>
	</table>
	<table class="table table-striped" id="sent">
		<?php
		$query = $db->query("SELECT * FROM `messages` WHERE `from_user`='".$user['id']."'");
		while ($result = $query->fetch_assoc()){
			$user = getUser($result['to_user'], $db);
			echo "<tr><td>" . $result['content'] ." <small class='text-muted'>to @<a href='view.php?user=".$user['username']."'>".$user['username']."</a></small><span style='float: right;'>".
			date("d-M-y h:i a", $result['date'])."</span></td></tr>";
		}
		if ($query->num_rows == 0){
			echo "<tr><td>You have no messages in your outbox</td></tr>";
		}
		?>
	</table>
</div>

<?php
require("partials/footer.auth.php");
require("partials/footer.php");
cleanFlashdata();
?>