<?php include('header.php'); ?>

<section class="main">
		<div class="main-wrapper">
			<!--FRIENDS AND THEIR STATUS-->
			<div class="status-wrapper">
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
				
				<div class="status-card">
					<div class="profile-pic">
						<img src="assets/imgs/dog.png" alt="profile-pic"/>
					</div>
					<p class="usrname">username</p>
				</div>
			</div>

			<?php include('get_latest_posts.php'); ?>

			<?php foreach($posts as $post){?>

			<!--POSTS--->
			<div class="posts">
				<div class="info">
					<div class="user">
						<div class="profile-pic">
							<img src="<?php echo "assets/imgs/".$post['profile_image'];  ?>" alt="profile-image">
						</div>
						<p class="usrname"><?php echo $post['username'];?></p>
					</div>
					<i class="las la-ellipsis-v options"></i>
				</div>
				<!--POST CONTENT-->
				<img class="post-img" src="<?php echo "assets/imgs/".$post['image'];?>" alt="flower">
				<div class="post-content">
					<div class="reaction-wrapper">
						<i class="icon lar la-heart"></i>
						<i class="icon las la-comments"></i>
					</div>
					<p class="likes"><?php echo $post['likes']?> likes</p>
					<p class="description"><span><?php echo $post['caption']; ?></span><?php echo $post['hashtags']; ?></p>
					<p class="time"><?php echo $post['date']; ?></p>
				</div>
				<div class="comment-wrapper">
					<img class="icon" src="assets/imgs/dog.png" alt="profile-pic">
					<input class="comment-box" type="text" placeholder="Write a comment">
					<button class="comment-button">Post</button>
				</div>

				<?php } ?>

				<nav class="pagination mt-6" role="navigation" aria-label="pagination">
					<a class="pagination-previous is-disabled" title="This is the first page">Previous</a>
					<a class="pagination-next">Next page</a>
					<ul class="pagination-list">
					  <li>
						<a class="pagination-link is-current" aria-label="Page 1" aria-current="page">1</a>
					  </li>
					  <li>
						<a class="pagination-link" aria-label="Goto page 2">2</a>
					  </li>
					  <li>
						<a class="pagination-link" aria-label="Goto page 3">3</a>
					  </li>
					</ul>
				  </nav>
				<div class="my-footer">
					<p><em>Made with ❤️ by Katarina Slotova. Hive Helsinki 2022.</em></p>
				</div>
			</div>
		</div>
	</section>
</body>
</html>
