<?php

include('connection.php');

if(isset($_GET['page_no']) && $_GET['page_no'] != ""){
	$page_no = $_GET['page_no'];
}else{
	$page_no = 1;
}

$stmt = $conn->prepare("SELECT COUNT(*) as all_posts FROM posts WHERE user_id = ?");
$stmt->bind_param("i", $other_user_id);
$stmt->execute();
$stmt->bind_result($all_posts);
$stmt->store_result();
$stmt->fetch();

$posts_per_page = 6;
// where to continue posting the posts on the main feed
$offset = ($page_no - 1) * $posts_per_page;
$all_pages = ceil($all_posts / $posts_per_page);

$stmt = $conn->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY date DESC LIMIT $offset, $posts_per_page");
$stmt->bind_param("i", $other_user_id);
$stmt->execute();
$get_posts = $stmt->get_result();

/* include('connection.php');

$user_id = $other_user_id;

$stmt = $conn->prepare("SELECT * FROM posts WHERE user_id = ? LIMIT 6");
$stmt->bind_param("i", $user_id);
if($stmt->execute()){
	$get_posts = $stmt->get_result(); // Get result from prepared statement
}else{
	$get_posts = [];
}
 */
?>