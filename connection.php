<?php

$conn = mysqli_connect('localhost', 'root', '123', 'camagru', 0, "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock");
if (!$conn) {
	echo "Failed to connect to MySQL: " . mysql_errno() . " - " . mysql_error();
	exit();
  }

?>