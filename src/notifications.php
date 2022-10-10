<?php 

require_once('connection.php');
session_start();

if (empty($_SESSION['id'])) {
	header('location: login.php');
	exit;
}

$id = $_SESSION['id'];
$yes = 1;
$no = 0;

if (isset($_POST['yes_notif'])){
	try{
		$conn = connect_db();
		$stmt = $conn->prepare("UPDATE users SET notifications = ? WHERE id = ?");
		$stmt->bindParam(1, $yes, PDO::PARAM_INT);
		$stmt->bindParam(2, $id, PDO::PARAM_INT);
		$stmt->execute();
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;

	header("location: edit_profile.php?ok_message=Comment notifications via email enabled!");
} else if (isset($_POST['no_notif'])){
	try{
		$conn = connect_db();
		$stmt = $conn->prepare("UPDATE users SET notifications = ? WHERE id = ?");
		$stmt->bindParam(1, $no, PDO::PARAM_INT);
		$stmt->bindParam(2, $id, PDO::PARAM_INT);
		$stmt->execute();
	} catch (PDOException $error) {
		echo $error->getMessage(); 
		exit;
	}
	$conn = null;

	header("location: edit_profile.php?ok_message=Comment notifications via email disabled!");
}

?>