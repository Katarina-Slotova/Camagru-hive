<?php

session_start();

require_once('connection.php');

if(isset($_POST['delete_post_btn'])){
	$post_id = $_POST['post_id'];
	$my_id = $_POST['my_id'];

	try {
		$conn = connect_db();
		$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
		$stmt->bindParam(1, $post_id, PDO::PARAM_INT);
	
		// lower the amount of posts 
		$conn = connect_db();
		$stmt1 = $conn->prepare("UPDATE users SET posts = posts-1 WHERE id = ?");
		$stmt1->bindParam(1, $my_id, PDO::PARAM_INT);
	
		if($stmt->execute() && $stmt1->execute()){
			$_SESSION['posts'] = $_SESSION['posts']-1;
			header('location:'.$_SERVER['HTTP_REFERER'].'&ok_message=Post was deleted.');
		}else{
			header('location:'.$_SERVER['HTTP_REFERER'].'&error_message=Error occured.');
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