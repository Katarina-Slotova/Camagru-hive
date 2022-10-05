<?php require_once('header.php');?>

<?php

require_once('connection.php');

if(isset($_POST['search_input'])){
	$search_input = $_POST['search_input'];
	$find_this = strval("%".$search_input."%");

	try{
		$conn = connect_db();
		$stmt = $conn->prepare("SELECT * FROM users WHERE username like ? LIMIT 10");
		$stmt->bindParam(1, $find_this, PDO::PARAM_STR);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;
}

?>

	<div class="mt-5 mx-5">
		<form action="search.php" method="POST">
			<div class="control search-component">
				<input type="text" class="input" name="search_input" placeholder="Who are you looking for?">
				<button type="submit" class="btn search-btn" name="search_btn">Search</button>
			</div>
		</form>
		<ul class="list">
		<?php if(isset($_POST['search_input'])){?>
			<?php foreach($results as $user){ ?>
				<?php if(($user['id']) != $_SESSION['id']) { ?>
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
	<div style="padding-top: 550px;">
		<?php require_once('footer.php');?>
	</div>

</body>
</html>