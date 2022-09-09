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
		$image_name = $_SESSION['username'] . ".jpg";
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
		$image_name = $_POST['username'] . ".jpg";
	
		if($stmt->num_rows() > 0){
			header("location: edit_profile.php?error_message=Username already exists.");
			exit;
		}
	}else{
		$username = $_SESSION['username'];
		updateUserProfile($conn, $username, $password, $email, $image, $image_name, $bio, $id);
	}

	if($bio != ""){
		$bio = $bio;
	}else{
		$bio = $_SESSION['bio'];
	}

	updateUserProfile($conn, $username, $password, $email, $image, $image_name, $bio, $id);

}else{
	header('location: edit_profile.php?error_message=Error occured.');
	exit;
}

function updateUserProfile($conn, $username, $password, $email, $image, $image_name, $bio, $id){
	if($password){
		if(strlen($password) < 8){
			header('location: edit_profile.php?error_message=password is shorter than 8 characters');
			exit;
		}
		if(strlen($password) > 20){
			header('location: edit_profile.php?error_message=password too long, maximum 20 characters allowed.');
			exit;
		}
		$stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, email = ?, image = ?, bio = ? WHERE id = ?");
		$stmt->bind_param("sssssi", $username, md5($password), $email, $image_name, $bio, $id);
	}else{
		$stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, image = ?, bio = ? WHERE id = ?");
		$stmt->bind_param("ssssi", $username,  $email, $image_name, $bio, $id);
	}

	if($stmt->execute()){
		if($image != ""){
			move_uploaded_file($image, "assets/imgs/".$image_name); //Store image in the imgs folder
		}
		// Update session with the new updated data (from variables)
		$_SESSION['username'] = $username;
		$_SESSION['email'] = $email;
		$_SESSION['image'] = $image_name;
		$_SESSION['bio'] = $bio;

		updateCommentsTable($conn, $username, $image_name, $id);
		updatePostsTable($conn, $username, $image_name, $id);

		header('location: profile.php?ok_message=Profile updated.');
		exit;
	}else{
		header('location: edit_profile.php?error_message=Error occured, profile not updated.');
		exit;
	}
}

// Update comments table when user changes username or profile pic
function updateCommentsTable($conn, $username, $image_name, $id){
	$stmt = $conn->prepare("UPDATE comments SET username = ?, profile_image = ? WHERE user_id = ?");
	$stmt->bind_param("ssi", $username, $image_name, $id);
	$stmt->execute();
}

// Update posts table when user changes username or profile pic
function updatePostsTable($conn, $username, $image_name, $id){
	$stmt = $conn->prepare("UPDATE posts SET username = ?, profile_image = ? WHERE user_id = ?");
	$stmt->bind_param("ssi", $username, $image_name, $id);
	$stmt->execute();
}

?>