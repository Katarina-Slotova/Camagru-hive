<?php

require_once('connection.php');

if(isset($_POST['delete_comment_btn'])){
	$comment_id = $_POST['comment_id'];
	$post_id = $_POST['post_id'];

	try {
		$conn = connect_db();
		$stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
		$stmt->bindParam(1, $comment_id, PDO::PARAM_INT);
		if($stmt->execute()){
			header('location:'.$_SERVER['HTTP_REFERER']);
		}else{
			header('location:'.$_SERVER['HTTP_REFERER']);
		}
		exit;
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;
}else{
	header('location: home.php');
	exit;
}

?>