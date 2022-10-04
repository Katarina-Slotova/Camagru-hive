<?php 

require_once('config/setup.php');

if(isset($_SESSION['id'])){
	header('location: home.php');
	exit;
} else {
	header('location: home.php');
	exit;
}


?>