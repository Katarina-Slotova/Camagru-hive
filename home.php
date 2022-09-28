<?php
	require_once('header.php'); 
	require_once('connection.php');
?>
	<section class="main">
		<div class="main-wrapper">
			<?php if(isset($_GET['ok_message'])) { ?>
				<p class="has-text-centered message is-success"><?php echo $_GET['ok_message']?></p>
				<?php } ?>
				
				<?php if(isset($_GET['error_message'])) { ?>
					<p class="has-text-centered message is-danger"><?php echo $_GET['error_message']?></p>
					<?php } ?>
					
			<!--OTHER USERS-->
			<?php
				require_once('other_users.php');
				require_once('get_latest_posts.php');
			?>

			<?php try{ foreach($posts as $post){ ?>
				<!--POSTS--->
				<div class="posts">
					<div class="single-post">
					<div class="info">
						<div class="user">
							<div class="profile-pic">
								<img src="<?php echo "assets/imgs/".$post['profile_image']; ?>" alt="profile-image">
							</div>
							<p class="usrname"><?php echo $post['username'];?></p>
						</div>
					</div>
					<!--POST CONTENT-->
					<img class="post-img" src="<?php echo "assets/imgs/".$post['image'];?>" alt="post-image">
					<div class="post-content">
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
						<p class="likes"><?php echo $post['likes']?> likes</p>
						<p class="description"><span><?php echo $post['caption']; ?></span><?php echo $post['hashtags']; ?></p>
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
						$stmt = $conn->prepare("SELECT COUNT(*) as all_comments FROM comments WHERE post_id = ?");
						$stmt->bindParam(1, $post_id, PDO::PARAM_INT);
						$stmt->execute();
						$stmt->fetchAll();

						$conn = connect_db();
						$stmt = $conn->prepare("SELECT * FROM comments WHERE post_id = ?");
						$stmt->bindParam(1, $post_id, PDO::PARAM_INT);
						$stmt->execute();
						$comments = $stmt->fetchAll();

					?>

					<?php foreach($comments as $comment){?>
						<div class="comment-item">
							<img src="<?php echo "assets/imgs/".$comment['profile_image']; ?>" alt="profile-pic" class="icon">
							<p><?php echo $comment['comment_text']; ?><span><?php echo $comment['date']; ?></span></p>
							<?php if($comment['user_id'] == $_SESSION['id']){ ?>
								<form action="delete_comment.php" method="POST">
									<input type="hidden" name="comment_id" value="<?php echo $comment['id'];?>">
									<input type="hidden" name="post_id" value="<?php echo $post['id'];?>">
									<input class="delete-comment-btn" type="submit" name="delete_comment_btn" value="Delete">
								</form>
							<?php } ?>
						</div>
					<?php } ?>

					<div>
						<a class="load-comment-button" href="load_comments.js">Load more comments</a>
					</div>

					<div class="comment-wrapper">
						<img class="icon" src="<?php echo "assets/imgs/".$post['profile_image']; ?>" alt="profile-pic">
						<form class="comment-wrapper" action="comment.php" method="POST">
							<input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
							<input name="text" class="comment-box" type="text" placeholder="Write a comment">
							<button class="comment-button" name="comment_btn" type="submit">Publish</button>
						</form>
					</div>
					</div>
				</div>
			<?php } ?>
			<nav class="pagination mt-6" role="navigation" aria-label="pagination">
				<ul class="my-pagination-list" class="pagination-list">
					<li class="my-pagination">
						<a <?php if($page_no <= 1){echo 'is-disabled';}?> class="pagination-previous" title="This is the first page" href="<?php if($page_no <= 1){echo '#';}else{echo '?page_no='.$page_no-1;}?>">Previous</a>
					</li>
					<li>
						<a class="pagination-link" aria-label="Page 1" aria-current="page" href="?page_no=1">1</a>
					</li>
					<li>
						<a class="pagination-link" aria-label="Goto page 2" href="?page_no=2">2</a>
					</li>
					<li>
						<a class="pagination-link" aria-label="Goto page 3" href="?page_no=3">3</a>
					</li>
					<?php if($page_no >= 3){ ?>
						<li>
							<a class="pagination-link" aria-label="Pages after page 3" href="#">...</a>
						</li>
						<li>
							<a class="pagination-link" aria-label="Goto pages after page 3" href="<?php echo "?page_no=".$page_no; ?>"></a>
						</li>
						<?php } ?>
					<li class="my-pagination">
						<a <?php if($page_no >= $all_posts){echo 'is-disabled';}?> class="pagination-next" href="<?php if($page_no >= $all_posts){echo '#';}else{echo '?page_no='.$page_no+1;}?>">Next</a>
					</li>
				</ul>
			</nav>
			<?php } catch (PDOException $error) {
				echo $error->getMessage(); 
				exit;
			}
			$conn = null;
			?>
			<div class="my-footer">
				<p><em>Made with ❤️ by Katarina Slotova. Hive Helsinki 2022.</em></p>
			</div>
		</div>
	</section>
</body>
</html>
