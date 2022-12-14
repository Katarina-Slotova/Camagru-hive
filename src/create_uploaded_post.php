<?php

session_start();

require_once("connection.php");

// Check if user clicked the publish button and the image is not empty
if(isset($_POST['upload_img_btn']) && !empty($_FILES['image']['tmp_name']) && !empty($_POST['caption']) && !empty($_POST['hashtags'])){
	$id = $_SESSION['id'];
	$profile_image = $_SESSION['image']; 
	$image = $_FILES['image']['tmp_name'];
	$ext = pathinfo($image, PATHINFO_EXTENSION);
	$image_size = getimagesize($image);
	$can_upload = 1;
	$caption = htmlspecialchars($_POST['caption']);
	$hashtags = htmlspecialchars($_POST['hashtags']);
	$likes = 0;
	$tz = 'Europe/Helsinki';
	$timestamp = time();
	$date = new DateTime("now", new DateTimeZone($tz));
	$date->setTimestamp($timestamp);
	$date = $date->format('Y-m-d H:i:s');
	$username = $_SESSION['username'];
	$webcam = false;
	// Create a unique image name by using strval function that converts the timestamp into a string
	$image_name = strval(time()) . ".jpg";

	if(strlen($caption) > 300 || strlen($hashtags) > 100){
		header('location: upload.php?error_message=Caption or hashtags too long.');
		exit;
	}

	if($ext != "png" && $ext != "jpg" && $ext != "jpeg") {
		$can_upload = 0;
	}

	if($image_size){
		$can_upload = 1;
	} else {
		$can_upload = 0;
	}

	if($can_upload === 0){
		header('location: upload.php?error_message=File you are trying to upload is not valid.');
		exit;
	} else {
		$max_height = 500;
		$max_width = 500;
		list($orig_width, $orig_height) = getimagesize($image);
		$ratio = $orig_width/$orig_height;
		if($ratio > 1) {
			$width = $max_width;
			$height = $max_height/$ratio;
		} else {
			$width = $max_width*$ratio;
			$height = $max_height;
		}
		$source = imagecreatefromstring(file_get_contents($image));
		$destination = imagecreatetruecolor($width, $height);
		imagecopyresampled($destination, $source, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

		// Grab the stickers, if no stickers selected by user, this if statement will be skipped
		$upload_file = $_POST['upload_file'];
		if($upload_file){
			list($type, $data_url) = explode(';', $upload_file);
			list(, $data_url) = explode(',', $data_url); 
			$decoded_url = base64_decode($data_url);
			$dest = imagecreatefromstring($decoded_url);
			imagecopy($destination, $dest, 0, 0, 25, 30, 700, 500);
		}
	
		if(strlen($caption) > 300 || strlen($hashtags) > 100){
			header('location: upload.php?error_message=Caption or hashtags too long.');
			exit;
		}
		
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
		
				header('location: upload.php?ok_message=Post created&image_name='.$image_name);
				exit;
			}else{
				header('location: upload.php?error_message=Error occured.');
				exit;
			}
		} catch (PDOException $error) {
			echo $error->getMessage(); 
			exit;
		}
		$conn = null;
	}
}else{
	header('location: upload.php?error_message=Error occured.');
	exit;
}

?>