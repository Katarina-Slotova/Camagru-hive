<?php

session_start();

include('connection.php');

if(isset($_POST['delete_post_btn'])){
	$post_id = $_POST['post_id'];
	$my_id = $_POST['my_id'];

	$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
	$stmt->bind_param("i", $post_id);

	// lower the amount of posts 
	$stmt1 = $conn->prepare("UPDATE users SET posts = posts-1 WHERE id = ?");
	$stmt1->bind_param("i", $my_id);

	if($stmt->execute() && $stmt1->execute()){
		$_SESSION['posts'] = $_SESSION['posts']-1;
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