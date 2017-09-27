<?php
$title = "Edit profile";
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

<div class="container main content">
	<div class="row">
		<?php if (isset($_SESSION['flashdata'])){ ?>
		<div class="col-sm-12">
				<div class="card bg-<?php echo $_SESSION['flashdata'][0]; ?> message-block">
					<div class="card-block"><?php echo $_SESSION['flashdata'][1]; ?></div>
				</div>	
		</div>
		<?php } ?>
	</div>
	<form action="saveProfile.php" method="post" class="form row">
		<div class="form-group col-sm-12 col-md-6">
			<input value="Username: <?php echo $user['username']; ?>" disabled class="form-control">
		</div>
		<div class="form-group col-sm-12 col-md-6">
			<input value="Email: <?php echo $user['email']; ?>" disabled class="form-control">
		</div>
		<div class="form-group col-sm-12 col-md-6">
			<input type="text" placeholder="Full Name" name="name" class="form-control" value="<?php echo $user['full_name']; ?>">
		</div>
		<div class="form-group col-sm-12 col-md-6">
			<input type="password" placeholder="New password (optional)" name="password" class="form-control">
		</div>
		<div class="form-group col-sm-12 col-md-6">
			<textarea class="form-control" placeholder="Describe yourself." maxlength="150" name="bio"><?php echo $user['bio']; ?></textarea>
		</div>
		<div class="form-group col-sm-12 col-md-6">
			<button type="submit" class="btn btn-primary">Save changes</button>
		</div>
	</form>
</div>

<?php
require("partials/footer.auth.php");
require("partials/footer.php");
cleanFlashdata();
?>