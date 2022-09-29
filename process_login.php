<?php

session_start();

require_once('connection.php');

function is_user_active($email)
{
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT active FROM users WHERE email = ?");
	$stmt->bindParam(1, $email, PDO::PARAM_STR);
	return $stmt->execute();
}

if(isset($_POST['login_btn'])){
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	
	try {
		$conn = connect_db();
		$stmt = $conn->prepare("SELECT id, username, password, email, image, followers, following, posts, bio, active FROM users WHERE password = ? AND email = ?");
		$stmt->bindParam(1, $password, PDO::PARAM_STR);
		$stmt->bindParam(2, $email, PDO::PARAM_STR);
		$stmt->execute();
		
		// Check if user with this email and passwd is in db
		if($row = $stmt->fetch(PDO::FETCH_ASSOC) && is_user_active($email)){
			
			// Save the result in session
			$_SESSION['id'] = $row['id'];
			$_SESSION['username'] = $row['username'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['image'] = $row['image'];
			$_SESSION['followers'] = $row['followers'];
			$_SESSION['following'] = $row['following'];
			$_SESSION['posts'] = $row['posts'];
			$_SESSION['bio'] = $row['bio'];
			
			header('location: home.php');
		}else{
			header('location: login.php?error_msg=Incorrect email or password.');
			exit;
		}
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;
}else{
	header('location: login.php?error_msg=Error occured.');
	exit;
}
?>