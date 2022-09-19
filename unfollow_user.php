<?php 

session_start();

include('connection.php');

if(isset($_POST['unfollow_btn'])){
	$my_id = $_SESSION['id'];
	$other_user_id = $_POST['other_user_id'];

	// link me and the person I want to follow
	$stmt = $conn->prepare("DELETE FROM followings WHERE user_id = ? AND other_user_id = ?");
	$stmt->bind_param("ii", $my_id, $other_user_id);

	// lower the amount of followings 
	$stmt1 = $conn->prepare("UPDATE users SET following = following-1 WHERE id = ?");
	$stmt1->bind_param("i", $my_id);

	// lower the amount of followers of the other user
	$stmt2 = $conn->prepare("UPDATE users SET followers = followers-1 WHERE id = ?");
	$stmt2->bind_param("i", $other_user_id);

	$stmt->execute();
	$stmt1->execute();
	$stmt2->execute();

	$_SESSION['following'] = $_SESSION['following']-1;

	header("location: profile.php?ok_message=You unfollowed this user!");

}else{
	header("location: index.php");
	exit;
}


?>