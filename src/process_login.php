<?php

session_start();

require_once('connection.php');

function is_user_active($username)
{
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT active FROM users WHERE username = ?");
	$stmt->bindParam(1, $username, PDO::PARAM_STR);
	$stmt->execute();
	return $stmt->fetchColumn();
}

if(isset($_POST['login_btn'])){
	$username = $_POST['username'];
	$password = $_POST['password'];

	try {
		$conn = connect_db();
		$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
		$stmt->bindParam(1, $username, PDO::PARAM_STR);
		$stmt->execute();
		$password_hash = $stmt->fetchColumn();
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}

	
	try {
		$conn = connect_db();
		$stmt = $conn->prepare("SELECT id, username, password, email, image, followers, following, posts, bio, active FROM users WHERE username = ?");
		$stmt->bindParam(1, $username, PDO::PARAM_STR);
		$stmt->execute();
		
		// Check if user with this username and passwd is in db
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(isset($row['username'])){
			$result = is_user_active($row['username']);
		}
		$checked_password = password_verify($password, $password_hash);
		if($row && $result && $checked_password){
			
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
			header('location: login.php?error_msg=Error occured.');
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