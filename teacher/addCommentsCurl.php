<?php
// TODO: PHP file to send comments to graded test
				$commentResults = array('comment' => $_POST['comment'], 'grade' => $_POST['grade'],
					'maxGrade' => $_POST['maxGrade'], 'studentInput' => $_POST['studentInput'], 'username'=> $_POST['username']);
  $ch = curl_init("https://web.njit.edu/~bkw2/finalComments.php");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $commentResults);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);

	echo $result;
 ?>
