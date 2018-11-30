<!DOCTYPE HTML>
<?php include 'teacherHeader.php'; ?>
<html>
<title> Add Quesitons to Database </title>
<!-- Resize to fit screen dynamically -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<style>
	* {box-sizing: border-box;}
	.row{display: flex;}
	.column{flex: 50%; padding: 10px;}
	table{border-spacing: 0; border: 1px solid grey}
	td,th{text-align: left; padding: 16px;}
	tr:nth-child(even){background-color: #fff;}
</style>
<script>
	function moveText() {
		var question = document.getElementById('question').value;
		var type = document.getElementById('type').value;
		var diff = document.getElementById('diff').value;
		//var points = document.getElementById('points').value;
		var node = document.createElement('li');
		var textNode = document.createTextNode('[Question: '+ question+ ' ] | [Type: ' + type + '] | [Difficulty: ' + diff + ']');// | [Points: '+ points + ']');
		node.appendChild(textNode);
		document.getElementById('selectedList').appendChild(node);
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
			//var selectTd = document.createElement("td");
			//selectTd.innerHTML = '<div class="text-center" ><input type="button" value="Select" onClick="addQuestion('+i+')" id="question_to_add_'+i+'"></div>';
			tr.appendChild(idTd);
			tr.appendChild(questionTd);
			tr.appendChild(typeTd);
			tr.appendChild(diffTd);
			//tr.appendChild(pointsTd);
			tr.appendChild(constrainTd);
			tr.appendChild(returnPrintTd);
			//tr.appendChild(selectTd);
			table.appendChild(tr);
			//GLOBAL_JSON = parseSample; //Initialize global variable for all other functions to use
			//document.getElementById("test").innerHTML = GLOBAL_JSON[0].question;
		}
	}
	function getTestCases() {
		var testCase = document.getElementById("testCase");
		var j = 0;
		var testCases = [];
		for(var i = 0; i < testCase.length; i++) {
			if(testCase.elements[i].value == "") {
				return testCases;
				//Terminates at blank test case
			} else {
				 testCases[j] = testCase.elements[i].value;
				 j++;
			 }
		}
		return testCases;
	}
	function getLoopType() {
		if(document.getElementById("forRadio").checked) {
			return "for";
		} else if (document.getElementById("whileRadio").checked) {
			return "while";
		} else if (document.getElementById("recursionRadio").checked){
			return "recursion";
		} else {
			return "none";
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
	function getAjaxRequest() {
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
	function ajaxRequest() {
		/*
			Question, Type(For/While), Difficulty, Points, Test Cases[], Function Name, Variables[], Return/Print
		*/
		var xmhlObj = new XMLHttpRequest();
		var phpFile = 'addQuestionsCurl.php'; //Need file
		var question = document.getElementById('question').value;
		var type = document.getElementById('type').value;
		var loopType = getLoopType();
		var diff = document.getElementById('diff').value;
		//var points = document.getElementById('points').value;
		var testCases = getTestCases();
		//document.getElementById("test").innerHTML = testCases;
		var functionName = document.getElementById('funcName').value;
		var varNames = document.getElementById('varNames').value;
		var returnPrint = document.getElementById('displayType').value;
		var url = "question="+question+"&type="+type+"&loopType="+loopType+"&diff="+diff+"&testCases="+testCases
							+"&functionName="+functionName+"&variableNames="+varNames+"&returnPrint="+returnPrint; //For AJAX POST

		xmhlObj.open("POST", phpFile, true);
		xmhlObj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //Sending URL encoded variables
		xmhlObj.onreadystatechange = function() {
			if(xmhlObj.readyState == 4 && xmhlObj.status == 200) {  //Conection is established and working
				//var return_data = xmhlObj.responseText;
				//document.getElementById("test").innerHTML = return_data;
					getAjaxRequest(); //Redraw Table
				}
			}
		xmhlObj.send(url); //Send request
		//document.getElementById("test").innerHTML = url;
	}
	function goToHomepage() {
		window.location.href="https://web.njit.edu/~meu3/CS490/Exam-Generator-Release/teacher/teacherHomepage.php";
	}
	window.onload = getAjaxRequest;
</script>
</head>
<body>
	<button onClick="goToHomepage()">Return to Homepage </button>
	<div class="row">
		<div class="column" style="background-color:#fff;">
			<h2> Enter Questions and Test Cases </h2>
			<p> Enter Question </p>
				<textarea name="question" id="question" placeholder="Write your question here" rows="5" cols="50" required></textarea>
			<p> Enter Function Name </p>
				<input type="text" name="funcName" id="funcName" placeholder="Function Name" required><br>
			<p> Enter Variable Names (Seperated by Commas) </p>
				<input type="text" name="varNames" id="varNames" placeholder="Variable Names" required><br>
			<p> Enter Test Cases (Leave Extra Inputs Blank) </p>
				<form id="testCase" action="">
					<input type="text" name="testCase1" id="testCase0" placeholder="Test Case #1" required>
					<input type="text" name="answer1" id="answer1" placeholder="Answer #1" required><br><br>
					<input type="text" name="testCase2" id="testCase2" placeholder="Test Case #2" required>
					<input type="text" name="answer2" id="answer2" placeholder="Answer #2" required><br><br>
					<input type="text" name="testCase3" id="testCase3" placeholder="Test Case #3" required>
					<input type="text" name="answer3" id="answer3" placeholder="Answer #3" required><br><br>
					<input type="text" name="testCase4" id="testCase4" placeholder="Test Case #4" required>
					<input type="text" name="answer4" id="answer4" placeholder="Answer #4" required><br><br>
					<input type="text" name="testCase5" id="testCase5" placeholder="Test Case #5" required>
					<input type="text" name="answer5" id="answer5" placeholder="Answer #5" required><br><br>
					<input type="text" name="testCase6" id="testCase6" placeholder="Test Case #6" required>
					<input type="text" name="answer6" id="answer6" placeholder="Answer #6" required><br><br>
				</form>
			<p> Select Question Difficulty:
				<select name="diff" id="diff" required>
					<option value="easy">Easy</option>
					<option value="medium">Medium</option>
					<option value="hard">Hard</option>
				</select>
			</p>
			<p> Select Question Type:
				<select name="type" id="type" required>
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
			</p>
			<p> Select Constraint:
						<input type="radio" id="forRadio" name="loopType" value="forLoop">For-Loop
						<input type="radio" id="whileRadio" name="loopType" value="whileLoop">While-Loop
						<input type="radio" id="recursionRadio" name="loopType" value="whileLoop">Recursion<br>
			</p>
			<p> Select if the output is Return or Printed
			<select name="displayType" id="displayType" required>
					<option value="return">Return</option>
					<option value="print">Print</option>
			</select>
			</p>
			<!--<p> Number of Points <input type="text" name="points" id="points" placeholder="Point Value" required> </p>-->
			<button onClick="ajaxRequest();">Submit Question:</button>
		</div>
		<div class="column" style="background-color:#bbb;">
			<h2> Submitted Questions </h2>
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
		</div>
	</div>
</body>
</html>
