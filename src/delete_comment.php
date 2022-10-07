<?php

session_start();

require_once('connection.php');

if(isset($_POST['delete_comment_btn']) && $_SESSION['id']){
	$comment_id = $_POST['comment_id'];
	$post_id = $_POST['post_id'];
	$user_id = $_POST['user_id'];
	$session_id = $_SESSION['id'];

	try{
		$conn = connect_db();
		$stmt = $conn->prepare("SELECT * FROM comments WHERE user_id = ? AND id = ?");
		$stmt->bindParam(1, $session_id, PDO::PARAM_INT);
		$stmt->bindParam(2, $comment_id, PDO::PARAM_INT);
		$stmt->execute();
		$comment_from_db = $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}

	if (isset($_POST['delete_comment_btn']) && $comment_id == $comment_from_db['id'] && $_SESSION['id'] == $user_id){
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
	} else {
		header('location: home.php?error_message=You are not authorized to perform this operation.');
		exit;
	}
}else{
	header('location: home.php');
	exit;
}

?>