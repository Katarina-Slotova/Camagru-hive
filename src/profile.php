<?php require_once('header.php');

session_start();
if(!isset($_SESSION['id'])){
	header("location: login.php");
	exit;
}

?>

	<header class="profile-header">
		<div class="profile-container">
			<?php if(isset($_GET['ok_message'])){ ?>
				<p class="message is-success has-text-centered"><?php echo $_GET['ok_message']; ?></p>
			<?php } ?>
			<?php if(isset($_GET['error_msg'])){ ?>
				<p class="message is-danger has-text-centered"><?php echo($_GET['error_msg']);?></p>
			<?php } ?>
			<div class="profile">
				<div class="profile-img">
					<img src="<?php echo "../assets/imgs/".$_SESSION['image']; ?>" alt="profile-img"> 
				</div>
				<div class="profile-user-settings">
					<h1 class="profile-user-name"><?php echo $_SESSION['username']; ?></h1>
					<form action="edit_profile.php" method="GET" style="display:inline-block">
						<button class="profile-btn profile-edit-btn" type="submit">Edit profile</button>
					</form>
				</div>
				<div class="profile-stats">
					<ul>
						<li><span class="profile-stat-count"><?php echo $_SESSION['posts']; ?></span> posts</li>
						<form style="display: inline-block" action="my_followers.php" method="POST">
							<li><span class="profile-stat-count"><?php echo $_SESSION['followers']; ?></span> <input type="submit" value="followers" style="background: none; border: none; cursor: pointer; font-family: inherit; font-size:18px; color:rgb(70, 70, 70);"></li>
						</form>
						<form style="display: inline-block" action="my_followings.php" method="POST">
							<li><span class="profile-stat-count"><?php echo $_SESSION['following']; ?></span> <input type="submit" value="following" style="background: none; border: none; cursor: pointer; font-family: inherit; font-size:18px; color:rgb(70, 70, 70);"></li>
						</form>
					</ul>
				</div>
			</div>
			<div class="profile-bio">
				<p><span class="profile-real-name"><?php echo $_SESSION['username']; ?></span></p>
				<p>About me: <?php echo $_SESSION['bio']; ?></p>
			</div>
		</div>
	</header>
	<main>
		<div class="profile-container">
			<div class="gallery">
				<?php require_once('user_posts.php'); ?>
				<?php foreach($get_posts as $post){ ?>
					<div class="gallery-item">
						<img src="<?php echo "../assets/imgs/".$post['image']; ?>" class="gallery-img" alt="user-post">
						<div class="gallery-item-info">
							<ul>
								<li class="gallery-item-style"><span><?php echo $post['likes']; ?></span>
									<i class="lar la-heart"></i>
								</li>
								<li>
									<form action="delete_post.php" method="POST">
										<input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
										<input type="hidden" name="user_id" value="<?php echo $post['user_id']; ?>">
										<input type="hidden" name="my_id" value="<?php echo $_SESSION['id']; ?>">
										<input class="delete-btn" type="submit" name="delete_post_btn" value="Delete">
									</form>
								</li>
							</ul>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</main>
	<div style="padding-bottom: 20px;">
		<?php require_once('footer.php');?>
	</div>
</body>
</html>
