<?php
//	function redirect($file) {
//		echo $file;
//		header("Location:https://web.njit.edu/~meu3/CS490/Exam-Generator/$file");
//		exit();
//	{

	session_start();
//$_SESSION['teacher'] = "true"; //Testing
//$_SESSION['student'] = "true"; //Testing

	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);

	$user = array('username' => $_POST['username'], 'password' =>$_POST['password']);
	var_dump($user);
	$middle_url = "https://web.njit.edu/~bkw2/middle_beta.php";				//Receive if login is for student or teacher
	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $middle_url);                             //Set URL
		curl_setopt($ch, CURLOPT_POST, true);                                   //Set to POST
		curl_setopt($ch, CURLOPT_POSTFIELDS, /*http_build_query*/ $user);       //Send array
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                         //Receive results of cURL and store in var instead of printing
	$result = curl_exec($ch);
	$result_decode=json_decode($result);
	$resultDecoded = json_decode($result);

	//Result will be JSON stating if login was successful and if Student/Teacher ex.{ teacher/student : true/false }
//	var_dump($resultDecoded);
	if($resultDecoded->{'student'} == "true") {
		$_SESSION['student'] = true;
		$_SESSION['username'] = $user["username"];
//	redirect("studentHomepage.php");
		//header('Location: https://web.njit.edu/~meu3/CS490/Exam-Generator-Release/student/studentHomepage.php');
		echo "student/studentHomepage.php";
		exit();
	} else if($resultDecoded->{'teacher'} == "true") {
		$_SESSION['teacher'] = true;
		$_SESSION['username'] = $user["username"];
		//header('Location: https://web.njit.edu/~meu3/CS490/Exam-Generator-Release/teacher/teacherHomepage.php');
		echo "teacher/teacherHomepage.php";
		exit();
	} else {
	//redirect("login.html");
		header('Location: login.html');
		exit();
//		echo '<div id="test"> Wrong Info. Try Again</div>';
	}
	curl_close($ch);
?>
