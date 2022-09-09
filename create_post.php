<?php

session_start();

include("connection.php");

// Check if user clicked the update button
if(isset($_POST['upload_img_btn'])){
	$id = $_SESSION['id'];
	$profile_image = $_SESSION['image']; 
	$image = $_FILES['image']['tmp_name'];
	$caption = $_POST['caption'];
	$hashtags = $_POST['hashtags'];
	$likes = 0;
	$tz = 'Europe/Helsinki';
	$timestamp = time();
	$date = new DateTime("now", new DateTimeZone($tz));
	$date->setTimestamp($timestamp);
	$date = $date->format('Y-m-d H:i:s');
	$username = $_SESSION['username'];
	// Create a unique image name by using strval unction that converts the timestamp  into a string
	$image_name = strval(time()) . ".jpeg"; 
	
	// Create post
	$stmt = $conn->prepare("INSERT INTO posts (user_id,likes,image,caption,hashtags,date,username,profile_image) VALUES (?,?,?,?,?,?,?,?)");
	$stmt->bind_param("iissssss",$id,$likes,$image_name,$caption,$hashtags,$date,$username,$profile_image);
	if($stmt->execute()){
		move_uploaded_file($image,"assets/imgs/".$image_name); //Store image in folder
		
		//increase the number of posts and update session with the new number of posts
		$stmt = $conn->prepare("UPDATE users SET posts = posts+1 WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$_SESSION['posts'] = $_SESSION['posts'] + 1;

		header('location: camera.php?ok_message=Post created&image_name='.$image_name);
		exit;
	}else{
		header('location: camera.php?error_message=Error occured.');
		exit;
	}
}else{
	header('location: camera.php?error_message=Error occured.');
	exit;
}

?>