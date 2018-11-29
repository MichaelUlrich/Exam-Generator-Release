<?php
	$ch = curl_init("https://web.njit.edu/~bkw2/fetchQuestions.php");
 	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	echo $result;
 ?>
