<?php

require_once('connection.php');

$user_id = $_SESSION['id'];

try{
	$conn = connect_db();
	$stmt = $conn->prepare("SELECT * FROM followings WHERE user_id = ? AND other_user_id = ?");
	$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
	$stmt->bindParam(2, $other_user_id, PDO::PARAM_INT);
	$stmt->execute();
	
	if($res = $stmt->fetch(PDO::FETCH_ASSOC)){
		$following = true;
	}else{
		$following = false;
	}
}  catch (PDOException $error) {
	echo $error->getMessage(); 
	exit;
}
$conn = null;

?>