<?php require_once('header.php');?>

<?php

require_once('connection.php');

$user_id = $_SESSION['id'];

// Get all my followers from followings table in db
try{
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT other_user_id FROM followings WHERE user_id = ?");
	$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
	$stmt->execute();

	while($row = $stmt->fetch(PDO::FETCH_NUM)){
		foreach($row as $r){
			$ids_array[] = $r;
		}
	}

	if(empty($ids_array)){
		$info = "You are not following anyone yet.";
	}else{
		$following_ids = join(",", $ids_array);
		
		try{
			$conn = connect_db();
			$stmt = $conn->prepare("SELECT * FROM users WHERE id in ($following_ids)");
			$stmt->execute();
			$users = $stmt->fetchAll(PDO::FETCH_ASSOC); 
		} catch (PDOException $error) {
			echo $error->getMessage(); 
			exit;
		}
		$conn = null;
	}
} catch (PDOException $error) {
	echo $error->getMessage(); 
	exit;
}
$conn = null;

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
</body>
</html>