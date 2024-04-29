<?php

// FILENAME: final_logout.php
// AUTHOR: Zachary Krepelka
// DATE: Sunday, April 28th, 2024

	session_start();
	$_SESSION = array();
	session_destroy();
	header("Location: /final/final.php");
?>
