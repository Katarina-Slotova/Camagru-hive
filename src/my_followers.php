<?php require_once('header.php');?>

<?php

require_once('connection.php');

if (empty($_SESSION['id'])) {
	header('location: login.php');
	exit;
}

$user_id = $_SESSION['id'];

try {

	// Get all my followers from followings table in db
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT user_id FROM followings WHERE other_user_id = ?");
	$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
	$stmt->execute();

	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			foreach($row as $r){
				$ids_array[] = $r;
			}
	}

	if(empty($ids_array)){
		$info = "You do not have any followers yet.";
	}else{
		$followers_ids = join(",", $ids_array);
		
		$conn = connect_db();
		$stmt = $conn->prepare("SELECT * FROM users WHERE id in ($followers_ids)");
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
							<form action="user_profile.php" method="POST">
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
<?php } catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;
?>
</body>
</html>