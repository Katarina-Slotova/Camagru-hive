<?php include('header.php');?>

<?php

include('connection.php');

$user_id = $_SESSION['id'];

// Get all my followers from followings table in db 
$stmt = $conn->prepare("SELECT user_id FROM followings WHERE other_user_id = ?");
$stmt->bind_param("i", $find_this);
$stmt->execute();

// Store the ids in an array  
$ids_array = array();
$result = $stmt->get_result();
while($row = $result->fetch_array(MYSQLI_NUM)){
	foreach($row as $r){
		$ids_array[] = $r;
	}
}


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
	
	$stmt = $conn->prepare("SELECT COUNT(*) as all_users FROM users WHERE id in ($followers_ids)");
	$stmt->execute();
	$stmt->bind_result($all_users);
	$stmt->store_result();
	$stmt->fetch();
	
	$users_per_page = 2;
	// where to continue posting the posts on the main feed
	$offset = ($page_no - 1) * $users_per_page;
	$all_pages = ceil($all_users / $users_per_page);
	
	$stmt = $conn->prepare("SELECT * FROM users WHERE id in ($followers_ids) LIMIT $offset, $users_per_page");
	$stmt->execute();
	$users = $stmt->get_result(); 
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
					<img src="<?php echo "assets/imgs/".$user['image']; ?>" alt="profile-img">
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
</body>
</html>