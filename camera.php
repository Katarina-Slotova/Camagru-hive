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
				<form runat="server" action="create_camera_post.php" method="POST" enctype="multipart/form-data" class="camera-form">
					<div>
						<p class="sticker-description">1. Choose a sticker to jazz up your awesome photo!</p>
						<div class="stickers-box">
							<div class="stickers-container">
								<img name="bee" class="sticker" src="assets/stickers/bee.png" alt="bee-sticker" id="sticker1">
								<img class="sticker" src="assets/stickers/kitten.png" alt="kitten-sticker" id="sticker2">
								<img class="sticker" src="assets/stickers/monster.png" alt="monster-sticker" id="sticker3">
								<img class="sticker" src="assets/stickers/so-hot.png" alt="hot-sticker" id="sticker4">
								<img class="sticker" src="assets/stickers/unicorn.png" alt="unicorn-sticker" id="sticker5">
								<img class="sticker" src="assets/stickers/watermelon.png" alt="watermalon-sticker" id="sticker6">
							</div>
						</div>
					</div>
					<p style="margin-top: 30px;" class="sticker-description">2. Take an awesome photo!</p>
					<div>
						<button class="capture-btn" id="start-camera">Start Camera</button>
						<video id="video" width="700" height="500" autoplay></video>
						<button class="capture-btn" id="click-photo">Capture Photo</button>
						<canvas width="700" height="500" id="canvas"></canvas>
						<input type="hidden" id="webcam-file" value="" name="webcam_file">
					</div>
					<div class="control">
						<input type="text" class="my-input input" name="caption" placeholder="Write a caption here" required>
					</div>
					<div class="control">
						<input type="text" class="my-input input" name="hashtags" placeholder="Add hastags here" required>
					</div>
					<div>
						<button type="submit" class="upload-btn" name="webcam_img_btn">Publish</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>	

		const filter = document.querySelectorAll(".sticker");
		let camera_button = document.querySelector("#start-camera");
		let video = document.querySelector("#video");
		let capture_button = document.querySelector("#click-photo");
		
		camera_button.disabled = true;
		capture_button.disabled = true;

		for(let i=0; i<filter.length; i++){
			filter[i].addEventListener("click", (e) => {
				camera_button.disabled = false;
				capture_button.disabled = false;
				myCanvas(e.target.id);
			})
		}
		
		camera_button.addEventListener('click', async function() {
			let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
			video.srcObject = stream;
		});
		
		function myCanvas(sticker) {		
			let canvas = document.getElementById("canvas");
			let ctx = canvas.getContext("2d");
			let Selectedsticker = document.getElementById(sticker);
			capture_button.addEventListener('click', function() {
				ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
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
			});
			let canvasUrl = canvas.toDataURL();
			let finalImage = document.getElementById("webcam-file");
			finalImage.value = canvasUrl;
		}



/* 		capture_button.addEventListener('click', function() {
			canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
			let image_data_url = canvas.toDataURL();
			let completeImage = document.getElementById("webcam-file");
			completeImage.value = image_data_url;
		}); */

	</script>

</body>
</html>