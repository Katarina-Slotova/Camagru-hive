<?php

require_once('connection.php');

if(isset($_GET['page_no'])){
	$page_no = htmlspecialchars($_GET['page_no']);
}else{
	$page_no = 1;
}

try {
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT COUNT(*) as all_posts FROM posts WHERE user_id = ?");
	$stmt->bindParam(1, $other_user_id, PDO::PARAM_INT);
	$stmt->execute();
	$all_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
	echo $error->getMessage(); 
	exit;
}
$conn = null;

try {
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY date DESC");
	$stmt->bindParam(1, $other_user_id, PDO::PARAM_INT);
	$stmt->execute();
	$get_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
	echo $error->getMessage(); 
	exit;
}
$conn = null;

?>