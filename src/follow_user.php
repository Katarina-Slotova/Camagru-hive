<?php 

session_start();

require_once('connection.php');

if (empty($_SESSION['id'])) {
	header('location: login.php');
	exit;
}

if(isset($_POST['follow_btn'])){
	$my_id = $_SESSION['id'];
	$other_user_id = $_POST['other_user_id'];

	try {
		//link me and the person I want to follow
		$conn = connect_db();
		$stmt = $conn->prepare("INSERT INTO followings (user_id,other_user_id) VALUES (?, ?)");
		$stmt->bindParam(1, $my_id, PDO::PARAM_INT);
		$stmt->bindParam(2, $other_user_id, PDO::PARAM_INT);
		
		$conn = connect_db();
		$stmt1 = $conn->prepare("UPDATE users SET following = following+1 WHERE id = ?");
		$stmt1->bindParam(1, $my_id, PDO::PARAM_INT);
		
		$conn = connect_db();
		$stmt2 = $conn->prepare("UPDATE users SET followers = followers+1 WHERE id = ?");
		$stmt2->bindParam(1, $other_user_id, PDO::PARAM_INT);
	
		$stmt->execute();
		$stmt1->execute();
		$stmt2->execute();
	
		$_SESSION['following'] = $_SESSION['following']+1;
	
		header('location:'.$_SERVER['HTTP_REFERER'].'?ok_message=You now follow this user!');
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;

}else{
	header("location: home.php");
	exit;
}


?>