<?php

require_once('connection.php');


if(isset($_POST['search_input']) && !empty($_POST['search_input'])){

	$search_input = $_POST['search_input'];

	try{
		$conn = connect_db();
		$stmt = $conn->prepare("SELECT * FROM users WHERE username like ? LIMIT 10");
		$stmt->bindParam(1, strval("%".$search_input."%"), PDO::PARAM_STR);
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;
}

?>