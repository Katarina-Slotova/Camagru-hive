<?php require_once('header.php');?>

<?php

require_once('connection.php');

$user_id = $_SESSION['id'];

try {

	// Get all my followers from followings table in db
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT user_id FROM followings WHERE other_user_id = ?");
	$stmt->bindParam(1, $find_this, PDO::PARAM_INT);
	$stmt->execute();
	$ids_array = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if(empty($ids_array)){
		$info = "You do not have any followers yet.";
	}else{
		$followers_ids = join(",", $ids_array);
		
		// Pagination of my followers list 
		if(isset($_GET['page_no']) && $_GET['page_no'] != ""){
			$page_no = $_GET['page_no'];
		}else{
			$page_no = 1;
		}
		
		$conn = connect_db();
		$stmt = $conn->prepare("SELECT COUNT(*) as all_users FROM users WHERE id in ($followers_ids)");
		$stmt->execute();
		$all_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$users_per_page = 2;
		// where to continue posting the posts on the main feed
		$offset = ($page_no - 1) * $users_per_page;
		$all_pages = ceil($all_users / $users_per_page);
		
		$conn = connect_db();
		$stmt = $conn->prepare("SELECT * FROM users WHERE id in ($followers_ids) LIMIT $offset, $users_per_page");
		$stmt->execute();
		$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	?>

		<div class="mt-5 mx-5">
			<ul class="list">
			<?php if (!isset($users)){ ?>
				<p class="has-text-centered" style="font-size:20px"><?php echo $info; ?></p>
			<?php }else{ ?>
				<?php foreach($users as $user){ ?>
					<?php if($user['id'] != $_SESSION['id']){ ?> 
					<li class="list-item search-result-item">
						<img src="<?php echo "../assets/imgs/".$user['image']; ?>" alt="profile-img">
						<div>
							<p><?php echo $user['username']; ?></p>
							<span><?php echo substr($user['bio'],0,20); ?></span>
						</div>
						<div class="search-result-item-btn">
							<form action="user_profile.php" method="POST ">
								<input type="hidden" name="other_user_id" value="<?php echo $user['id']; ?>">
								<button type="submit">See profile</button>
							</form>
						</div>
					</li>
				<?php } ?>
			<?php } ?>
			<?php } ?>
			</ul>
		</div>

		<?php if(isset($users)){ ?>
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
						<a <?php if($page_no >= $all_users){echo 'is-disabled';}?> class="pagination-next" href="<?php if($page_no >= $all_users){echo '#';}else{echo '?page_no='.$page_no+1;}?>">Next</a>
					</li>
				</ul>
			</nav>
		<?php } ?>
<?php } catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;
?>
</body>
</html>