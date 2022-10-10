<?php 

session_start();

require_once('connection.php');

if (empty($_SESSION['id'])) {
	header('location: login.php');
	exit;
}

// Get ids of users I am following
$user_id = $_SESSION['id'];

try{
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT other_user_id FROM followings WHERE user_id = ?");
	$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
	$stmt->execute();

	while($row = $stmt->fetch(PDO::FETCH_NUM)){
		foreach($row as $r){
			$ids_array[] = $r;
		}
	}
	// No followings
	if(empty($ids_array)){
		
	}else{
		$following_ids = join(",", $ids_array);
		
		try{
			$conn = connect_db();
			$stmt = $conn->prepare("SELECT * FROM users WHERE id IN ($following_ids) ORDER BY RAND() LIMIT 20");
			$stmt->execute();
			$other_users = $stmt->fetchAll();
		} catch (PDOException $error) {
			echo $error->getMessage(); 
			exit;
		}
		$conn = null;
	}
} catch (PDOException $error) {
	echo $error->getMessage(); 
	exit;
}
$conn = null;

?>