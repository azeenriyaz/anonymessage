<?php

require("inc/session.php");
require("inc/validate.php");
require("inc/db.php");

if (isset($_SESSION['user'])){
	$user = getUser($_SESSION['user'], $db);
}

else {
	redirectWith("index.php", array("info", "You need to log in first."));
	exit;
}

if (!$_SERVER['REQUEST_METHOD']=="GET" || !isset($_GET['user'])) {
	redirectWith("dashboard.php", array("info", "You can search here."));
	exit;
}

$v = new Validate();

if (!$v->isValid(array($_GET['user'] => "text_ns|32"))){
	redirectWith("dashboard.php", array("info", "Invalid username."));
}


$query = $db->query("SELECT * FROM `users` WHERE `username`='" . $v->clean($_GET['user']) . "'");

if ($query->num_rows == 0) {
	redirectWith("dashboard.php", array("info", "User does not exist."));
	exit;
}
else {
	$currentUser = $query->fetch_assoc();
}


$title = $currentUser['full_name'];
require("partials/header.php");
require("partials/header.auth.php");
?>

<div class="container main content">
	<div class="row">
		<div class="col-sm-12 col-md-6">
			<h2><?php echo $currentUser['full_name']; ?>'s Profile
			<?php 
			if ($user['id'] == $currentUser['id']){
				echo "<span class='text-muted'>(Me)</span>";
			}
			?>
			</h2>
			<p class="text-muted">
				@<?php echo $currentUser['username']; ?>
			</p>
			<p>
				<?php echo $currentUser['bio']; ?>
			</p>
			<p>
			<?php if ($user['id'] == $currentUser['id']){ ?>

			<a href="profile.php" class="btn btn-primary">Edit my profile</a>

			<?php }	?>
			</p>
			<p class="text-muted">Profile link: <a href="http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']; ?>?user=<?php echo $currentUser['username']; ?>">http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']; ?>?user=<?php echo $currentUser['username']; ?></a></p>
		</div>
		<div class="col-sm-12 col-md-6">
			<h4>Send a message to <?php echo $currentUser['full_name']; ?></h4>
			<?php if (isset($_SESSION['flashdata'])){ ?>
				<div class="card bg-<?php echo $_SESSION['flashdata'][0]; ?> message-block">
					<div class="card-block"><?php echo $_SESSION['flashdata'][1]; ?></div>
				</div>	
			<?php } ?>
			<form action="message.php" class="form" method="POST">
				<input type="hidden" name="user" value="<?php echo $currentUser['username']; ?>">
				<div class="form-group">
					<textarea name="message" class="form-control" rows="10" minlength="0" maxlength="320"></textarea>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Send message</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
require("partials/footer.auth.php");
require("partials/footer.php");
cleanFlashdata();
?>