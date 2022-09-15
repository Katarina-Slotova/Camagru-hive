<?php

session_start();

include('connection.php');

if(isset($_POST['comment_btn'])){
	$post_id = $_POST['post_id'];
	$user_id = $_SESSION['id'];
	$username = $_SESSION['username'];
	$profile_image = $_SESSION['image'];
	$text = $_POST['text'];
	$tz = 'Europe/Helsinki';
	$timestamp = time();
	$date = new DateTime("now", new DateTimeZone($tz));
	$date->setTimestamp($timestamp);
	$date = $date->format('Y-m-d H:i:s');

	if(strlen($text) > 20){
		header('location: index.php?post_id='.$post_id.'error_message=Comment too long');
		exit;
	}
	
	$stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, username, profile_image, text, date) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("iissss", $post_id, $user_id, $username, $profile_image, $text, $date);
	if($stmt->execute()){
		header('location: index.php?post_id='.$post_id.'ok_message=Comment posted');
	}else{
		header('location: index.php?post_id='.$post_id.'error_message=Comment posting failed');
	}
	exit;
}else{
	header('location: index.php?post_id='.$post_id.'error_message=Error occured');
	exit;
}




?>