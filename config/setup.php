<?php 
require_once('database.php');

// create connection to db using the PDO class and
// check if successfully connected to the database
try {
	$conn = new PDO($DB_HOST, $DB_USER, $DB_PASSWORD);
	// set an attribute so PDO will throw exceptions on errors 
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = "CREATE DATABASE IF NOT EXISTS camagru_db";
    $conn->exec($stmt);
} catch (PDOException $error) {
	// getMessage() method retrieves a cleaner error message than if this method was not there
    echo "Connection failed: " . $error->getMessage(); 
	exit;
}

// Closing PDO Connection; destroy PDO object by assigning null to the variable that holds the object
$conn = null;

// create table users
try {
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt ="CREATE TABLE IF NOT EXISTS `users`(
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`username` varchar(1000) NOT NULL,
		`password` varchar(1000) NOT NULL,
		`email` varchar(50) NOT NULL,
		`image` text DEFAULT 'dog.png',
		`followers` int(11) DEFAULT 0,
		`following` int(11) DEFAULT 0,
		`posts` int(11) DEFAULT 0,
		`bio` varchar(1000) DEFAULT 'none',
		`active` tinyint(1) DEFAULT 0,
    	`activation_code` varchar(255) NOT NULL,
		`notifications` tinyint(1) DEFAULT 1,
		PRIMARY KEY (`id`)
	)";
	$conn->exec($stmt);

} catch (PDOException $error) {
    echo $error->getMessage(); 
	exit;
}
$conn = null;

// create table posts
try {
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt ="CREATE TABLE IF NOT EXISTS `posts` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`user_id` int(11) NOT NULL,
		`likes` int(11) NOT NULL,
		`image` text  NOT NULL,
		`caption` varchar(1000) NOT NULL,
		`hashtags` varchar(1000) NOT NULL,
		`date` DATETIME  NOT NULL DEFAULT CURRENT_TIMESTAMP,
		`username` varchar(1000)  NOT NULL,
		`profile_image` text NOT NULL,
		`webcam` text NOT NULL,
		PRIMARY KEY (`id`)
	)";
	$conn->exec($stmt);

} catch (PDOException $error) {
	echo $error->getMessage(); 
	exit;
}
$conn = null;

// create table comments
try {
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt ="CREATE TABLE IF NOT EXISTS `comments` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`post_id` int(11) NOT NULL,
		`user_id` int(11) NOT NULL,
		`username` varchar(1000) NOT NULL,
		`profile_image` text  NOT NULL,
		`comment_text` MEDIUMTEXT  NOT NULL,
		`date` DATETIME  NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
	)";
	$conn->exec($stmt);

} catch (PDOException $error) {
    echo $error->getMessage(); 
	exit;
}
$conn = null;

// create table likes
try {
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt ="CREATE TABLE IF NOT EXISTS `likes` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`user_id` int(11) NOT NULL,
		`post_id` int(11) NOT NULL,
		PRIMARY KEY (`id`)
	)";
	$conn->exec($stmt);

} catch (PDOException $error) {
    echo $error->getMessage(); 
	exit;
}
$conn = null;

// create table followings
try {
	$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt ="CREATE TABLE IF NOT EXISTS `followings` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`user_id` int(11) NOT NULL,
		`other_user_id` int(11) NOT NULL,
		PRIMARY KEY (`id`)
	)";
	$conn->exec($stmt);

} catch (PDOException $error) {
    echo $error->getMessage(); 
	exit;
}
$conn = null;



?>