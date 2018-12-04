<!DOCTYPE HTML>
<?php include 'studentHeader.php'; ?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
	*{box-sizing: border-box;}
	.row{display: flex;}
	.column{flex: 5%; padding: 1%}
</style>
</head>
<script>
	var GLOBAL_JSON = "";
	var USERNAME = "";//<//?php echo $_SESSION['username']?>;
	var URL = "";
	function drawExam(parseQuestions) {
		for(var i in parseQuestions) {
			var textElement = document.createElement("textarea");
			var breakElement = document.createElement("br");
			//var submitElement = document.createElement("span");
			var displayElement = document.createElement("span");
			var x = document.getElementById("test");

			var intI = parseInt(i, 10);
			intI += 1; //Question 0 displayed as Question 1
			textElement.setAttribute("name", "question" + intI);
			textElement.setAttribute("placeholder", "Write code here for Question #"+intI+"...");
			textElement.setAttribute("cols", "120");
			textElement.setAttribute("rows", "10");
			//submitElement.innerHTML = '<button id="'+i+'" onclick="submit(this)">Submit Question #'+intI+'</button>';
			displayElement.innerHTML = '<p id=isSubmit'+i+'></p>';

			x.appendChild(textElement);
		//	x.appendChild(submitElement);
			x.appendChild(displayElement);
			x.appendChild(breakElement);
		}
	}
	function submit(/*calling*/) {
		var form = document.getElementById("test");
		var formText = "";
		var testingText = "";
		var i;
		var returnDiv = document.getElementById("returnDiv");
		var submitButton = document.getElementById("");
		for(var i = 0; i < form.length; i++) {
			formText = form.elements[i].value; //Testing
			testingText += i;
			generateURL(formText, i);
			ajaxRequest();
		}
		//document.getElementById("testing").innerHTML = "url is: "+URL;
		//ajaxRequest();
		//document.getElementById("studentInput").innerHTML = testingText;
		document.getElementById("submitedText").innerHTML = "Your Test has been Submitted"; //Testing
		returnDiv.innerHTML = '<button onclick="goToHomepage()">Return to Homepage</button>';
	}
	function drawQuestions(questions) {
		var questionDiv = document.getElementById("questions");
		var parseQuestions = JSON.parse(questions);
		for(var i in parseQuestions) {
			var questionElement = document.createElement("p");
			var pointsElement = document.createElement("p");
			var intI = parseInt(i, 10);
			intI+=1;
			//pointsElement.innerHTML = '<p style="margin-left:2%; margin-right:10>Points: TEMP</p>';
			questionElement.setAttribute("data-content", "Question #"+i+": ");  //+sample[i].question);
			pointsElement.textContent = "Points:"+parseQuestions[i].points;
			questionElement.textContent =  "Question #"+intI+": "+parseQuestions[i].question;
			questionDiv.appendChild(questionElement);
			questionDiv.appendChild(pointsElement);
		}
		drawExam(parseQuestions);
	}
	function goToHomepage() {
		window.location.href="https://web.njit.edu/~meu3/CS490/Exam-Generator-Release/student/studentHomepage.php";
	}
	function generateURL(formText, id) {
		var username = "<?php echo $_SESSION['username']?>";
		URL = "username="+username+"&studentInput="+formText+"&id="+id;
		//document.getElementById("testing").innerHTML = UURL;
	}
	function ajaxRequest() {
		// TODO: send AJAX to php file
		//var formText = "";
		//GLOBAL_JSON += studentInput;
		var xmhlObj = new XMLHttpRequest();
		var phpFile = 'testCurl.php';
		//var url = "username="+username+"&studentInput="+studentInput;//For AJAX POST
	//GOBAL_JSON += url;
		var testingText = "";
		var return_data = "";
		//var encodedURL = encodeURIComponent(URL);
		document.getElementById("testing").innerHTML = URL;
		xmhlObj.open("POST", phpFile, false);
		xmhlObj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //Sending URL encoded variables
		xmhlObj.onreadystatechange = function() {
			if(xmhlObj.readyState == 4 && xmhlObj.status == 200) {  //Conection is established and working
				USERNAME += xmhlObj.responseText;
				//document.getElementById("testing").innerHTML = return_data;
			}
			//document.getElementById("testing2").innerHTML = "server output: "+USERNAME;
		}
		//xmhlObj.send(encodedURL); //Send request
		xmhlObj.send(URL);
		//document.getElementById("testing").innerHTML = testingText;
	}
	function ajaxGetRequest() {
		var xmhlObj = new XMLHttpRequest();
		var phpFile = "testGetCurl.php";
		var return_data;
		xmhlObj.open("POST", phpFile, true);
		xmhlObj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //Sending URL encoded variables
		xmhlObj.onreadystatechange = function() {
			if(xmhlObj.readyState == 4 && xmhlObj.status == 200) {  //Conection is established and working
				return_data = xmhlObj.responseText;
				drawQuestions(return_data);
			}
		}
		xmhlObj.send();
	}
	window.onload = ajaxGetRequest;

</script>
<body>
	<!--<button onClick="goToHomepage()">REMOVE-Return to Homepage</button>-->
	<h2> Carefully read each question. Hit Submit for Each Question.  Good Luck. </h2>
	<p> Only click submit when you code is 100% finished </p>
	<p id="studentInput"></p>
	<p id="testing"></p>
	<p id="testing2"></p>
	<div class="row">
		<div id="testDiv" class="column" style="background-color:#aaa;">
			<form id="test"></form>
			<button id="submitButton" onclick="submit()">Submit Test</button>
			<h3 id="submitedText"></h3>
			<div id="returnDiv"></div>
		</div>
		<div class="column" style="background-color:#bbb;">
			<div id="questions">
				<p id="qText"></p>
			</div>
		</div>
	</div>
</body>
</html>
