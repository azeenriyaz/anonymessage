
<header class="row text-center" id="dashboard_header">
	<div class="brand col-md-4 col-sm-12">
		<h3><a href="dashboard.php">Anonymessage</a></h3>
	</div>
	<div class="search col-md-4 col-sm-12 text-center">
		<form action="search.php" class="form-inline row" method="GET">
			<div class="form-group col-sm-12 col-md-8">
					<input type="text" class="form-control" name="s" id="search_text" placeholder="Username, Full Name or Bio" required>
				</div>
				<div class="form-group col-sm-4" >
					<button type="submit" class="btn btn-primary" id="search_btn" style="margin-left: -22px;">
					Search</button>
				</div>
		</form>
	</div>
	<div class="tabs col-md-4 col-sm-12">
		<ul class="nav">
  			<li class="nav-item" id="profile"><a href="view.php?user=<?php echo $user['username']; ?>" class="nav-link"><?php echo explode(" ", $user['full_name'])[0]; ?>'s Profile</a></li>
 			<li class="nav-item" id="logout"><a href="logout.php"  class="nav-link">Logout</a></li>
 		</ul>
	</div>
</header>