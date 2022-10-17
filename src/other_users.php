<?php require_once('get_following.php');?>

<?php if(!isset($other_users)){ ?>

<?php }else{ ?>
	<div class="status-wrapper">
		
		<?php foreach($other_users as $user){?>
			<form action="user_profile.php" method="POST" id="other_user_form<?php echo $user['id'];?>">
				<div class="status-card">
					<input type="hidden" name="other_user_id" value="<?php echo $user['id'];?>">
					<div class="profile-pic">
						<img onclick="document.getElementById('other_user_form'+<?php echo $user['id'];?> ).submit();" src="<?php echo "../assets/imgs/".$user['image']?>" alt="profile-pic"/>
					</div>
					<p class="usrname"><?php echo $user['username'];?></p>
				</div>
			</form>
		<?php } ?>
	</div>
<?php } ?>