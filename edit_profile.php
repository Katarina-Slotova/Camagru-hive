<?php require_once('header.php'); ?>

	<section class="main">
		<div class="main-wrapper">
			<h1 class="title mb-6">Edit Profile</h1>

			<?php if(isset($_GET['error_message'])){ ?>
				<p class="message is-danger has-text-centered"><?php echo $_GET['error_message']; ?></p>
			<?php } ?>
			
			<form action="update_profile.php" method="POST" enctype="multipart/form-data">
				<div class="mb-3">
					<label for="image" class="label">Profile picture</label>
					<img src="<?php echo "assets/imgs/".$_SESSION['image']; ?>" class="edit-profile-img" alt="profile-img">
					<div class="control">
						<input type="file" class="my-input input" name="image">
					</div>
					<div class="mb-5 field">
						<label for="email" class="label">Email</label>
						<input name="email" class="input" placeholder="Email"></input>
					</div>
					<div class="mb-5">
						<label for="username" class="label">Username</label>
						<input type="text" name="username" id="username" class="input" placeholder="Username"></input>
					</div>
					<div class="mb-5">
						<label for="password" class="label">Password</label>
						<input type="text" name="password" id="password" class="input" placeholder="Password"></input>
					</div>
					<div class="mb-5">
						<label for="bio" class="label">Bio</label>
						<textarea name="bio" id="bio" cols="30" rows="3" class="textarea"><?php echo $_SESSION['bio'];?></textarea>
					</div>
					<div class="mb-5">
						<button name="update_profile_btn" id="update_profile_btn" class="update-profile-btn">Update</button>
					</div>
				</div>
			</form>
		</div>
	</section>
</body>
</html>