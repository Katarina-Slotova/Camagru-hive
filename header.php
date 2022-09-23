<?php

session_start();

if(!isset($_SESSION['id'])){
	header('location: home.php');
	exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css"></style>
	<title>Camagru</title>
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
	<link rel="stylesheet" href="assets/line-awesome/css/line-awesome.min.css"> 
	<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
</head>
<body>
	<nav class="navbar">
		<div class="navbar-wrapper">
			<img src="assets/imgs/camagru_logo.png" class="logo">
			<form>
				<a class="search-icon" href="search.php"><i class="las la-search"></i> SEARCH</a>
			</form>
			<div class="nav-items">
				<a href="home.php"><i class="icon las la-home"></i></a>
				<div class="dropdown is-hoverable">
					<div class="dropdown-trigger">
						<i class="icon las la-plus" aria-hidden="true"></i>
					</div>
					<div class="dropdown-menu" id="dropdown-menu4" role="menu">
						<div class="dropdown-content">
						<div class="dropdown-item">
								<p><a style="color: rgb(82, 82, 82);" href="upload.php">Upload a photo</i></a></p>
								<p><a style="color: rgb(82, 82, 82);" href="#">Take a photo</i></a></p>						
						</div>
						</div>
					</div>
				</div>				
				<a href="profile.php"><i class="icon las la-user"></i></a>
				<a href="logout.php"><i class="icon las la-sign-out-alt"></i></a>
			</div>
		</div>
	</nav>