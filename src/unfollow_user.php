<?php 

session_start();

require_once('connection.php');

if(isset($_POST['unfollow_btn']) && !empty($_POST['other_user_id'])){
	$my_id = $_SESSION['id'];
	$other_user_id = $_POST['other_user_id'];

	try {
		// link me and the person I want to follow
		$conn = connect_db();
		$stmt = $conn->prepare("DELETE FROM followings WHERE user_id = ? AND other_user_id = ?");
		$stmt->bindParam(1, $my_id, PDO::PARAM_INT);
		$stmt->bindParam(2, $other_user_id, PDO::PARAM_INT);
	
		// lower the amount of followings
		$conn = connect_db();
		$stmt1 = $conn->prepare("UPDATE users SET following = following-1 WHERE id = ?");
		$stmt1->bindParam(1, $my_id, PDO::PARAM_INT);
	
		// lower the amount of followers of the other user
		$conn = connect_db();
		$stmt2 = $conn->prepare("UPDATE users SET followers = followers-1 WHERE id = ?");
		$stmt2->bindParam(1, $other_user_id, PDO::PARAM_INT);
	
		$stmt->execute();
		$stmt1->execute();
		$stmt2->execute();
	
		$_SESSION['following'] = $_SESSION['following']-1;
	
		header("location: profile.php?ok_message=You unfollowed this user!");
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;

}else{
	header("location: login.php?error_msg=Error occured.");
	exit;
}


?>