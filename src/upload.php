<?php

require_once('header.php');
if(!isset($_SESSION['id'])){
	header("location: login.php");
	exit;
}

?>
	<div class="camera-container">
		<?php if(isset($_GET['ok_message'])) { ?>
			<p class="has-text-centered message is-success"><?php echo $_GET['ok_message']?></p>
		<?php } ?>

		<?php if(isset($_GET['error_message'])) { ?>
			<p class="has-text-centered message is-danger"><?php echo $_GET['error_message']?></p>
		<?php } ?>
		<div class="camera">
			<div class="camera-img" style="display:flex;">
			<div style="width:90%;">
				<form action="create_uploaded_post.php" method="POST" enctype="multipart/form-data" class="camera-form">
					<p class="sticker-description">🌟 Your awesome picture 🌟</p>
					<div>
						<img id="picture">
						<canvas class="is-hidden" width="700" height="500" id="myCanvas"></canvas>
						<input type="hidden" id="upload-file" value="" name="upload_file">
					</div>
					<input accept="image/*" type="file" class="my-input input" id="imgInp" name="image" required>
					<div class="control">
						<input type="text" class="my-input input" name="caption" placeholder="Write a caption here" maxlength="300" required>
					</div>
					<div class="control">
						<input type="text" class="my-input input" name="hashtags" placeholder="Add hastags here" maxlength="100" required>
					</div>
					<div>
						<p class="sticker-description">Wanna jazz up your awesome picture? Add a sticker!</p>
						<div class="stickers-box">
							<div class="stickers-container">
								<img class="sticker" src="../assets/stickers/bee.png" alt="bee-sticker" id="sticker1">
								<img class="sticker" src="../assets/stickers/kitten.png" alt="kitten-sticker" id="sticker2">
								<img class="sticker" src="../assets/stickers/monster.png" alt="monster-sticker" id="sticker3">
								<img class="sticker" src="../assets/stickers/so-hot.png" alt="hot-sticker" id="sticker4">
								<img class="sticker" src="../assets/stickers/unicorn.png" alt="unicorn-sticker" id="sticker5">
								<img class="sticker" src="../assets/stickers/watermelon.png" alt="watermalon-sticker" id="sticker6">
							</div>
						</div>
					</div>
					<div>
						<button type="submit" class="upload-btn" name="upload_img_btn">Publish</button>
					</div>
				</form>
			</div>
				<div class="thumbnails-box">
					<p>🌟 Your previous awesome pictures 🌟</p>
						<?php
							 
							require_once('connection.php');
							
							$user_id = $_SESSION['id'];
							$webcam = 0;

							try {
								$conn = connect_db();
								$stmt = $conn->prepare("SELECT * FROM posts WHERE user_id = ? AND webcam = ? ORDER BY date DESC");
								$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
								$stmt->bindParam(2, $webcam, PDO::PARAM_INT);
								$stmt->execute();
								$get_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
							} catch (PDOException $error) {
								echo $error->getMessage(); 
								exit;
							}
							$conn = null;

							foreach($get_posts as $post){ 
						?>
							<img src="<?php echo "../assets/imgs/".$post['image']; ?>" alt="user-post">
						<?php } ?>
							
				</div>
			</div>
		</div>
		<div style="padding-bottom: 20px;">
			<?php require_once('footer.php');?>
		</div>
	</div>

	<script>
		imgInp.onchange = evt => {
			const [file] = imgInp.files;
			let canvas = document.getElementById("myCanvas");
			let ctx = canvas.getContext("2d");
			if (file) {
				picture.src = URL.createObjectURL(file);
				setTimeout(() => {
					if(picture.height < 400)
						alert("Stickers will not show properly on images of this size. Choose a different image if you wish to add stickers.");
					if(picture.width < picture.height){
						let maxHeight = 700;
						let maxWidth = 500;
						if (picture.width > maxWidth || picture.height > maxHeight) {
							let ratio = picture.width/picture.height;
								if(ratio > 1) {
										picture.width = maxWidth;
										picture.height = maxHeight/ratio;
									} else {
										picture.width = maxWidth*ratio;
										picture.height = maxHeight;
									}
						}
					}
				}, 50);
			}
		}

		const filter = document.querySelectorAll(".sticker");

		for(let i=0; i<filter.length; i++){
			filter[i].addEventListener("click", (e) => {
				myCanvas(e.target.id);
			})
		}

		function myCanvas(sticker) {
			let c = document.getElementById("myCanvas");
			let ctx = c.getContext("2d");
			let Selectedsticker = document.getElementById(sticker);
			switch (sticker){
				case 'sticker1':
					ctx.drawImage(Selectedsticker, 30, 40, Selectedsticker.width * 0.8, Selectedsticker.height * 0.8);
					break;
				case 'sticker2':
					ctx.drawImage(Selectedsticker, 300, 40, Selectedsticker.width * 0.8, Selectedsticker.height * 0.8);
					break;
				case 'sticker3':
					ctx.drawImage(Selectedsticker, 150, 200, Selectedsticker.width * 0.8, Selectedsticker.height * 0.8);
					break;
				case 'sticker4':
					ctx.drawImage(Selectedsticker, 150, 80, Selectedsticker.width * 0.8, Selectedsticker.height * 0.8);
					break;
				case 'sticker5':
					ctx.drawImage(Selectedsticker, 30, 200, Selectedsticker.width * 0.8, Selectedsticker.height * 0.8);
					break;
				case 'sticker6':
					ctx.drawImage(Selectedsticker, 300, 200, Selectedsticker.width * 0.8, Selectedsticker.height * 0.8);
					break;
			}
			let canvasUrl = c.toDataURL();
			let finalImage = document.getElementById("upload-file");
			finalImage.value = canvasUrl;
		}
	</script>
</body>
</html>
