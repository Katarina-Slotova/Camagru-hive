<?php

session_start();

// Remove everything from the session, including id, username and email
session_unset();
session_destroy();

header('location: login.php');
exit;

?>