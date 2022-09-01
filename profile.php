<?php include('header.php'); ?>

	<header class="profile-header">
		<div class="profile-container">
			<?php if(isset($_GET['ok_message'])){ ?>
				<p class="is-success has-text-centered"><?php echo $_GET['ok_message']; ?></p>
			<?php } ?>
			<div class="profile">
				<div class="profile-img">
					<img src="<?php echo "assets/imgs/".$_SESSION['image']; ?>" alt=""> 
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
						<li><span class="profile-stat-count"><?php echo $_SESSION['followers']; ?></span> followers</li>
						<li><span class="profile-stat-count"><?php echo $_SESSION['following']; ?></span> following</li>
					</ul>
				</div>
			</div>
			<div class="profile-bio">
				<p><span class="profile-real-name"><?php echo $_SESSION['username']; ?></span></p>
				<p>About me: <?php echo $_SESSION['bio']?></p>
			</div>
		</div>
	</header>
	<main>
		<div class="profile-container">
			<div class="gallery">
			<?php include('user_posts.php'); ?>
				<?php foreach($get_posts as $post){ ?>
					<div class="gallery-item">
					<img src="<?php echo "assets/imgs/".$post['image']; ?>" class="gallery-img" alt="user-post">
						<div class="gallery-item-info">
							<ul>
								<li class="gallery-item-likes"><span><?php echo $post['likes'];?></span>
									<i class="lar la-heart"></i>
								</li>
								<li class="gallery-item-comments"><span></span>
									<i class="las la-comments"></i>
								</li>
							</ul>
						</div>
					</div>
			<?php } ?>
			</div>
		</div>
	</main>
</body>
</html>
