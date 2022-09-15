<?php

include('connection.php');

if(isset($_POST['delete_comment_btn'])){
	$comment_id = $_POST['comment_id'];
	$post_id = $_POST['post_id'];

	$stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
	$stmt->bind_param("i", $comment_id);
	if($stmt->execute()){
		header('location: index.php?ok_message=Comment was deleted.');
	}else{
		header('location: index.php?error_message=Error occured.');
	}
	exit;
}else{
	header('location: index.php');
	exit;
}

?>