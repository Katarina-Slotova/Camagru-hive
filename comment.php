<?php

session_start();

require_once('connection.php');

function send_notification_email(string $email): void
{	
	$SENDER_EMAIL_ADDRESS = 'no-reply@email.com';
	// create the activation link

	// set email subject & body
	$subject = 'Your post got a new comment!';
	$message = <<<MESSAGE
			Hi!
			Someone just commented on your post, go check it out!
			MESSAGE;
	// email header
	$header = "From:" . $SENDER_EMAIL_ADDRESS;

	// send the email
	mail($email, $subject, nl2br($message), $header);
}

if(isset($_POST['comment_btn'])){
	$post_id = $_POST['post_id'];
	$author_id = $_POST['author_id'];
	$user_id = $_SESSION['id'];
	$username = $_SESSION['username'];
	$profile_image = $_SESSION['image'];
	$text = $_POST['text'];
	$tz = 'Europe/Helsinki';
	$timestamp = time();
	$date = new DateTime("now", new DateTimeZone($tz));
	$date->setTimestamp($timestamp);
	$date = $date->format('Y-m-d H:i:s');

	if(strlen($text) > 20){
		header('location:'.$_SERVER['HTTP_REFERER'].'&error_message=Comment too long');
		exit;
	}
	try{
		$conn = connect_db();
		
		$stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, username, profile_image, comment_text, date) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt1 = $conn->prepare("SELECT email FROM users WHERE id = ?");
		$stmt2 = $conn->prepare("SELECT notifications FROM users WHERE id = ?");
		
		$stmt->bindParam(1, $post_id, PDO::PARAM_INT);
		$stmt->bindParam(2, $user_id, PDO::PARAM_INT);
		$stmt->bindParam(3, $username, PDO::PARAM_STR);
		$stmt->bindParam(4, $profile_image, PDO::PARAM_STR);
		$stmt->bindParam(5, $text, PDO::PARAM_STR);
		$stmt->bindParam(6, $date, PDO::PARAM_STR);

		$stmt1->bindParam(1, $author_id, PDO::PARAM_INT);

		$stmt2->bindParam(1, $author_id, PDO::PARAM_INT);

		if($stmt->execute() && $stmt1->execute() && $stmt2->execute()){
			$email = $stmt1->fetchColumn();
			$notif = $stmt2->fetchColumn();
			if ($notif === 1)
				send_notification_email($email);
			header('location:'.$_SERVER['HTTP_REFERER'].'&ok_message=Comment posted');
		}else{
			header('location:'.$_SERVER['HTTP_REFERER'].'&error_message=Comment posting failed');
		}
		exit;
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;
}else{
	header('location: home.php?error_message=Error occured');
	exit;
}




?>