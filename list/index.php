<?php

// first, we must state a date and time.
date_default_timezone_set('Europe/Stockholm');
$date = date_create();
 $now = date_format($date, 'Y-m-d H:i:s');		// create a variable of the time to put into the array, so we now then it was written
 // echo "Date now: " . $now .  "<br>\n";		// just for check
 
// ***  recieves the POSTed list and writes it to file *******************

if( isset($_POST['list']) )
{
	$myfile = fopen("list.js", "w") or die("Unable to open file!");		// opens the list or create a new one if not existing
	fwrite($myfile,  "[" . $_POST['list'] . ", \"" . $now . "\"]");	// writes the recived list and the time to the file
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
<meta charset="utf-8"/>
 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
 <style>
 
:root{
	/* var-MainColor: #06c; */
   
   --std-width: 320px;
}

 @media only screen and (max-width: 320px) {
	 :root{
		/* var-MainColor: #06c; */
	   
	   --std-width: 230px;
	}
 }


 
 html {
	font-family: sans-serif;
	/* background-color: #ccc; */
	height: 100%;
	background-image: linear-gradient(180deg, #bbd, #88a);
	
 }
 
 .wrapper {
	width: var(--std-width);
	height: calc(98vh);
	border: 1px solid #333;
	box-sizing: border-box;
	padding: 3px;	
	margin: 0px;
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
	max-width: calc(var(--std-width) - 60px);
	white-space: nowrap;
	margin: 3px 0px 3px 0px;	
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
	width: 20px;
	height: 20px;
	font-size: 0.9rem;
	font-weight: 900;
	vertical-align: top;
 }
 
 button:hover {
	background-color: #c33;
	border: 1px solid #ff0;
	background: linear-gradient(#a98, #a87 50%, #876 51%, #654 75%); 
 }
 
 button:active{
	background: linear-gradient(#a98, #a87 50%, #876 51%, #654 75%);
	 transform: translateY(1px); 
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
	width: calc(var(--std-width) - 60px); 
	border-bottom: 1px solid #333;

}

.update {
	position: absolute;
	width: calc(var(--std-width) - 16px);
	bottom: 5px;
	left: 12px;
	/* display: block; */
	/* background-color: #ff5;	 */
	border: 1px solid #333;
	border-radius: 3px;
	margin: 3px;
	padding: 2px;
	font-size: 0.8rem;
	/* color: #333; */
	margin-bottom: 10px;
	/* background: linear-gradient(180deg, #444 10%, #775 55%, #555 65%, #333 80% ); */
}

form {	
	display: inline-block;
}

#newItem {
	display: inline-block;
	width: calc(var(--std-width) - 42px);
}

#timeInfo {
	position: absolute;
	bottom: 40px;
	font-size: 0.8rem;
	font-weight: bold;
	padding-left: 5px;
	color: #338;
}

 </style>
  
</head>
<body>
	<div class="wrapper">
	<div class="full-width">
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
	</div>
	<hr noshade>
	
	<div class="full-width">
		<ul id="itemList">
			<!-- 
			<li><input type="checkbox" id="item1" name="item1" value="value of item1"> Item 1<button class="delete">X</button></li>
			<li><input type="checkbox" id="item2" name="item2" value="value of item1"> Item 2<button class="delete">X</button></li> 
			-->
		</ul>
	</div>
	
	<p id="demo"></p>
	<div id="timeInfo">Last loaded: <span id="time">Time info goes here...</div>
		<div>
		<button class="update" onClick="update()">Update</button>
		</div>
	</div>

 <script>
  
 let file = <?php include 'list.js'; ?>		// import the list
 let list = file[0];						// extract the list from the file
 let time = file[1];						// extract the time value
 
 document.getElementById("time").innerHTML = time;
  
 console.log("the time value is: " + time);
 
 let i = 10;	 
 // for each in the list
  
list.forEach(addFromList);		//  steps thru the list and calls the function that makes an HTML-row for each item in the list

function show(){
	alert("this is show");
}


function addFromList(item) {
  addItem(item);
}

// this adds to the list 
function adder(){
		// console.log("adder function is running");
		let addMe = document.getElementById("newItem").value;

		if(list.find(element => element == addMe) != undefined){
			alert("This is already addaed!");
		} else {		
		addItem(addMe);
		list.push(addMe);
		}
}

// this adds items, either from the list fetched from the server or from the input field in the browser
 function addItem(item) {
	let addedItem = item;
	var ul = document. getElementById("itemList");
	var li = document. createElement("li");
	
	li.setAttribute("id", "item" + i); 
	ul. appendChild(li);
	let xx = "item" + i.toString();

	document. getElementById("item" + i).innerHTML = '<button class="delete" onClick="deleteItem(\''  + xx + '\', \'' + addedItem + '\')">X</button>&nbsp;<div class="item">' + addedItem + '</div>';
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
	let send_data = "&list=" + JSON.stringify(list);
	  
	  console.log("Send data= " + send_data );
	  
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
				document.getElementById("time").innerHTML = time;
				location.reload();
		}
	} 
	// ********* need to put in correct URL to send to!! *****************************************
  xhttp.open("POST", "http://127.0.0.1/list/index.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(send_data);
}

</script> 
</body>
</html>
