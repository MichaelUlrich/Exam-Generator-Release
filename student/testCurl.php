<?php
	// TODO: PHP file to send student input for grading
	rawurldecode($_POST);
	$testData = array('studentInput' => $_POST['studentInput'], 'username' => $_POST['username']);//, 'id' = $_POST['id']);
	rawurlencode($testData);
	$ch = curl_init("https://web.njit.edu/~bkw2/saveUngraded.php");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $testData);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);

	echo $result;
?>
