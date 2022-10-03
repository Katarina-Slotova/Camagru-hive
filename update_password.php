<?php

session_start();

require_once('connection.php');
include('reinitialise_pwd.php');

if(isset($_POST['new_pwd_btn'])){
	$password = $_POST['password'];
	$password_conf = $_POST['password_conf'];

	// Check if the passwords match
	if($password !== $password_conf){
		header('location: set_new_password.php?error_message=passwords do not match');
		exit;
	}

	if(strlen($password) < 8){
		header('location: set_new_password.php?error_message=password is shorter than 8 characters');
		exit;
	}

	if(strlen($password) > 20){
		header('location: set_new_password.php?error_message=password too long, maximum 20 characters allowed.');
		exit;
	}

	// Update db with new password
	try {
		$conn = connect_db();
		$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
		$stmt->bindParam(1, md5($password), PDO::PARAM_STR);
		$stmt->bindParam(2, $email, PDO::PARAM_STR);
		if($stmt->execute()){
			header("location: login.php?ok_message=Your password was updated, you can login now!");
		}else{
			header('location: login.php?error_message=Error occured');
			exit;
		}
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
}else{
	header('location: login.php?error_message=Error occured');
	exit;
}

?>