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

if (!$_SERVER['REQUEST_METHOD']=="GET" || !isset($_GET['s'])) {
	redirectWith("dashboard.php", array("info", "You can search here."));
	exit;
}

$v = new Validate();

if (!$v->isValid(array($_GET['s'] => "text|100"))){
	redirectWith("dashboard.php", array("info", "Invalid search term."));
}

$title = "Search";
require("partials/header.php");


require("partials/header.auth.php");

$q = $v->clean($_GET['s']);
$query = $db->query("SELECT * FROM `users` WHERE `username` LIKE '%{$q}%' OR `full_name` LIKE '%{$q}%' OR `bio` LIKE '%{$q}%'");

?>

<div class="container main content">
	<div class="row">
		<div class="col-sm-12">
			<h2>Search Results</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php
			if ($query->num_rows > 0) { 
			?>
			<table class="table table-striped">
				<thead>
					<tr>
						<td>Name</td>
						<td>Username</td>
					</tr>
				</thead>
				<tbody>
					<?php
						
						while ($result = $query->fetch_assoc()){
							echo "<tr><td><a href='view.php?user=" . $result['username'] . "'>" . $result['full_name'] . "</a></td><td><a href='view.php?user=" . $result['username'] . "'>" . $result['username'] . "</a></td></tr>";
						}
					?>
				</tbody>
			</table>
			<?php } else { ?>
				<br>
				<h5>No results found. Please enter a more relevant search term.</h5>
			<?php } ?>
		</div>
	</div>
</div>

<?php
require("partials/footer.auth.php");
require("partials/footer.php");
cleanFlashdata();
?>