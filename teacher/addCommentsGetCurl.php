<?php
// TODO: PHP file to get auto-grader comments for review
  $testData = array('username' => $_POST['username']);//, 'username' => $_POST['username'])
  $ch = curl_init("https://web.njit.edu/~bkw2/getQuestionsbyUser.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $testData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    echo $result;
?>
