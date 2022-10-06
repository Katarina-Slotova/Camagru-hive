<?php

function connect_db()
{
	$DB_DSN = "mysql:host=localhost;dbname=camagru_db";
	$DB_USER = "root";
	$DB_PASSWORD = "123456";
	try {
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		// Proccess error
		echo 'Cannot connect to database: ' . $e->getMessage();
	}
	return $conn;
}


?>