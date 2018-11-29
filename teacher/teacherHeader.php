<?php
	/* Header to include in all Teacher HTML&PHP files to ensure only an instructor can access test creation*/
	session_start();
	if(!isset($_SESSION['teacher']) || $_SESSION['teacher'] != true) {
		header("Location: https://web.njit.edu/~meu3/CS490/Exam-Generator-RC/login.html");
		die();
	}
?>
