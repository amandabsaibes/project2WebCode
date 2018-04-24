
<!-- /****************************************************
** File: Proj2DispGlobal
** Project: Project 2 
**
** This file contains the queries for the database.
** There are multiple functions that access the database
** and return information based on what the HTML form
** asks for. 
**
****************************************************/-->
<!--dispGlobal.php-->
<!--
	displays all information regarding timestamps more massive than one week
-->
<?php
$host = "database.cse.tamu.edu";
	$username = "emmaleepk";
	$password = "csce315AAE";
	$dbname = "emmaleepk";
	$connection = new mysqli($host, $username, $password, $dbname);
	//include top menu
	include("header.php");
	include_once("Proj2Queries.php");
?>
<div>
<?php
	$totalInDatabase = TotalInDatabase();
	$totalPerMonth = TotalInMonth();
	$totalPerYear = TotalInYear();

	$totalNumberOfYears = TotalNumberOfYears();
	$totalNumberOfMonths = TotalNumberOfMonths();
	$totalNumberOfDays = TotalNumberOfDays();
	$numHoursPerDay = 24;
	$totalNumberOfHours = $totalNumberOfDays * $numHoursPerDay;

	echo("<h2> Totals: <br></h2>");
	//totals for the month and year (current)
	echo("This Month, <b>" . $totalPerMonth . "</b> People have walked by your sensor<br>");
	echo("This Year, <b>" . $totalPerYear . "</b> People have walked by your sensor<br><br>");
	echo("<h2> Averages: <br></h2>");
	//returns the average amount of people per year of the entire database
	echo("On average, every year <b>" . number_format($totalInDatabase/$totalNumberOfYears,2) . "</b> people walk by your sensor<br>");
	//returns the average amount of people per month of the entire database
	echo("On average, every month <b>" . number_format($totalInDatabase/$totalNumberOfMonths,2) . "</b> people walk by your sensor<br>");
	//returns the average amount of people per day of the entire database
	echo("On average, every day <b>" . number_format($totalInDatabase/$totalNumberOfDays,2) . "</b> people walk by your sensor<br>");
	echo("On average, every hour <b>" . number_format($totalInDatabase/$totalNumberOfHours,2) . "</b> people walk by your sensor<br><br>");

	echo("<h2> Database Total: <br></h2>");
	echo("In total, <b>" . $totalInDatabase . "</b> people have walked by your sensor");
?>
</div>
</body>
</html>