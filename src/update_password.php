<?php

require_once('connection.php');

function check_reset_code($activation_code)
{
	try{
		$conn = connect_db();
	
		$stmt = $conn->prepare("SELECT * FROM users WHERE activation_code = ?");
		$stmt->bindParam(1, $activation_code, PDO::PARAM_STR);
		$stmt->execute();

	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}

	return $stmt->rowCount();
}

if(isset($_POST['new_pwd_btn'])){
	$password = $_POST['password'];
	$password_conf = $_POST['password_conf'];
	$activation_code = $_POST['activation_code'];
	$_SESSION['temp_token'] = $activation_code;

	// Check if the passwords match and if the length is ok
	if($password !== $password_conf){
		header('location: set_new_password.php?activation_code=' . $activation_code . '&error_message=Passwords do not match');
		exit;
	}

	if(strlen($password) < 8){
		header('location: set_new_password.php?activation_code=' . $activation_code . '&error_message=Password is shorter than 8 characters');
		exit;
	}

	if(strlen($password) > 20){
		header('location: set_new_password.php?activation_code=' . $activation_code . '&error_message=Password too long, maximum 20 characters allowed');
		exit;
	}

	// Update db with new password
	if(check_reset_code($activation_code)){
		$final_password = hash("whirlpool", $password);
		try {
			$conn = connect_db();
			$stmt = $conn->prepare("UPDATE users SET password = ? WHERE activation_code = ?");
			$stmt->bindParam(1, $final_password, PDO::PARAM_STR);
			$stmt->bindParam(2, $activation_code, PDO::PARAM_STR);
			if($stmt->execute()){
				header('location: login.php?ok_message=Your password was updated, you can login now!');
			}else{
				header('location: login.php?error_message=Error occured');
				exit;
			}
		} catch (PDOException $error) {
			echo $error->getMessage(); 
			exit;
		}
	} else {
		echo "wrong, reset code is: ".$activation_code;
	}
}else{
	header('location: login.php?error_message=Error occured');
	exit;
}

?>