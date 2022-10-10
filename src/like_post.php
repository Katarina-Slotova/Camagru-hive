<?php 

session_start();

require_once('connection.php');

if(isset($_POST['like_btn']) && !empty($_POST['post_id'])){
	$user_id = $_SESSION['id'];
	$post_id = $_POST['post_id'];

	try{
		// link the user and the post that is being liked
		$conn = connect_db();
		$stmt = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
		$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
		$stmt->bindParam(2, $post_id, PDO::PARAM_INT);

		// increase the likes
		$stmt1 = $conn->prepare("UPDATE posts SET likes=likes+1 WHERE id = ?");
		$stmt1->bindParam(1, $post_id, PDO::PARAM_INT);

		$stmt->execute();
		$stmt1->execute();
		
		header('location:'.$_SERVER['HTTP_REFERER']);
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;
}else{
	header('location:'.$_SERVER['HTTP_REFERER']);
}



?>