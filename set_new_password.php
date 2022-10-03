<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css"></style>
	<title>Camagru</title>
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
	<link rel="stylesheet" href="assets/line-awesome/css/line-awesome.min.css"> 
	<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
</head>
<html lang="en">
	<body>
		<section class="main">
			<div class="main-wrapper">
				<?php if(isset($_GET['ok_message'])){ ?>
					<p class="has-text-centered message is-success"><?php echo $_GET['ok_message']?></p>
				<?php } ?>
				<?php if(isset($_GET['error_message'])){ ?>
					<p class="message is-danger has-text-centered"><?php echo $_GET['error_message']; ?></p>
				<?php } ?>
				<h4 class="title is-4 mb-5">Set a new password</h4>
				<form action="update_password.php" method="POST" enctype="multipart/form-data">
					<div class="mb-5">
						<div class="mb-5 field">
							<label for="password" class="label">New password</label>
							<input type="password" name="password" class="input" placeholder="New password" required></input>
						</div>
						<div class="mb-5 field">
							<label for="password" class="label">Repeat new password</label>
							<input type="password" name="password_conf" class="input" placeholder="Repeat new password" required></input>
							<input type="hidden" name="email" value="<?php echo $_GET['email'];?>">
						</div>
						<div class="mb-5">
							<button name="new_pwd_btn" id="new_pwd_btn" class="update-profile-btn">Save my new password</button>
						</div>
					</div>
				</form>
			</div>
		</section>
	</body>
</html>
