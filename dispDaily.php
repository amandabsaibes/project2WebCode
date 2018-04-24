<!-- /****************************************************
** File: Proj2DispDaily.php
** Project: Project 2 
**
** This file contains the queries for the database.
** There are multiple functions that access the database
** and return information based on what the HTML form
** asks for. 
**
****************************************************/-->
	displays all information regarding timestamps less massive than one week
-->
<?php

	//include top menu
	include("header.php");
	include_once("Proj2Queries.php");
?>
<div>
<?php

	$TotalInHour = TotalInHour();
	$TotalInDay = TotalInDay();
	$TotalInWeek = TotalInWeek();
	$maxAndMinHour = MaxAndMinHour();
	$maxAndMinDay = MaxAndMinDay();

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