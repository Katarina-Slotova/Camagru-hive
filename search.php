<?php include('header.php');?>

<?php

include('connection.php');

if(isset($_POST['search_input'])){
	$search_input = $_POST['search_input'];
	$find_this = strval("%".$search_input."%");

	$stmt = $conn->prepare("SELECT * FROM users WHERE username like ? LIMIT 10");
	$stmt->bind_param("s", $find_this);
	$stmt->execute();
	$results = $stmt->get_result();
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
				<li class="list-item search-result-item">
					<img src="<?php echo "assets/imgs/".$user['image']; ?>" alt="profile-img">
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
		</ul>
	</div>

</body>
</html>