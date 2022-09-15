<?php include('header.php');?>

<?php 

include('connection.php');

if(isset($_POST['other_user_id']) || isset($_SESSION['other_user_id'])){
	if(isset($_POST['other_user_id'])){
		$other_user_id = $_POST['other_user_id'];
		$_SESSION['other_user_id'] = $other_user_id;
	}else{
		$other_user_id = $_SESSION['other_user_id'];
	}
	$stmt = $conn->prepare('SELECT * FROM users WHERE id = ?');
	$stmt->bind_param("i", $other_user_id);
	if($stmt->execute()){
		$result = $stmt->get_result();
		$user = $result->fetch_assoc();
	}else{
		header('location: index.php');
		exit;
	}
}

?>

	<header class="profile-header">
		<div class="profile-container">
				<div class="profile">
					<div class="profile-img">
						<img src="<?php echo "assets/imgs/".$user['image'];?>" alt="profile-picture">
					</div>
					<div class="profile-user-settings">
						<h1 class="profile-user-name"><?php echo $user['username'];?></h1>
					</div>
					<div class="profile-stats">
						<ul>
							<li><span class="profile-stat-count"><?php echo $user['posts'];?></span> posts</li>
							<li><span class="profile-stat-count"><?php echo $user['followers'];?></span> followers</li>
							<li><span class="profile-stat-count"><?php echo $user['following'];?></span> following</li>
						</ul>
						<form action="follow_user.php" method="POST">
							<input type="hidden" name="other_user_id" value="<?php echo $user['id']; ?>">
							<button class="follow-btn" type="submit" name="follow_btn">Follow</button>
						</form>
					</div>
				</div>
				<div class="profile-bio">
					<p><span class="profile-real-name"><?php echo $user['username'];?></span><?php echo $user['bio'];?></p>
				</div> 
		</div>
	</header>
	<main>
		<div class="profile-container">
			<div class="gallery">
			<?php include('other_user_posts.php'); ?>
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
				<nav class="pagination mt-6" role="navigation" aria-label="pagination">
					<ul class="my-pagination-list" class="pagination-list">
						<li class="my-pagination">
							<a <?php if($page_no <= 1){echo 'is-disabled';}?> class="pagination-previous" title="This is the first page" href="<?php if($page_no <= 1){echo '#';}else{echo '?page_no='.$page_no-1;}?>">Previous</a>
						</li>
						<li>
							<a class="pagination-link is-current" aria-label="Page 1" aria-current="page" href="?page_no=1">1</a>
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
		</div>
	</main>
</body>
</html>