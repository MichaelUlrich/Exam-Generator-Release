<!DOCTYPE HTML>
<?php include 'teacherHeader.php'; ?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Select Questions</title>
<head>
<style>
	*{box-sizing: border-box;}
	.row{display: flex;}
	.column{flex: 50%; padding: 10px}
	//table,td{border: 1px solid grey;}
	table{border-spacing: 0; border: 1px solid grey}
	td,th{text-align: left; padding: 16px;}
	tr:nth-child(even){background-color: #bbb;}
	//th{left; padding: 16px;background-color: #f2f2f2; border: 1px solid grey}
</style>
<script>
	var GLOBAL_JSON;
	var TOTAL_POINTS = 0;

	function ajaxRequest(questionId) {
		var xmhlObj = new XMLHttpRequest();
		var phpFile = 'selectQuestionsCurl.php';
		var question = GLOBAL_JSON[questionId].question;
		var type = GLOBAL_JSON[questionId].type;
		var loopType = GLOBAL_JSON[questionId].loopType;
		var diff = GLOBAL_JSON[questionId].difficulty;
		var points = document.getElementById("userPoints"+questionId).value;//GLOBAL_JSON[questionId].points;
		var testCases = GLOBAL_JSON[questionId].testCases;
		var functionName = GLOBAL_JSON[questionId].functionName;
		var varNames = GLOBAL_JSON[questionId].varNames;
		var returnPrint = GLOBAL_JSON[questionId].returnPrint;
		var url = "question="+question+"&type="+type+"&loopType="+loopType+"&diff="+diff+"&points="+points+"&testCases="+testCases
							+"&functionName="+functionName+"&variableNames="+varNames+"&returnPrint="+returnPrint; //For AJAX POST
		xmhlObj.open("POST", phpFile, true);
		xmhlObj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //Sending URL encoded variables
		xmhlObj.onreadystatechange = function() {
		if(xmhlObj.readyState == 4 && xmhlObj.status == 200) {  //Conection is established and working
			var return_data = xmhlObj.responseText;
			}
		}
		xmhlObj.send(url); //Send request
		TOTAL_POINTS += parseInt(points, 10);
		document.getElementById("points").innerHTML = TOTAL_POINTS;
	}
	function drawAvailableTable(sample) {
		var table = document.getElementById("questionTableBody");
		table.innerHTML="";
		var parseSample = JSON.parse(sample); //Need for response from AJAX cURL */
		for(var i in parseSample) {
			var iInt = parseInt(i, 10);
			iInt += 1;
			var tr = document.createElement("tr");
			var idTd = document.createElement("td");
			var idText = document.createTextNode(iInt);
			idTd.appendChild(idText);
			var questionTd = document.createElement("td");
			var questionText = document.createTextNode(parseSample[i].question);
			questionTd.appendChild(questionText);
			var typeTd = document.createElement("td");
			var typeText = document.createTextNode(parseSample[i].type);
			typeTd.appendChild(typeText);
			var diffTd = document.createElement("td");
			var diffText =  document.createTextNode(parseSample[i].difficulty);
			diffTd.appendChild(diffText);
			//var pointsTd =  document.createElement("td");
			//pointsTd.innerHTML = '<div class="text-center"><input type="text" id=points placeholder="points"></div>';
			//pointsTd.appendChild(pointsText);
			var constrainTd = document.createElement("td");
			var constrainText = document.createTextNode(parseSample[i].loopType);
			constrainTd.appendChild(constrainText);
			var returnPrintTd = document.createElement("td");
			var returnPrintText = document.createTextNode(parseSample[i].returnPrint);
			returnPrintTd.appendChild(returnPrintText);
			var selectTd = document.createElement("td");
			selectTd.innerHTML = '<div class="text-center" ><input type="button" value="Select" onClick="addQuestion('+i+')" id="question_to_add_'+i+'"></div>';
			tr.appendChild(idTd);
			tr.appendChild(questionTd);
			tr.appendChild(typeTd);
			tr.appendChild(diffTd);
			//tr.appendChild(pointsTd);
			tr.appendChild(constrainTd);
			tr.appendChild(returnPrintTd);
			tr.appendChild(selectTd);
			table.appendChild(tr);
			GLOBAL_JSON = parseSample; //Initialize global variable for all other functions to use
			//document.getElementById("test").innerHTML = GLOBAL_JSON[0].question;
		}
	}
	function sortTable(callingObj, column) {
		/* column = 0 -> ID
		   column = 1 -> Question
		   column = 2 -> Type
		   column = 4 -> LoopType
		   column = 3 -> Difficulty
		   column = 5 -> return
		*/
		//document.getElementById("test").innerHTML =
		var input = document.getElementById(callingObj.id);
		//document.getElementById("test").innerHTML = callingObj.id;
		var inputCaps = input.value.toUpperCase();
		var table = document.getElementById("questionTable");
		var tr = table.getElementsByTagName("tr");
		var td;
		var i;

		for(i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[column];
			if(td) {
				if(td.innerHTML.toUpperCase().indexOf(inputCaps) > -1) {
					tr[i].style.display="";
				} else {
					tr[i].style.display="none";
				}
			}
		}
	}
	function addQuestion(questionId) {
		//document.getElementById("test").innerHTML = questionId;
		var intPoints;
		var question = GLOBAL_JSON[questionId].question;
		var type = GLOBAL_JSON[questionId].type;
		var diff = GLOBAL_JSON[questionId].difficulty;
		GLOBAL_JSON[questionId].points = points;
		var node = document.createElement("li");
		var textNode = document.createTextNode('[Question: '+ question+ ' ] | [Type: ' + type + '] | [Difficulty: ' + diff + ']');
	//	document.getElementById("test").innerHTML = textNode;
		var pointsLi =  document.createElement("li");
		pointsLi.innerHTML = '<div class="text-center"><input type="text" id=userPoints'+questionId+' placeholder="Enter Points"><button id=questionPoints'+questionId+' onClick="ajaxRequest('+questionId+')">Set Points</button></div>';
		//pointsLi.appendChild(pointsText);
		node.appendChild(textNode);
		document.getElementById('selectedQuestions').appendChild(node);
		document.getElementById('selectedQuestions').appendChild(pointsLi);
		//ajaxRequest(questionId);
	}
	function getAjaxRequest() {
	//	document.getElementById("test").innerHTML = "func called";
		var xmhlObj = new XMLHttpRequest();
		var phpFile = "selectQuestionsGetCurl.php";
		var return_data
		xmhlObj.open("POST", phpFile, true);
		xmhlObj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //Sending URL encoded variables
		xmhlObj.onreadystatechange = function() {
			if(xmhlObj.readyState == 4 && xmhlObj.status == 200) {  //Conection is established and working
				return_data = xmhlObj.responseText;
				drawAvailableTable(return_data);
			}
		}
		xmhlObj.send();
	}
	function goToHomepage() {
		window.location.href="https://web.njit.edu/~meu3/CS490/Exam-Generator-RC/teacherHomepage.php";
	}
	window.onload = getAjaxRequest;
</script>
</head>
<body>
	<button onClick="goToHomepage()">Return to Homepage</button>
	<h1> Chooose Questions to Add to the Test </h1>
	<div class="row">
		<div class="column" style="background-color:#bbb;">
			<h2> Selected Questions </h2>
			<p id="test2"></p>
			<ul id="selectedQuestions">
				<h2>Points: </h2><h2 id="points"></h2>
			</ul>
		</div>
		<div class="column" style="background-color:#fff;">
			<h2> Available Questions </h2>
			<p id="test"></p>
				<p>Sort Options:
				<input type="text" id="keywordSelect" onkeyup="sortTable(this, 1)"placeholder="Search by word...">
				<select id="typeSelect"  onChange="sortTable(this, 2)">
					<option value="" disabled selected>Type</option>
					<option value="loop">Loop</option>
					<option value="method">Method</option>
					<option value="variable">Variable</option>
					<option value="dictionaries">Dictionaries</option>
					<option value="lists">Lists</option>
					<option value="tuple">Tuples</option>
					<option value="arrays">Arrays</option>
					<option value="2dArrays">2D-Arrays</option>
					<option value="vectors">Vectors</option>
				</select>
				<select id="diffSelect"  onChange="sortTable(this, 3)">
					<option value"" disabled selected>Difficulty</option>
					<option value="easy">Easy </option>
					<option value="medium">Medium</option>
					<option value="hard">Hard</option>
				</select>
				<select id="ConstraintSelect"  onChange="sortTable(this, 4)">
					<option value"" disabled selected>Constraint</option>
					<option value="none">None</option>
					<option value="for">For-Loop</option>
					<option value="while">While-Loop</option>
					<option value="recursion">Recursion</option>
				</select>
				<select id="returnPrintSelect"  onChange="sortTable(this, 5)">
					<option value"" disabled selected>Return/Print</option>
					<option value="return">Return</option>
					<option value="print">Print</option>
				</select>
				</p>
			<table id="questionTable">
				<thead>
				<tr>
					<th>ID</th>
					<th>Question</th>
					<th>Type</th>
					<th>Difficulty</th>
					<!--<th>Points</th>-->
					<th>Constraint</th>
					<th>Return/Print</th>
				</tr>
				</thead>
				<tbody id="questionTableBody">
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
