<?php

include('header.php');

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
				<?php if(isset($_GET['image_name'])) { ?>
					<img style="width: 400px" src="<?php echo "assets/imgs/".$_GET['image_name'];?>" alt="my-img">
				<?php } ?>
				<form runat="server" action="create_post.php" method="POST" enctype="multipart/form-data" class="camera-form">
					<img style="width: 400px" id="blah" >
					<input accept="image/*" type="file" class="my-input input" id="imgInp" name="image" required>
					<div class="control">
						<input type="text" class="my-input input" name="caption" placeholder="Write a caption here" required>
					</div>
					<div class="control">
						<input type="text" class="my-input input" name="hashtags" placeholder="Add hastags here" required>
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
			const [file] = imgInp.files
			if (file) {
				blah.src = URL.createObjectURL(file)
			}
		}
	</script>
</body>
</html>
