<?php 

session_start();

include('connection.php');

if(isset($_POST['like_btn'])){
	$user_id = $_SESSION['id'];
	$post_id = $_POST['post_id'];

	// link the user and the post that is being liked
	$stmt = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
	$stmt->bind_param("ii", $user_id, $post_id);

	// increase the likes
	$stmt1 = $conn->prepare("UPDATE posts SET likes=likes+1 WHERE id = ?");
	$stmt1->bind_param("i", $post_id);

	$stmt->execute();
	$stmt1->execute();

	header('location: index.php?ok_message=Post liked!');
}else{
	header('location: index.php?error_message=Error occured');
}



?>