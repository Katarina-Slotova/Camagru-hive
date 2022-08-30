<?php

session_start();

if(!isset($_SESSION['id'])){
	header('location: login.php');
	exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css"></style>
	<title>Camagru</title>
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
	<link rel="stylesheet" href="assets/line-awesome/css/line-awesome.min.css"> 
	<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
</head>
<body>
	<nav class="navbar">
		<div class="navbar-wrapper">
			<img src="assets/imgs/camagru_logo.png" class="logo">
			<form>
				<input type="text" class="search-box" placeholder="Search">
			</form>
			<div class="nav-items">
				<i class="icon las la-home"></i>
				<i class="icon las la-plus"></i>
				<i class="icon las la-user"></i>
				<a href="logout.php"><i class="logout icon las la-sign-out-alt"></i></a>
			</div>
		</div>
	</nav>
	<section class="main">
		<div class="main-wrapper">
			<!--FRIENDS AND THEIR STATUS-->
			<div class="status-wrapper">
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
			</div>
			<!--POSTS--->
			<div class="posts">
				<div class="info">
					<div class="user">
						<div class="profile-pic">
							<img src="assets/imgs/dog.png" alt="image">
						</div>
						<p class="usrname">username</p>
					</div>
					<i class="las la-ellipsis-v options"></i>
				</div>
				<!--POST CONTENT-->
				<img class="post-img" src="assets/imgs/flower.jpg" alt="flower">
				<div class="post-content">
					<div class="reaction-wrapper">
						<i class="icon lar la-heart"></i>
						<i class="icon las la-comments"></i>
					</div>
					<p class="likes">1679 likes</p>
					<p class="description"><span>username</span> this is a description</p>
					<p class="time">2028/8/9</p>
				</div>
				<div class="comment-wrapper">
					<img class="icon" src="assets/imgs/dog.png" alt="profile-pic">
					<input class="comment-box" type="text" placeholder="Write a comment">
					<button class="comment-button">Post</button>
				</div>
				<nav class="pagination mt-6" role="navigation" aria-label="pagination">
					<a class="pagination-previous is-disabled" title="This is the first page">Previous</a>
					<a class="pagination-next">Next page</a>
					<ul class="pagination-list">
					  <li>
						<a class="pagination-link is-current" aria-label="Page 1" aria-current="page">1</a>
					  </li>
					  <li>
						<a class="pagination-link" aria-label="Goto page 2">2</a>
					  </li>
					  <li>
						<a class="pagination-link" aria-label="Goto page 3">3</a>
					  </li>
					</ul>
				  </nav>
				<div class="my-footer">
					<p><em>Made with ❤️ by Katarina Slotova. Hive Helsinki 2022.</em></p>
				</div>
			</div>
		</div>
	</section>
</body>
</html>
