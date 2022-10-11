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
		<title>Log in</title>
	</head>
	<body>
		<?php if(isset($_GET['ok_message'])) { ?>
			<p class="has-text-centered message is-success"><?php echo $_GET['ok_message']?></p>
		<?php } ?>

		<?php if(isset($_GET['error_message'])) { ?>
			<p class="has-text-centered message is-danger"><?php echo $_GET['error_message']?></p>
		<?php } ?>

		<div class="container">
			<div class="main-container">
				<div class="form-container">
					<div class="form-content box">
						<div class="logo">
							<img src="../assets/imgs/camagru_logo.png" class="logo-img" alt="camagru-logo">
						</div>
						<form class="login-form" id="login_form" method="POST" action="process_login.php">
							<?php if(isset($_GET['error_msg'])){ ?>
								<p id="error_msg" class="message is-danger has-text-centered"><?php echo($_GET['error_msg']);?></p>
							<?php } ?>
							<div class="form-info">
								<div class="login-input">
									<input type="text" name="username" placeholder="Your username" maxlength="30" required>
								</div>
							</div>
							<div class="form-info">
								<div class="login-input">
									<input type="password" name="password" id="password" placeholder="Your password" required>
								</div>
							</div>
							<div class="btn-part">
								<button type="submit" name="login_btn" class="login-btn" id="login_btn">Log in</button>
							</div>
						</form>
						<div class="has-text-centered">
							<hr>
							<a href="reset_password.php">Did you forget your password?</a>
						</div>
						<div class="not-user-yet has-text-centered">
							<hr>
							<p>Not a user yet? <a href="signup.php">Create an account!</a></p>
						</div>
					</div>
				</div>
			</div>
			<div style="padding-bottom: 20px;">
				<?php require_once('footer.php');?>
			</div>
		</div>

		<script>
			function verifyForm(){
				var password = document.getElementById('password').value;
				var error_msg = document.getElementById('error_msg');

				if (password.length < 8){
					error_msg.innerHTML = "Password is shorter than 8 characters."
					return false;
				}
				return true;
			}
		</script>
	</body>
</html>