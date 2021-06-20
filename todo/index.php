<?php


// ***********************************************************************************
// Todo-list:
// NOTE: The server URL for updating on row 357 needs to be updated to your server
// ***********************************************************************************



// first, we must state a date and time.
date_default_timezone_set('Europe/Stockholm');
$date = date_create();
 $now = date_format($date, 'Y-m-d H:i:s');		// create a variable of the time to put into the array, so we now then it was written
 // echo "Date now: " . $now .  "<br>\n";		// just for check
 
// ***  recieves the POSTed list and writes it to file *******************

if( isset($_POST['todo']) )
{
	$myfile = fopen("todo.js", "w") or die("Unable to open file!");		// opens the list or create a new one if not existing
	fwrite($myfile,  "[" . $_POST['todo'] . ", \"" . $now . "\"]");	// writes the recived list and the time to the file
	fclose($myfile);													// closes the file
	
	echo "List updated on server!";										// returns a verification to the browser that the file has been saved
	exit();																// stops this script. Needed so not the whole page is sent as AJAX-message
} else {
		$newList = "NULL";												// for testing
	 }

// ***********************************************************************
?>

<!DOCTYPE html>
<html>
<head>
<title>ToDo</title>
<meta charset="utf-8"/>
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <style>
 
:root{
	/* var-MainColor: #06c; */
   
   --std-width: 520px;
   --pos-left: calc(50vw - 260px);
   }
   
}

 @media only screen and (max-width: 320px) {
		/* var-MainColor: #06c; */
	   
	   --std-width: 230px;
	   --pos-left: 0px;
 }


 html {
	font-family: sans-serif;
	height: 100%;
	width: 100%;
	background-image: linear-gradient(180deg, #ee9, #aa8);
	font-size: 14pt;	
	}
 
 .wrapper {
	position: absolute;
	left: var(--pos-left);
	margin-left: auto;
	margin-right: auto;
	display: inline-block;
	width: var(--std-width); 
	height: calc(98vh);
	border: 1px solid #333;
	box-sizing: border-box;
	border-radius: 3px;
	padding: 3px;	
	background: #ccc;
	box-shadow: 0 0 5px #777; 
	
}
 
 ul {
	display: block;
	list-style-type: none;
	text-align: left;
	margin: 0px;
	padding: 0px;
	font-size: 0.8rem;
	font-weight: bold;
	overflow-y: scroll; 
}

li {
	max-width: calc(var(--std-width) - 40px);
	white-space: nowrap;
	margin: 3px 0px 3px 0px;
	border: 1px solid #777;
	border-radius: 2px;
	margin: 3px 3px 5px 3px;
	padding: 3px;
	background-color: #eee;
}
	
button {
	padding: 0px;
	border: 1px solid #333;
	border-radius: 3px;
	background-color: #666;
	color: #ee5;
	font-weight: bold;
	background: linear-gradient(#999, #777 50%, #666 51%, #444 75%); 
}

 button.delete {
	width: 20px;
	height: 20px;
	text-align: center;
	font-size: 0.75rem;
	margin: 0px 0px 0px 3px;
	vertical-align: bottom;
 }
 
 button.add {
	width: 22px;
	height: 22px;
	font-size: 0.9rem;
	font-weight: 900;
	vertical-align: top;
	box-shadow: 0 0 0px #000; 
	margin-left: 5px;
	padding-bottom: 3px;
 }
 
 button:hover, button:focus {
	background-color: #c33;
	border: 1px solid #ff0;
	background: linear-gradient(#a98, #a87 50%, #876 51%, #654 75%); 
 }
 
 button:focus {
	transform: translateY(1px); 
	color: #ff9;
	box-shadow: 0 0 5px #ff0; 
}
 
.item {
	position: relative;
	bottom: -3px;
	padding: 0px 0px 2px 3px;
	display: inline-block;
	overflow:  hidden; 
	white-space: nowrap;
    text-overflow: ellipsis;
	width: calc(var(--std-width) - 70px); 
}

.update {
	position: absolute;
	width: calc(var(--std-width) - 30px);
	bottom: 5px;
	left: 12px;
	background-color: #ff5;	 
	border: 1px solid #333;
	border-radius: 3px;
	margin: 3px;
	padding: 2px;
	font-size: 0.9rem;
	margin-bottom: 10px;
	font-weight: 400;
}

form {	
	display: inline-block;
}

#newItem {
	display: inline-block;
	width: calc(var(--std-width) - 140px);
}

#timeInfo, .small {
	font-size: 0.8rem;
	font-weight: bold;
	color: #338;
}

#timeInfo {
	position: absolute;
	bottom: 40px;
	padding-left: 14px;
}

.inputField {
	margin: 3px;
}

[class|=prio] {
	background-image: radial-gradient(farthest-corner at 50% 30%, #fff 0%, #999 100%);
	color: #555;
	display: inline-block;
	text-align: center;
	position: absolute;
	right: 5px;
	width: 0.9rem;
	height: 0.9rem;
	border: 1px solid #777;
	border-radius: 50%;
	z-index: 100;
}

.small {
	display: inline-block;
	padding-left: 5px;
	margin-bottom: 2px;
}

.prio-1 {
	background-image: radial-gradient(farthest-corner at 50% 30%, #fff 0%, #f00 100%);
}

.prio-2 {
	background-image: radial-gradient(farthest-corner at 50% 30%, #fff 0%, #dd0 100%);
}

.prio-3 {
	background-image: radial-gradient(farthest-corner at 50% 30%, #fff 0%, #0e0 100%);
}

 </style>
  
</head>
<body>
	<div class="wrapper">
	<div class="general">
		<div class="inputField" id="inputFiled">
		<div class="small">New Task:</div><br>
		<button type="button" class="add" onClick="adder()" id="addButton">+</button>

				<input type="text" id="newItem" name="newItem">
				<script>
				var input = document.getElementById("newItem");
				input.addEventListener("keyup", function(event) {
				  if (event.keyCode === 13) {
				   event.preventDefault();
				   document.getElementById("addButton").click();
				  }
				}); 
				</script>
				<select name="prio" id="prio">
				  <option value="0">---</option>
				  <option value="1">Lav</option>
				  <option value="2">Middels</option>
				  <option value="3">Høy</option>
				</select>
		</div>
	<hr noshade>
	</div>
	<div class="general">
		<ul id="itemList">
			<!-- the list is going to be buildt here -->
		</ul>
	</div>
	
	<p id="demo"></p>
	<div id="timeInfo">Last loaded: <span id="time">Time info goes here...</div>
		<div>
		<button class="update" onClick="update()">Update</button>
		</div>
	</div>

 <script>
  
 let file = <?php include 'todo.js'; ?>		// import the list
 let list = file[0];						// extract the list from the file
 let time = file[1];						// extract the time value
 
 document.getElementById("time").innerHTML = time;
  console.log(list);
 console.log("the list value is: " + list[0]);
 
 let i = 10;	 							// for some reason, i values less than 10 does not work 
 // for each in the list
  
list.forEach(addFromList);					//  steps thru the list and calls the function that makes an HTML-row for each item in the list

function show(){
	alert("this is show");
}


function addFromList(item) {
  addItem(item);
}

// this adds to the list 
function adder(){
		let addMe = document.getElementById("newItem").value;

		if(list.find(element => element == addMe) != undefined){
			alert("This is already addaed!");
		} else {
		//  Here we need top build an array to push in
		var tempArr = "";										// we need a temporary arre to put in, formated [newItem, prio]
		var prio = document.getElementById("prio").value;		// setting the prio variable
		tempArr = [addMe, prio];								// builds the array
		
		addItem(tempArr);
		list.push(tempArr);
		}
		update();
}

// this adds items, either from the list fetched from the server or from the input field in the browser
 function addItem(item) {
	let addedItem = item;
	var ul = document. getElementById("itemList");
	var li = document. createElement("li");
	
	li.setAttribute("id", "item" + i); 
	ul. appendChild(li);
	let xx = "item" + i.toString();

	document.getElementById("item" + i).innerHTML = '<button class="delete" onClick="deleteItem(\''  + xx + '\', \'' + addedItem + '\')">X</button>&nbsp;<div class="item">' + addedItem[0] + ' | <div class="prio-' +addedItem[1]+ '"> '	+ addedItem[1]  + '</div></div>';
	document.getElementById("newItem").value = "";
	i++;
}

// this deletes rows on the screen and items in the list
function deleteItem(delMe, itemName){
	console.log("before:" + list + "delete: " + itemName);
	document.getElementById(delMe).remove();
	list = list.filter(checkItem);
	console.log("List After:" + list);
	
	function checkItem(x) {
	  return x != itemName;
	}
}

// this sends an updated list to the server and reloads the page with the list that is on the server.
function update(){
	console.log(list);
	let send_data = "&todo=" + JSON.stringify(list);
	  
	  console.log("Send data= " + send_data );
	  
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
				document.getElementById("time").innerHTML = time;
				location.reload();
		}
	} 
	// ********* need to put in correct URL to send to!! *****************************************
  xhttp.open("POST", "http://127.0.0.1/todo/index.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(send_data);
}

</script> 
</body>
</html>
