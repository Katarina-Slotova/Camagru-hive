<?php 

session_start();
// Check if user is logged in by checking whether the user id is in session
/* if(isset($_SESSION['id'])){
	header('location: home.php');
	exit;
} */

?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style type="text/css"></style>
		<link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
		<link rel="stylesheet" href="assets/line-awesome/css/line-awesome.min.css"> 
		<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
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
							<img src="assets/imgs/camagru_logo.png" class="logo-img" alt="camagru-logo">
						</div>
						<form class="login-form" id="login_form" method="POST" action="process_login.php">
							<?php if(isset($_GET['error_msg'])){ ?>
								<p id="error_msg" class="message is-danger has-text-centered"><?php echo($_GET['error_msg']);?></p>
							<?php } ?>
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
							<div class="btn-part">
								<button type="submit" name="login_btn" class="login-btn" id="login_btn">Log in</button>
							</div>
						</form>
						<div class="not-user-yet">
							<hr>
							<p>Not a user yet? <a href="signup.php">Create an account!</a></p>
						</div>
						<hr>
						<div class="">
							<a href="reset_password.php">Did you forget your password?</a>
						</div>
					</div>
				</div>
			</div>
			<div class="my-footer">
				<p><em>Made with ❤️ by Katarina Slotova. Hive Helsinki 2022.</em></p>
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