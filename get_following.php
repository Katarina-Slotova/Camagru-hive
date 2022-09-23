<?php 

require_once('connection.php');
// Get ids of users I am following
$user_id = $_SESSION['id'];

try{
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT other_user_id FROM followings WHERE user_id = ?");
	$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
	$stmt->execute();
	$ids_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	// Store the ids in an array  
	/* 	$ids_array = array();
	$result = $stmt->fetchAll();
	while($row = $result->fetchAll(PDO::FETCH_NUM)){
		foreach($row as $r){
			$ids_array[] = $r;
		}
	} */
	
	// No followings
	if(empty($ids_array)){
		
	}else{
		//$following_ids = explode(",", $ids_array);
		
		try{
			$conn = connect_db();
			$following_ids = str_repeat('?,', count($ids_array) - 1) . '?';
			$stmt = $conn->prepare("SELECT * FROM users WHERE id in ($following_ids) ORDER BY RAND() LIMIT 20");
			$stmt->execute($ids_array);
			$other_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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