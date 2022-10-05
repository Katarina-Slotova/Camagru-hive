<?php

require_once('connection.php');

if(isset($_POST['new_pwd_btn'])){
	$password = $_POST['password'];
	$password_conf = $_POST['password_conf'];
	$email = $_POST['email'];

	// Check if the passwords match and if the length is ok
	if($password !== $password_conf){
		header('location: set_new_password.php?error_message=Passwords do not match');
		exit;
	}

	if(strlen($password) < 8){
		header('location: set_new_password.php?error_message=Password is shorter than 8 characters');
		exit;
	}

	if(strlen($password) > 20){
		header('location: set_new_password.php?error_message=Password too long, maximum 20 characters allowed');
		exit;
	}

	// Update db with new password
	try {
		$conn = connect_db();
		$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
		$stmt->bindParam(1, hash("whirlpool", $password), PDO::PARAM_STR);
		$stmt->bindParam(2, $email, PDO::PARAM_STR);
		if($stmt->execute()){
			header('location: login.php?ok_message=Your password was updated, you can login now!'.$email);
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