<?php

require_once('connection.php');

if(isset($_GET['page_no'])){
	$page_no = htmlspecialchars($_GET['page_no']);
}else{
	$page_no = 1;
}

try {
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT * FROM posts");
	$stmt->execute();
	$all_posts = $stmt->fetchAll();
} catch (PDOException $error) {
	echo $error->getMessage(); 
	exit;
}
$conn = null;

$posts_per_page = 5;
// where to continue posting the posts on the main feed
$offset = ($page_no - 1) * $posts_per_page;
$all_pages = ceil(count($all_posts) / $posts_per_page);

try {
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT * FROM posts ORDER BY date DESC LIMIT $offset, $posts_per_page");
	$stmt->execute();
	$posts = $stmt->fetchAll();
} catch (PDOException $error) {
	echo $error->getMessage(); 
	exit;
}
$conn = null;

?>