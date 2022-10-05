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
				<h4 class="title is-4 mb-5">Reset your password</h4>
				<form action="reinitialise_pwd.php" method="POST" enctype="multipart/form-data">
					<div class="mb-5">
						<div class="mb-5 field">
							<label for="email" class="label">Email</label>
							<input name="email" class="input" placeholder="Email" required></input>
						</div>
						<div class="mb-5">
							<button name="reset_pwd_btn" id="reset_pwd_btn" class="update-profile-btn">Send me a reinitialisation mail</button>
						</div>
					</div>
				</form>
			</div>
		</section>
		<div style="padding-top:300px;">
			<?php require_once('footer.php');?>
		</div>
	</body>
</html>
