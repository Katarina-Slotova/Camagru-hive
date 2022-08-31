<?php

session_start();

if(!isset($_SESSION['id'])){
	header('location: login.php');
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
				<input type="text" class="search-box" placeholder="Search">
			</form>
			<div class="nav-items">
				<i class="icon las la-home"></i>
				<i class="icon las la-plus"></i>
				<i class="icon las la-user"></i>
				<a href="logout.php"><i class="logout icon las la-sign-out-alt"></i></a>
			</div>
		</div>
	</nav>