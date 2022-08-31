<?php

session_start();

// Connect to database in order to create an account
include("connection.php");

// Check if user clicked signup_btn
if(isset($_POST['signup_btn'])){
	// Get the data about the user who wants to sign up
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password_conf = $_POST['password_conf'];

	// Check if the passwords match
	if($password !== $password_conf){
		header('location: signup.php?error_msg=passwords do not match');
		exit;
	}

	//  Check if user with this email address has already signed up
		// Connect to database and create a prepared statement
	$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
		// Bind parameters for markers
	$stmt->bind_param("ss", $email, $username);
		// Execute query
	$stmt->execute();
		// Store the result
	$stmt->store_result();

	if($stmt->num_rows() > 0){
		header('location: signup.php?error_msg=this user already exists');
		exit;
	}else{
		$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $username, $email, md5($password));
		// If user account created, return the user information to frontend
		if($stmt->execute()){
			$stmt = $conn->prepare("SELECT id, username, email, image, following, followers, posts, bio FROM users WHERE username = ?");
			$stmt->bind_param("s", $username);
			$stmt->execute();
			// Bind variables to a prepared statement for result storage
			$stmt->bind_result($id, $username, $email, $image, $following, $followers, $posts, $bio);
			// Fetch the data from db
			$stmt->fetch();

			// Save data in session
			$_SESSION['id'] = $id;
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $email;
			$_SESSION['image'] = $image;
			$_SESSION['following'] = $following;
			$_SESSION['followers'] = $followers;
			$_SESSION['posts'] = $posts;
			$_SESSION['bio'] = $bio;

			header('location: index.php');
		}else{
			header('location: signup.php?error_msg=error occured');
			exit;
		}
	}
}else{
	header('location: signup.php?error_msg=error occured');
	exit;
}

?>