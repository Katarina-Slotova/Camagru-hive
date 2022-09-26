<?php

require_once('header.php');

?>
	<div class="camera-container">
		<?php if(isset($_GET['ok_message'])) { ?>
			<p class="has-text-centered message is-success"><?php echo $_GET['ok_message']?></p>
		<?php } ?>

		<?php if(isset($_GET['error_message'])) { ?>
			<p class="has-text-centered message is-danger"><?php echo $_GET['error_message']?></p>
		<?php } ?>
		<div class="camera">
			<div class="camera-img">
				<form runat="server" action="create_uploaded_post.php" method="POST" enctype="multipart/form-data" class="camera-form">
					<p class="sticker-description">🌟 Your awesome photo 🌟</p>
					<div class="canvas-container">
						<img id="picture">
						<canvas width="700" height="500" id="myCanvas"></canvas>
						<input type="hidden" id="upload-file" value="" name="upload_file">
					</div>
					<input accept="image/*" type="file" class="my-input input" id="imgInp" name="image" required>
					<div class="control">
						<input type="text" class="my-input input" name="caption" placeholder="Write a caption here" required>
					</div>
					<div class="control">
						<input type="text" class="my-input input" name="hashtags" placeholder="Add hastags here" required>
					</div>
					<div>
						<p class="sticker-description">Wanna jazz up your awesome photo? Add a sticker!</p>
						<div class="stickers-box">
							<div class="stickers-container">
								<img class="sticker" src="assets/stickers/bee.png" alt="bee-sticker" id="sticker1">
								<img class="sticker" src="assets/stickers/kitten.png" alt="kitten-sticker" id="sticker2">
								<img class="sticker" src="assets/stickers/monster.png" alt="monster-sticker" id="sticker3">
								<img class="sticker" src="assets/stickers/so-hot.png" alt="hot-sticker" id="sticker4">
								<img class="sticker" src="assets/stickers/unicorn.png" alt="unicorn-sticker" id="sticker5">
								<img class="sticker" src="assets/stickers/watermelon.png" alt="watermalon-sticker" id="sticker6">
							</div>
						</div>
					</div>
					<div>
						<button type="submit" class="upload-btn" name="upload_img_btn">Publish</button>
					</div>
				</form>
			</div>
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
					ctx.drawImage(Selectedsticker, 30, 40, Selectedsticker.width * 1.20, Selectedsticker.height * 1.20);
					break;
				case 'sticker2':
					ctx.drawImage(Selectedsticker, 300, 40, Selectedsticker.width * 1.20, Selectedsticker.height * 1.20);
					break;
				case 'sticker3':
					ctx.drawImage(Selectedsticker, 150, 200, Selectedsticker.width * 1.20, Selectedsticker.height * 1.20);
					break;
				case 'sticker4':
					ctx.drawImage(Selectedsticker, 150, 80, Selectedsticker.width * 1.20, Selectedsticker.height * 1.20);
					break;
				case 'sticker5':
					ctx.drawImage(Selectedsticker, 30, 200, Selectedsticker.width * 1.20, Selectedsticker.height * 1.20);
					break;
				case 'sticker6':
					ctx.drawImage(Selectedsticker, 300, 200, Selectedsticker.width * 1.20, Selectedsticker.height * 1.20);
					break;
			}
			let canvasUrl = c.toDataURL();
			let finalImage = document.getElementById("upload-file");
			finalImage.value = canvasUrl;
		}

	</script>
</body>
</html>
