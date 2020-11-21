<?php
 // fname is the filename taken from the input form
 
$fname = false;
if(isset($_REQUEST['fname'])){
    $fname = $_REQUEST['fname'];
}

// gpx is the GPS route in GPX format
$gpx = false;
if(isset($_REQUEST['gpx'])){
    $gpx = $_REQUEST['gpx'];
}

// this is the name of the file to save on the server
$savedFile = "gpx-files/" . $fname . ".gpx";

$myFile = fopen($savedFile, "w") or die("Unable to open file!");
fwrite($myFile, $gpx);
fclose($myFile);
 
 echo 'File to save here -->: <a href="' . $savedFile . '">' . $fname . '.gpx</a>';

// echo 'filename is: ' . $savedFile;

?>


