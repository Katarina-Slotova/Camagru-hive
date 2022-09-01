<?php

include('connection.php');

$user_id = $_SESSION['id'];

$stmt = $conn->prepare("SELECT * FROM posts WHERE user_id = ? LIMIT 6");
$stmt->bind_param("i", $user_id);
if($stmt->execute()){
	$get_posts = $stmt->get_result(); // Get result from prepared statement
}else{
	$get_posts = [];
}

?>