<?php 

session_start();

include('connection.php');

// Check if user clicked the update button
if(isset($_POST['update_profile_btn'])){
	$id = $_SESSION['id'];
	$image = $_FILES['image']['tmp_name'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$bio = $_POST['bio'];

	if($image != ""){
		$image_name = $username . ".png";
	}else{
		$image_name = $_SESSION['image'];
	}

	if($email != ""){
		$email = $email;
	}else{
		$email = $_SESSION['email'];
	}
	
	if($username != ""){
		// Username has to be unique
		$stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->store_result();
	
		if($stmt->num_rows() > 0){
			header("location: edit_profile.php?error_message=Username already exists.");
			exit;
		}
	}else{
		$username = $_SESSION['username'];
	}

	if($password != ""){
		$password = $password;
	}else{
		$password = $_SESSION['password'];
	}

	if($bio != ""){
		$bio = $bio;
	}else{
		$bio = $_SESSION['bio'];
	}

	$stmt = $conn->prepare("UPDATE users SET image = ?, email = ?, username = ?, password = ?, bio = ? WHERE id = ?");
	$stmt->bind_param("sssssi", $image_name, $email, $username, md5($password), $bio, $id);
	if($stmt->execute()){
		if($image != ""){
			move_uploaded_file($image, "assets/imgs/".$image_name); //Store image in the imgs folder
		}
		// Update session with the new updated data (from variables)
		$_SESSION['image'] = $image_name;
		$_SESSION['email'] = $email;
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		$_SESSION['bio'] = $bio;

		header('location: profile.php?ok_message=Profile updated.');
		exit;
	}else{
		header('location: edit_profile.php?error_message=Error occured, profile not updated.');
		exit;
	}
}else{
	header('location: edit_profile.php?error_message=Error occured.');
	exit;
}





?>