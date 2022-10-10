<?php

session_start();

require_once("connection.php");

if (empty($_SESSION['id'])) {
	header('location: home.php');
	exit;
}

// Check if user clicked the publish button
if(isset($_POST['webcam_img_btn'])){
	$id = $_SESSION['id'];
	$profile_image = $_SESSION['image']; 
	$caption = htmlspecialchars($_POST['caption']);
	$hashtags = htmlspecialchars($_POST['hashtags']);
	$likes = 0;
	$tz = 'Europe/Helsinki';
	$timestamp = time();
	$date = new DateTime("now", new DateTimeZone($tz));
	$date->setTimestamp($timestamp);
	$date = $date->format('Y-m-d H:i:s');
	$username = $_SESSION['username'];
	$webcam = true;

	// Create a unique image name by using strval function that converts the timestamp into a string
	$image_name = strval(time()) . ".jpg";

	if(strlen($caption) > 300 || strlen($hashtags) > 100){
		header('location: camera.php?error_message=Caption or hashtags too long.');
		exit;
	}

	// Grab the photo with the stickers
	$webcam_file = $_POST['webcam_file'];
	list($type, $data_url) = explode(';', $webcam_file);
	list(, $data_url) = explode(',', $data_url); 
	$decoded_url = base64_decode($data_url);
	$destination = imagecreatefromstring($decoded_url);

	$stickers_canvas = $_POST['sticker-canvas'];
	list($type, $data) = explode(';', $stickers_canvas);
	list(, $data) = explode(',', $data); 
	$decoded_stickers_url = base64_decode($data);
	$dest = imagecreatefromstring($decoded_stickers_url);

	imagecopy($destination, $dest, 40, 0, 0, 0, 700, 500);

	// Create post
	try {
		$conn = connect_db();
		$stmt = $conn->prepare("INSERT INTO posts (user_id,likes,image,caption,hashtags,date,username,profile_image,webcam) VALUES (?,?,?,?,?,?,?,?,?)");
		$stmt->bindParam(1, $id, PDO::PARAM_INT);
		$stmt->bindParam(2, $likes, PDO::PARAM_INT);
		$stmt->bindParam(3, $image_name, PDO::PARAM_STR);
		$stmt->bindParam(4, $caption, PDO::PARAM_STR);
		$stmt->bindParam(5, $hashtags, PDO::PARAM_STR);
		$stmt->bindParam(6, $date, PDO::PARAM_STR);
		$stmt->bindParam(7, $username, PDO::PARAM_STR);
		$stmt->bindParam(8, $profile_image, PDO::PARAM_STR);
		$stmt->bindParam(9, $webcam, PDO::PARAM_STR);
		if($stmt->execute()){
			imagepng($destination, "../assets/imgs/".$image_name);
			
			//increase the number of posts and update session with the new number of posts
			try {
				$conn = connect_db();
				$stmt = $conn->prepare("UPDATE users SET posts = posts+1 WHERE id = ?");
				$stmt->bindParam(1, $id, PDO::PARAM_INT);
				$stmt->execute();
			} catch (PDOException $error) {
				echo $error->getMessage(); 
				exit;
			}
			$conn = null;
	
			$_SESSION['posts'] = $_SESSION['posts']+1;
	
			header('location: camera.php?ok_message=Post created&image_name='.$image_name);
			exit;
		}else{
			header('location: camera.php?error_message=Error occured.');
			exit;
		}
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;
}else{
	header('location: camera.php?error_message=Error occured.');
	exit;
}

?>