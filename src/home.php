<?php
	require_once('header.php'); 
	require_once('connection.php');
?>
	<section class="main">
		<div class="main-wrapper">
			<?php if(isset($_GET['ok_message'])) { ?>
				<p class="has-text-centered message is-success"><?php echo htmlspecialchars($_GET['ok_message'])?></p>
			<?php } ?>
			<?php if(isset($_GET['error_message'])) { ?>
				<p class="has-text-centered message is-danger"><?php echo htmlspecialchars($_GET['error_message'])?></p>
			<?php } ?>
					
			<!--OTHER USERS-->
			<?php
				if (isset($_SESSION['id'])){
					require_once('other_users.php');
				}
				require_once('get_latest_posts.php');
			?>

			<?php try{ foreach($posts as $post){ ?>
				<!--POSTS--->
				<div class="posts">
					<div class="single-post">
					<div class="info">
						<div class="user">
							<div class="profile-pic">
								<img src="<?php echo "../assets/imgs/".$post['profile_image']; ?>" alt="profile-image">
							</div>
							<p class="usrname"><?php echo $post['username'];?></p>
						</div>
					</div>
					<!--POST CONTENT-->
					<img class="post-img" src="<?php echo "../assets/imgs/".$post['image'];?>" alt="post-image">
					<div class="post-content">
						<?php if(isset($_SESSION['id'])){ ?>
							<div class="reaction-wrapper">
								<?php require('check_if_liked.php'); ?>
								<?php if($post_liked){ ?>
									<form action="unlike_post.php" method="POST">
										<input type="hidden" name="post_id" value="<?php echo $post['id'];?>">
										<button class="heart" type="submit" name="like_btn">
											<i class="icon las la-heart"></i>
										</button>
									</form> 
								<?php }else{ ?>
									<form action="like_post.php" method="POST">
										<input type="hidden" name="post_id" value="<?php echo $post['id'];?>">
										<button class="heart" type="submit" name="like_btn">
											<i class="icon lar la-heart"></i>
										</button>
									</form>
								<?php } ?>
							</div>
						<?php } ?>
						<p class="likes"><?php echo $post['likes']?> likes</p>
						<p class="description"><span style="overflow-wrap:anywhere;"><?php echo $post['caption']; ?></span></p>
						<p style="margin-bottom: 15px;"><?php echo $post['hashtags']; ?></p>
						<p class="time"><?php echo $post['date']; ?></p>
					</div>

					<?php

						$conn = connect_db();
						$post_id = $post['id'];
						$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
						$stmt->bindParam(1, $post_id, PDO::PARAM_INT);
						$stmt->execute();
						$posts = $stmt->fetchAll();

						$conn = connect_db();
						$stmt = $conn->prepare("SELECT * FROM comments WHERE post_id = ?");
						$stmt->bindParam(1, $post_id, PDO::PARAM_INT);
						$stmt->execute();
						$comments = $stmt->fetchAll();

					?>

					<?php foreach($comments as $comment){?>
						<div class="comment-item">
								<img src="<?php echo "../assets/imgs/".$comment['profile_image']; ?>" alt="profile-pic" class="icon">
								<div style="min-width:100px;">
									<p style="font-weight:bold; font-size:14px; padding:0;"><?php echo htmlspecialchars_decode($comment['username']); ?></p>
								</div>
							<div style="display:flex; justify-content:center; align-items:center;">
								<p><?php echo $comment['comment_text']; ?><span><?php echo $comment['date']; ?></span></p>
							</div>
							<?php if(isset($_SESSION['id']) && $comment['user_id'] == $_SESSION['id']){ ?>
								<form action="delete_comment.php" method="POST">
									<input type="hidden" name="user_id" value="<?php echo $comment['user_id'];?>">
									<input type="hidden" name="comment_id" value="<?php echo $comment['id'];?>">
									<input type="hidden" name="post_id" value="<?php echo $post['id'];?>">
									<input class="delete-comment-btn" type="submit" name="delete_comment_btn" value="Delete">
								</form>
							<?php } ?>
						</div>
					<?php } ?>
					
					<?php if(isset($_SESSION['id'])){ ?>
						<div class="comment-wrapper">
							<form class="comment-wrapper" action="comment.php" method="POST">
								<input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
								<input type="hidden" name="author_id" value="<?php echo $post['user_id'];?>">
								<input name="text" class="comment-box" type="text" placeholder="Write a comment" maxlength="500">
								<button class="comment-button" name="comment_btn" type="submit">Publish</button>
							</form>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
			<nav class="pagination mt-6" role="navigation" aria-label="pagination">
				<ul class="my-pagination-list" class="pagination-list">
					<li class="my-pagination">
						<a <?php if($page_no <= 1){ ?> disabled <?php } ?> class="pagination-previous" href="<?php if($page_no <= 1){echo '#';}else{echo 'home.php?page_no='.$page_no-1;}?>">Previous</a>
					</li>
					<li>
						<a class="pagination-link" aria-label="Page 1" aria-current="page" href="home.php?page_no=1">1</a>
					</li>
					<li>
						<a class="pagination-link" aria-label="Goto page 2" href="home.php?page_no=2">2</a>
					</li>
					<li>
						<a class="pagination-link" aria-label="Goto page 3" href="home.php?page_no=3">3</a>
					</li>
					<?php if($page_no >= 3){ ?>
						<li>
							<a class="pagination-link" aria-label="Pages after page 3" href="#">...</a>
						</li>
					<?php } ?>
					<li class="my-pagination">
						<a <?php if($page_no >= $all_pages){ ?> disabled <?php } ?> class="pagination-next" href="<?php if($page_no >= $all_pages){echo '#';}else{echo 'home.php?page_no='.$page_no+1;}?>">Next</a>
					</li>
				</ul>
			</nav>
			<?php } catch (PDOException $error) {
				echo $error->getMessage(); 
				exit;
			}
			$conn = null;
			require_once('footer.php');
			?>
		</div>
	</section>
</body>
</html>
