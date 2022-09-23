<?php

session_start();

require_once('connection.php');

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
		header('location: home.php?post_id='.$post_id.'error_message=Comment too long');
		exit;
	}
	try{
		$conn = connect_db();
		$stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, username, profile_image, comment_text, date) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bindParam(1, $post_id, PDO::PARAM_INT);
		$stmt->bindParam(2, $user_id, PDO::PARAM_INT);
		$stmt->bindParam(3, $username, PDO::PARAM_STR);
		$stmt->bindParam(4, $profile_image, PDO::PARAM_STR);
		$stmt->bindParam(5, $text, PDO::PARAM_STR);
		$stmt->bindParam(6, $date, PDO::PARAM_STR);
		if($stmt->execute()){
			header('location: home.php?post_id='.$post_id.'ok_message=Comment posted');
		}else{
			header('location: home.php?post_id='.$post_id.'error_message=Comment posting failed');
		}
		exit;
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;
}else{
	header('location: home.php?post_id='.$post_id.'error_message=Error occured');
	exit;
}




?>