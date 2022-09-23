<?php

session_start();

// Connect to database in order to create an account
require_once('connection.php');

// Check if user clicked signup_btn
if(isset($_POST['signup_btn'])){
	// Get the data about the user who wants to sign up
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password_conf = $_POST['password_conf'];

	// Check if the passwords match
	if($password !== $password_conf){
		header('location: signup.php?error_message=passwords do not match');
		exit;
	}

	if(strlen($password) < 8){
		header('location: signup.php?error_message=password is shorter than 8 characters');
		exit;
	}

	if(strlen($password) > 20){
		header('location: signup.php?error_message=password too long, maximum 20 characters allowed.');
		exit;
	}

	//  Check if user with this email address has already signed up
	try {
		// Connect to database and create a prepared statement
		$conn = connect_db();
		$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
		// Bind parameters for markers
 		$stmt->bindParam(1, $email, PDO::PARAM_STR);
		$stmt->bindParam(2, $username, PDO::PARAM_STR);
		// Execute query
		$stmt->execute();
/* 		// Store the result
		$stmt->store_result(); */

		if($stmt->fetch(PDO::FETCH_ASSOC)){
			header('location: signup.php?error_message=this user already exists');
			exit;
		}else{
			try {
				$conn = connect_db();
				$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
/* 				$stmt->bindParam(1, $username, PDO::PARAM_STR);
				$stmt->bindParam(2, $email, PDO::PARAM_STR);
				$stmt->bindParam(3, md5($password), PDO::PARAM_STR); */
				// If user account created, return the user information to frontend
				if($stmt->execute([$username, $email, md5($password)])){
					try {
						$conn = connect_db();
						$stmt = $conn->prepare("SELECT id, username, email, image, following, followers, posts, bio, token FROM users WHERE username = ?");
						$stmt->bindParam(1, $username, PDO::PARAM_STR);
						$stmt->execute();
/* 						// Bind variables to a prepared statement for result storage
						$stmt->bind_result($id, $username, $email, $image, $following, $followers, $posts, $bio);
						// Fetch the data from db
						$stmt->fetch(); */
		
						$row = $stmt->fetch(PDO::FETCH_ASSOC);
						// Save data in session
						$_SESSION['id'] = $row['id'];
						$_SESSION['username'] = $row['username'];
						$_SESSION['email'] = $row['email'];
						$_SESSION['image'] = $row['image'];
						$_SESSION['following'] = $row['following'];
						$_SESSION['followers'] = $row['followers'];
						$_SESSION['posts'] = $row['posts'];
						$_SESSION['bio'] = $row['bio'];
						$_SESSION['token'] = $row['token'];
		
						header('location: home.php');
					} catch (PDOException $error) {
						echo $error->getMessage(); 
						exit;
					}
				}else{
					header('location: signup.php?error_message=error occured');
					exit;
				}
			} catch (PDOException $error) {
				echo $error->getMessage(); 
				exit;
			}
		}
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
}else{
	header('location: signup.php?error_message=error occured');
	exit;
}

?>