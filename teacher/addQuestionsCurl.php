<?php
	//$echo 'examDbCurl: ' . $_POST['question'];
	$question = array('question' => $_POST['question'], 'type' =>$_POST['type'],
					'loopType' => $_POST['loopType'], 'difficulty' => $_POST['diff'],
					'points' => $_POST['points'], 'testCases' => $_POST['testCases'],
					'functionName' => $_POST['functionName'], 'variableNames' => $_POST['variableNames'],
					'returnPrint' => $_POST['returnPrint']);
	//echo $question;
	//:var_dump($question);
	urlencode($question);
	$ch = curl_init("https://web.njit.edu/~bkw2/addQuestions.php");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $question);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	//echo $result;
?>
