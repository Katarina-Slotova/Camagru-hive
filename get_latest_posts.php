<?php

include('connection.php');

if(isset($_GET['page_no']) && $_GET['page_no'] != ""){
	$page_no = $_GET['page_no'];
}else{
	$page_no = 1;
}

$stmt = $conn->prepare("SELECT COUNT(*) as all_posts FROM posts");
$stmt->execute();
$stmt->bind_result($all_posts);
$stmt->store_result();
$stmt->fetch();

$posts_per_page = 5;
// where to continue posting the posts on the main feed
$offset = ($page_no - 1) * $posts_per_page;
$all_pages = ceil($all_posts / $posts_per_page);

$stmt = $conn->prepare("SELECT * FROM posts LIMIT $offset, $posts_per_page");
$stmt->execute();
$posts = $stmt->get_result();

?>