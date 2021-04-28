This is a small list-device for shopping or other. It runs in the web browser and can be used on both computers or phones, even KaiOS phones.
No installation needed! All data is stored at the server in a JSON-file. No database needed!

Requrements:
webserver that runs PHP and access for PHP to write to file.

An example json-file is provided. 

There is no security arrangement what so ever, and there is no check if the JSON is valid or has the correct syntax.

USE the list:

- Just type in your things, and press + or enter on your keyboard. 
- Then all stuff is addded, press Update at the bottom of the screen. This saves your list on the server. 
It reloads the list in the broswer with an updated time for when it was updated. 
NOTE: This uses the server time! Servers often uses UTC, but noe always. This should be sorted with
the first row: "date_default_timezone_set('Europe/Stockholm');"
Adjust so it fits your location.

- To remove something from the list, press the X-button, and "Updated" when you want to store the changes on the server. 

NOTE:
On line 287 you need to change the server adress to the server you are useing:

 xhttp.open("POST", "http://127.0.0.1/list/index.php", true);
 
 The example above is the place I use on my local machin for testing and development.
