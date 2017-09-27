<?php
$title = "Home";
require("partials/header.php");
require("inc/session.php");

if (isset($_SESSION['user'])){
	redirectWith("dashboard.php", array("info", "You're logged in already."));
}

?>
<div class="container text-center">
	<header class="header" id="welcome_header">
		<h1>Welcome to Anonymessage</h1>
		<h2>Your own anonymous messaging platform</h2>
	</header>
	<div class="content auth row forms">
		<?php if (isset($_SESSION['flashdata'])){ ?>
		<div class="col-sm-12">
				<div class="card bg-<?php echo $_SESSION['flashdata'][0]; ?> message-block">
					<div class="card-block"><?php echo $_SESSION['flashdata'][1]; ?></div>
				</div>	
		</div>
		<?php } ?>
		<div class="register-form col-sm-12 col-md-6">
			<h3>Register</h3>
			<form role="form" action="register.php" method="POST">
				<div class="form-group">
					<input type="text" class="form-control" name="full_name" id="register_name" placeholder="Full Name" required>
				 </div>
  				<div class="form-group">
				    <input type="email" class="form-control" name="email" id="register_email" placeholder="Email" required>
  				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="username" id="register_username" placeholder="Username" required>
				 </div>
				 <div class="form-group">
					<input type="password" class="form-control" name="password" id="register_password" placeholder="Password" required>
				 </div>
				 <div class="form-group">
  				<button type="submit" class="btn btn-primary btn-block">Register</button>
  				</div>
			</form>
		</div>
		<div class="login-form col-sm-12 col-md-6">
			<h3>Login</h3>
			<form role="form" action="login.php" method="POST">
				<div class="form-group">
					<input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
				 </div>
				 <div class="form-group">
					<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
				 </div>
				 <div class="form-group">
  				<button type="submit" class="btn btn-primary btn-block">Login</button>
  				</div>
			</form>
		</div>
		</div>
		<?php
		require("partials/footer.auth.php");
		?>
	</div>
<?php
require("partials/footer.php");
cleanFlashdata();
?>