<?php
	/* Header to include in all Student HTML&PHP files to ensure a valid student is logged in to access tests and grades */
session_start();
if(!isset($_SESSION['student']) || $_SESSION['student'] != true) {
		header("Location: https://web.njit.edu/~meu3/CS490/Exam-Generator-RC/login.html");
		die();
	}
?>
