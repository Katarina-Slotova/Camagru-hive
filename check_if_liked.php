<?php

require_once('connection.php');

$user_id = $_SESSION['id'];
$post_id = $post['id'];

try{ 
	// check if user liked this post
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
	$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
	$stmt->bindParam(2, $post_id, PDO::PARAM_INT);
	$stmt->execute();
	
	if ($stmt->fetch()){
		$post_liked = true;
	}else{
		$post_liked = false;
	}
} catch (PDOException $error) {
	echo $error->getMessage(); 
	exit;
}
$conn = null;


?>