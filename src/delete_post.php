<?php

session_start();

require_once('connection.php');

if(isset($_POST['delete_post_btn']) && !empty($_POST['post_id']) && !empty($_POST['my_id']) && !empty($_POST['user_id']) && $_SESSION['id']){
	$post_id = $_POST['post_id'];
	$my_id = $_POST['my_id']; // ID FROM SESSION, I.E. ID OF USER CURRENTLY LOGGED IN
	$user_id = $_POST['user_id']; // ID OF AUTHOR OF THE POST

	try{
		$conn = connect_db();
		$stmt = $conn->prepare("SELECT * FROM posts WHERE user_id = ? AND id = ?");
		$stmt->bindParam(1, $my_id, PDO::PARAM_INT);
		$stmt->bindParam(2, $post_id, PDO::PARAM_INT);
		$stmt->execute();
		$post_from_db = $stmt->fetch(PDO::FETCH_ASSOC);
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}

	if ($post_id == $post_from_db['id'] && $_SESSION['id'] == $user_id){
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
				header('location:'.$_SERVER['HTTP_REFERER']);
			}else{
				header('location:'.$_SERVER['HTTP_REFERER'].'?error_message=Error occured.');
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