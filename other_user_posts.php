<?php

require_once('connection.php');

if(isset($_GET['page_no'])){
	$page_no = $_GET['page_no'];
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

$posts_per_page = 6;
// where to continue posting the posts on the main feed
$offset = ($page_no - 1) * $posts_per_page;
//$all_pages = ceil($all_posts / $posts_per_page);

try {
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY date DESC LIMIT $offset, $posts_per_page");
	$stmt->bindParam(1, $other_user_id, PDO::PARAM_INT);
	$stmt->execute();
	$get_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
	echo $error->getMessage(); 
	exit;
}
$conn = null;

?>