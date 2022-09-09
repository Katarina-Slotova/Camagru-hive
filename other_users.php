<?php include('get_following.php');?>

<div class="status-wrapper">
	<?php foreach($other_users as $user){?>
		<form action="user_profile.php" method="POST" id="other_user_form<?php echo $person['id'];?>">
			<div class="status-card">
				<input type="hidden" name="other_user_id" value="<?php echo $person['id'];?>">
				<div class="profile-pic">
					<img onclick="document.getElementById('other_user_form'+<?php echo $person['id'];?> ).submit();" src="<?php echo "assets/imgs/".$people['image']?>" alt="profile-pic"/>
				</div>
				<p class="usrname"><?php echo $user['username'];?></p>
			</div>
		</form>
	<?php } ?>
</div>