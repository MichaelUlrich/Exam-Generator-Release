<!DOCTYPE HTML>
<?php include 'studentHeader.php' ?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		* { box-sizing: border-box:}
		.row { display: flex; }
		.column { flex: 50%; padding: 10px}
		//table,td{border: 1px solid grey;}
		table{border-spacing: 0; border: 1px solid grey}
		td,th{text-align: left; padding: 16px;}
		tr:nth-child(even){background-color: #bbb;}
		//th{left; padding: 16px;background-color: #f2f2f2; border: 1px solid grey}
	</style>
	<script>
	var GLOBAL_JSON;
	function ajaxGetRequest() {
		var username = "<?php echo $_SESSION['username']?>";
		var phpFile = "gradesGetCurl.php";
		var xmhlObj = new XMLHttpRequest();
		var url = "username="+username;
		var text, responseJSON;
		xmhlObj.open("POST", phpFile, true);
		xmhlObj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //Sending URL encoded variables
		xmhlObj.onreadystatechange = function() {
			if(xmhlObj.readyState == 4 && xmhlObj.status == 200) {  //Conection is established and working
				text = xmhlObj.responseText; //Returns student input for specific UCID
				//document.getElementById("nameTesting").innerHTML = text;
			//	if(!text) {
			//		document.getElementById("rowDiv").innerHTML = "<h1>No Grades Available Yet</h2>";
			//	} else {
					//document.getElementById("testing").innerHTML = "HELLO";
					GLOBAL_JSON = "";
					GLOBAL_JSON = JSON.parse(text);
					drawComments();
			//	}
			}
		}
		xmhlObj.send(url);
	}
	function getGrade() {
		var totalGrade = 0, maxGrade = 0, scaledGrade = 0;
		for(var i in GLOBAL_JSON) {
			totalGrade += parseInt(GLOBAL_JSON[i].pointsGiven,10);
			maxGrade += parseInt(GLOBAL_JSON[i].maxPoints,10);
		}
		scaledGrade = totalGrade/maxGrade;
		scaledGrade = scaledGrade * 100;
		scaledGrade = scaledGrade.toFixed(0);
	//	if(scaledGrade == "NaN" || scaledGrade = null) {scaledGrade = "";}
		document.getElementById("studentGrade").innerHTML = scaledGrade + '%';
	}
	function drawComments() {
		var inputTd, codeIdTd,gradeIdTd, idText, inputText, commentTd, commentText,
					gradeTd, gradeText, commentTr,codeTr, intI; //editTd, editText,
					//confirmTd, confirmText;
		var gradeTableBody = document.getElementById("gradeTableBody");
		var codeTableBody = document.getElementById("codeTableBody");

		for(var i in GLOBAL_JSON) {

			intI = parseInt(i, 10);

			commentTr = document.createElement("tr");
			codeTr = document.createElement("tr");

			gradeIdTd = document.createElement("td");
			gradeIdText = document.createTextNode(intI+1);
			gradeIdTd.appendChild(gradeIdText);

			codeIdTd = document.createElement("td");
			codeIdText = document.createTextNode(intI+1);
			codeIdTd.appendChild(codeIdText);

			inputTd = document.createElement("td");
			inputTd.innerHTML = '<textarea readonly id="codeText" maxlength="5000" cols="60" rows="10">'+GLOBAL_JSON[i].studentInput+'</textarea><br>';
			//inputText = document.createTextNode(GLOBAL_JSON[i].studentInput);
			//inputTd.appendChild(inputText);
			commentTd = document.createElement("td");
			commentText = document.createTextNode(GLOBAL_JSON[i].comments);
			commentTd.appendChild(commentText);
			gradeTd = document.createElement("td");
			gradeText = document.createTextNode(GLOBAL_JSON[i].pointsGiven+'/'+GLOBAL_JSON[i].maxPoints);
			gradeTd.appendChild(gradeText);
	//	commentTr.appendChild(gradeIdTd);
		//commentTr.appendChild(commentTd);
		//commentTr.appendChild(gradeTd);
		codeTr.appendChild(codeIdTd);
		codeTr.appendChild(inputTd);
		codTr.appendChild(gradeIdTd);
		codeTr.appendChild(commentTd);
		codeTr.appendChild(gradeTd);
		codeTableBody.appendChild(codeTr)
		//gradeTableBody.appendChild(commentTr);
		}
		getGrade();
	}
	function goToHomepage() {
		window.location.href="https://web.njit.edu/~meu3/CS490/Exam-Generator-Release/student/studentHomepage.php";
	}
	window.onload = function() {
		ajaxGetRequest();
		//drawComments();
	}
</script>
</head>
	<div id="banner">
		<button id="homepageButton" name="homepageButton" onclick="goToHomepage()">Return to Homepage</button>
	</div>
	<h2>Grades and Comments</h2>
	<div id="rowDiv" class="row">
		<p id="testing"></p>
		<div class="column" style="background-color:#fff">
			<h2>Student Input</h2>
			<table id="codeTable">
				<thead>
					<th>Question #</th>
					<th>Code</th>
					<th>Question #</th>
					<th>Auto Comments</th>
					<th>Grade</th>
				</thead>
				<tbody = id="codeTableBody"></tbody>
			</table>
		</div>
		<div class="column" style="background-color:#a1">
			<h2>Grade:</h2>
			<h2 id="studentGrade"></h2>
			<h2>Comments and Points</h2>
			<table id="gradeTable">
				<thead>
					<tr>
							<th>Question #</th>
							<th>Auto Comments</th>
							<th>Grade</th>
					</tr>
				</thead>
				<tbody id="gradeTableBody"></tbody>
			</table>
		</div>
	</div>
	<div>
	<div>
</html>
