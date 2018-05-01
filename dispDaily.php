<!-- /****************************************************
** File: Proj2DispDaily.php
** Project: Project 2 
**
** This file displays information about the current 
** time. Information presented includes the total count
** for the current day, hour, and week. Other information 
** is the busiest and slowest times for the current week 
** and day
****************************************************/-->
<?php

	// Navigation Header to access all pages
	include("header.php");
	// file that contains all the queries used 
	include_once("Proj2Queries.php");
?>
<div>
<?php

	// call to functions to find the total in the current
	// hour, day, week
	$TotalInHour = TotalInHour();
	$TotalInDay = TotalInDay();
	$TotalInWeek = TotalInWeek();
	// call to function to find the busiest and slowest times
	// in the current hour and day
	$maxAndMinHour = MaxAndMinHour();
	$maxAndMinDay = MaxAndMinDay();

	//print the resulting values on to the webpage
	echo ("<h2>Totals:</h2>");
	echo($TotalInHour);
	echo($TotalInDay);
	echo($TotalInWeek);


	echo("<h2> Min/Max:</h2>");
	echo($maxAndMinHour);

	echo("<h2> Min/Max of Last Week:</h2>");
	echo($maxAndMinDay);
?>
</div>
</body>
</html>