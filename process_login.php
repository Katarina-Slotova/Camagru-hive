<?php

session_start();

include('connection.php');

if(isset($_POST['login_btn'])){
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	
	$stmt = $conn->prepare("SELECT id, username, password, email, image, followers, following, posts, bio FROM users WHERE password = ? AND email = ?");
	$stmt->bind_param("ss", $password, $email);
	$stmt->execute();
	$stmt->store_result();
	
	// Check if user with this email and passwd is in db
	if($stmt->num_rows() > 0){
		$stmt->bind_result($id, $username, $password, $email, $image, $followers, $following, $posts, $bio);
		$stmt->fetch();
		
		// Save the result in session
		$_SESSION['id'] = $id;
		$_SESSION['username'] = $username;
		$_SESSION['email'] = $email;
		$_SESSION['image'] = $image;
		$_SESSION['followers'] = $followers;
		$_SESSION['following'] = $following;
		$_SESSION['posts'] = $posts;
		$_SESSION['bio'] = $bio;
		
		header('location: index.php');
	}else{
		header('location: login.php?error_msg=Incorrect email or password.');
		exit;
	}
}else{
	header('location: login.php?error_msg=Error occured.');
	exit;
}
?>