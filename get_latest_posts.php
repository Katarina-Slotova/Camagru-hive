<?php

require_once('connection.php');

if(isset($_GET['page_no']) && $_GET['page_no'] != ""){
	$page_no = $_GET['page_no'];
}else{
	$page_no = 1;
}

try {
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT COUNT(*) as all_posts FROM posts");
	$stmt->execute();
	$all_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
/* 	$stmt->bind_result($all_posts);
	$stmt->store_result();
	$stmt->fetch(); */
} catch (PDOException $error) {
	echo $error->getMessage(); 
	exit;
}
$conn = null;

$posts_per_page = 5;
// where to continue posting the posts on the main feed
$offset = ($page_no - 1) * $posts_per_page;
//$all_pages = ceil($all_posts / $posts_per_page);

try {
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT * FROM posts ORDER BY date DESC LIMIT $offset, $posts_per_page");
	$stmt->execute();
	$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
	echo $error->getMessage(); 
	exit;
}
$conn = null;

?>