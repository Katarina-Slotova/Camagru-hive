<?php

include('connection.php');

if(isset($_POST['delete_post_btn'])){
	$post_id = $_POST['post_id'];

	$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
	$stmt->bind_param("i", $post_id);
	if($stmt->execute()){
		header('location: profile.php?ok_message=Post was deleted.');
	}else{
		header('location: profile.php?error_message=Error occured.');
	}
	exit;
}else{
	header('location: index.php');
	exit;
}

?>