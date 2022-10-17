<?php require_once('header.php'); 

if (empty($_SESSION['id'])) {
	header('location: login.php');
	exit;
}

?>

	<section class="main">
		<div class="main-wrapper">
			<?php if(isset($_GET['ok_message'])){ ?>
				<p class="has-text-centered message is-success"><?php echo htmlspecialchars($_GET['ok_message'])?></p>
			<?php } ?>
			<?php if(isset($_GET['error_message'])){ ?>
				<p class="message is-danger has-text-centered"><?php echo htmlspecialchars($_GET['error_message'])?></p>
			<?php } ?>
			<h1 class="title is-3 mb-6">Edit Profile</h1>
			<h4 class="title is-4 mb-5">Update your notification preferences</h4>
			<form action="notifications.php" method="POST">
				<div class="mb-5">
					<label for="notification" class="label">Comment Notifications via Email</label>
					<input class="notif-btn" type="submit" name="yes_notif" value="Send notifications" />
					<input class="notif-btn" type="submit" name="no_notif" value="Do not send notifications" />
				</div>
			</form>
			<h4 class="title is-4 mb-5">Update your personal information</h4>
			<form action="update_profile.php" method="POST" enctype="multipart/form-data">
				<div class="mb-5">
					<label for="image" class="label">Profile picture</label>
					<img src="<?php echo "../assets/imgs/".htmlspecialchars($_SESSION['image'])?>" class="edit-profile-img" alt="profile-img">
					<div class="control">
						<input type="file" class="my-input input" name="image">
					</div>
					<div class="mb-5 field">
						<label for="email" class="label">Email</label>
						<input type="email" name="email" class="input" placeholder="Email"></input>
					</div>
					<div class="mb-5">
						<label for="username" class="label">Username</label>
						<input type="text" name="username" id="username" class="input" placeholder="Username" maxlength="30"></input>
					</div>
					<div class="mb-5">
						<label for="password" class="label">Password</label>
						<input type="password" name="password" id="password" class="input" placeholder="Password" maxlength="20"></input>
					</div>
					<div class="mb-5">
						<label for="bio" class="label">Bio</label>
						<textarea name="bio" id="bio" cols="30" rows="3" class="textarea" maxlength="300"><?php echo $_SESSION['bio'];?></textarea>
					</div>
					<div class="mb-5">
						<button name="update_profile_btn" id="update_profile_btn" class="update-profile-btn">Update</button>
					</div>
				</div>
			</form>
		</div>
	</section>
	<div style="padding-bottom: 20px;">
		<?php require_once('footer.php');?>
	</div>
</body>
</html>