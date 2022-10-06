<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css"></style>
	<link rel="stylesheet" href="../assets/css/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
	<link rel="stylesheet" href="../assets/line-awesome/css/line-awesome.min.css"> 
	<link rel="icon" type="image/png" sizes="16x16" href="../assets/imgs/favicon-16x16.png">
	<title>Sign in</title>
</head>
<body>
	<div class="container">
		<div class="main-container">
			<div class="form-container">
				<div class="form-content box">
					<div class="logo">
						<img src="../assets/imgs/camagru_logo.png" class="logo-img" alt="camagru-logo">
					</div>
					<form class="login-form" id="signup_form" action="process_signup.php" method="POST">
						<?php if(isset($_GET['error_message'])){ ?>
							<p id="error_message" class="message is-danger has-text-centered"><?php echo $_GET['error_message'];?></p>
						<?php } ?>
						<div class="form-info">
							<div class="login-input">
								<input type="text" name="username" placeholder="Your username" required>
							</div>
						</div>
						<div class="form-info">
							<div class="login-input">
								<input type="email" name="email" placeholder="Your email" required>
							</div>
						</div>
						<div class="form-info">
							<div class="login-input">
								<input type="password" name="password" id="password" placeholder="Your password" required>
							</div>
						</div>
						<div class="form-info">
							<div class="login-input">
								<input type="password" name="password_conf" id="password_conf" placeholder="Your password again" required>
							</div>
						</div>
						<div class="btn-part">
							<button type="submit" name="signup_btn" class="login-btn" id="signup_btn" value="signup">Sign up</button>
						</div>
					</form>
					<div class="not-user-yet">
						<hr>
						<p>Already a user? <a href="login.php">Log in!</a></p>
					</div>
				</div>
			</div>
		</div>
		<div style="padding-bottom: 20px;">
			<?php require_once('footer.php');?>
		</div>
	</div>
</body>
</html>