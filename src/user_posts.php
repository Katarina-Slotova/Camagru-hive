<?php

require_once('connection.php');

$user_id = $_SESSION['id'];

try {
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY date DESC");
	$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
	$stmt->execute();
	$get_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
	echo $error->getMessage(); 
	exit;
}
$conn = null;

?>