<?php

require_once("connection.php");

$email = $_GET['email'];

function activate_user(string $email): bool
{
	$conn = connect_db();
	$sql = 'UPDATE users
			SET active = 1,
				activated_at = CURRENT_TIMESTAMP
			WHERE email=:email';

	$statement = $conn->prepare($sql);
	$statement->bindValue(':email', $email, PDO::PARAM_STR);

	$statement->execute();

	return $statement->rowCount();
}

if (activate_user($email)) {
	header("location: login.php?ok_message=You account was successfuly verified! Log in and start posting awesome pics!");
} else {
	header("location: login.php?error_message=You account has not been verified yet.");
}
?>
