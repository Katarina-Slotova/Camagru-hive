<?php 

require_once('config/setup.php');

if($_SESSION['id']){
	header('location: home.php');
} else {
	header('location: home.php');
}


?>