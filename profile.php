<?php include('header.php'); ?>

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
										<li class="gallery-item-style"><span><?php echo $post['likes'];?></span>
											<i class="lar la-heart"></i>
										</li>
										<li class="gallery-item-style"><span></span>
											<i class="las la-comments"></i>
										</li>
										<li>
											<form action="delete_post.php" method="POST">
												<input type="hidden" name="post_id" value="<?php echo $post['id'];?>">
												<input type="hidden" name="my_id" value="<?php echo $_SESSION['id'];?>">
												<input class="delete-btn" type="submit" name="delete_post_btn" value="Delete">
											</form>
										</li>
									</ul>
								</div>
						</div>
				<?php } ?>
			</div>
			<nav class="pagination mt-6" role="navigation" aria-label="pagination">
				<ul class="my-pagination-list" class="pagination-list">
					<li class="my-pagination">
						<a <?php if($page_no <= 1){echo 'is-disabled';}?> class="pagination-previous" title="This is the first page" href="<?php if($page_no <= 1){echo '#';}else{echo '?page_no='.$page_no-1;}?>">Previous</a>
					</li>
					<li>
						<a class="pagination-link" aria-label="Page 1" aria-current="page" href="?page_no=1">1</a>
					</li>
					<li>
						<a class="pagination-link" aria-label="Goto page 2" href="?page_no=2">2</a>
					</li>
					<li>
						<a class="pagination-link" aria-label="Goto page 3" href="?page_no=3">3</a>
					</li>
					<?php if($page_no >= 3){ ?>
						<li>
							<a class="pagination-link" aria-label="Pages after page 3" href="#">...</a>
						</li>
						<li>
							<a class="pagination-link" aria-label="Goto pages after page 3" href="<?php echo "?page_no=".$page_no; ?>"></a>
						</li>
					<?php } ?>
					<li class="my-pagination">
						<a <?php if($page_no >= $all_posts){echo 'is-disabled';}?> class="pagination-next" href="<?php if($page_no >= $all_posts){echo '#';}else{echo '?page_no='.$page_no+1;}?>">Next</a>
					</li>
				</ul>
			</nav>
		</div>
	</main>
</body>
</html>
