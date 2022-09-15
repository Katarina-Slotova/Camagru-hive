<?php 

include('connection.php');

// Get ids of users I am following
$user_id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT other_user_id FROM followings WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

// Store the ids in an array  
$ids_array = array();
$result = $stmt->get_result();
while($row = $result->fetch_array(MYSQLI_NUM)){
	foreach($row as $r){
		$ids_array[] = $r;
	}
}

// No followings
if(empty($ids_array)){
	
}else{
	$following_ids = join(",", $ids_array);
	
	$stmt = $conn->prepare("SELECT * FROM users WHERE id in ($following_ids) ORDER BY RAND() LIMIT 20");
	$stmt->execute();
	$other_users = $stmt->get_result();
}



?>