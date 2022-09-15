<?php

include('connection.php');

if(isset($_POST['search_input'])){

	$search_input = $_POST['search_input'];

	$stmt = $conn->prepare("SELECT * FROM users WHERE username like ? LIMIT 10");
	$stmt->bind_param("s", strval("%".$search_input."%"));
	$stmt->execute();
	$results = $stmt->get_result();
}

?>