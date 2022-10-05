<?php require_once('header.php');?>

<?php 

require_once('connection.php');

if(isset($_POST['other_user_id']) || isset($_SESSION['other_user_id'])){
	if(isset($_POST['other_user_id'])){
		$other_user_id = $_POST['other_user_id'];
		$_SESSION['other_user_id'] = $other_user_id;
	}else{
		$other_user_id = $_SESSION['other_user_id'];
	}

	try {
		$conn = connect_db();
		$stmt = $conn->prepare('SELECT * FROM users WHERE id = ?');
		$stmt->bindParam(1, $other_user_id, PDO::PARAM_INT);
		if($stmt->execute()){
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
		}else{
			header('location: home.php');
			exit;
		}
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;
}

?>

	<header class="profile-header">
		<div class="profile-container">
			<?php if(isset($_GET['ok_message'])){ ?>
				<p class="message is-success has-text-centered"><?php echo $_GET['ok_message']; ?></p>
			<?php } ?>
				<div class="profile">
					<div class="profile-img">
						<img src="<?php echo "../assets/imgs/".$user['image'];?>" alt="profile-picture">
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
						<?php require_once('following_status.php'); ?>
						<?php if($following){ ?>
							<form action="unfollow_user.php" method="POST">
								<input type="hidden" name="other_user_id" value="<?php echo $user['id']; ?>">
								<button class="follow-btn" type="submit" name="unfollow_btn">Unfollow</button>
							</form>
						<?php }else{ ?>
							<form action="follow_user.php" method="POST">
								<input type="hidden" name="other_user_id" value="<?php echo $user['id']; ?>">
								<button class="follow-btn" type="submit" name="follow_btn">Follow</button>
							</form>
						<?php } ?>
					</div>
				</div>
				<div class="profile-bio">
					<p class="profile-real-name"><?php echo $user['username']; ?></p>
					<p><?php echo $user['bio']; ?></p>
				</div> 
		</div>
	</header>
	<main>
		<div class="profile-container">
			<div class="gallery">
			<?php require_once('other_user_posts.php'); ?>
				<?php foreach($get_posts as $post){ ?>
					<div class="gallery-item">
						<img src="<?php echo "../assets/imgs/".$post['image']; ?>" class="gallery-img" alt="user-post">
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
		<div style="padding-bottom: 20px;">
			<?php require_once('footer.php');?>
		</div>
	</main>
</body>
</html>