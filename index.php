<?php 

require_once('config/setup.php');

if(isset($_SESSION['id'])){
	header('location: src/home.php');
	exit;
} else {
	header('location: src/home.php');
	exit;
}


?>