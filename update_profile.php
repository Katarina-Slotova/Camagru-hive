<?php 

session_start();

require_once('connection.php');

// Check if user clicked the update button
if(isset($_POST['update_profile_btn'])){
	$id = $_SESSION['id'];
	$image = $_FILES['image']['tmp_name'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$bio = $_POST['bio'];
	$notif = $_POST['notif'];

	if(isset($notif)){
		$notif = true;
	}else{
		$notif = false;
	}

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
		try{
			$conn = connect_db();
			$stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
			$stmt->bindParam(1, $username, PDO::PARAM_STR);
			$stmt->execute();
			//$image_name = $_POST['username'] . ".jpg";
		
			if($res = $stmt->fetch(PDO::FETCH_ASSOC)){
				header("location: edit_profile.php?error_message=Username already exists.");
				exit;
			}
		} catch (PDOException $error) {
			echo $error->getMessage(); 
			exit;
		}
		$conn = null;
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
		try{
			$conn = connect_db();
			$stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, email = ?, image = ?, bio = ? WHERE id = ?");
			$stmt->bindParam(1, $username, PDO::PARAM_STR);
			$stmt->bindParam(2, md5($password), PDO::PARAM_STR);
			$stmt->bindParam(3, $email, PDO::PARAM_STR);
			$stmt->bindParam(4, $image_name, PDO::PARAM_STR);
			$stmt->bindParam(5, $bio, PDO::PARAM_STR);
			$stmt->bindParam(6, $id, PDO::PARAM_INT);
		} catch (PDOException $error) {
			echo $error->getMessage(); 
			exit;
		}
		$conn = null;
	}else{
		try {
			$conn = connect_db();
			$stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, image = ?, bio = ? WHERE id = ?");
			$stmt->bindParam(1, $username, PDO::PARAM_STR);
			$stmt->bindParam(2, $email, PDO::PARAM_STR);
			$stmt->bindParam(3, $image_name, PDO::PARAM_STR);
			$stmt->bindParam(4, $bio, PDO::PARAM_STR);
			$stmt->bindParam(5, $id, PDO::PARAM_INT);
		} catch (PDOException $error) {
			echo $error->getMessage(); 
			exit;
		}
		$conn = null;
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
	try {
		$conn = connect_db();
		$stmt = $conn->prepare("UPDATE comments SET username = ?, profile_image = ? WHERE user_id = ?");
		$stmt->bindParam(1, $username, PDO::PARAM_STR);
		$stmt->bindParam(2, $image_name, PDO::PARAM_STR);
		$stmt->bindParam(3, $id, PDO::PARAM_INT);
		$stmt->execute();
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;
}

// Update posts table when user changes username or profile pic
function updatePostsTable($conn, $username, $image_name, $id){
	try{
		$conn = connect_db();
		$stmt = $conn->prepare("UPDATE posts SET username = ?, profile_image = ? WHERE user_id = ?");
		$stmt->bindParam(1, $username, PDO::PARAM_STR);
		$stmt->bindParam(2, $image_name, PDO::PARAM_STR);
		$stmt->bindParam(3, $id, PDO::PARAM_INT);
		$stmt->execute();
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;
}

?>