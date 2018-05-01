
<!-- /****************************************************
** File: Proj2DispGlobal
** Project: Project 2 
**
** This file calculates important information for the user.
** This information looks at the database in reference to 
** the current month, year, and day. Information about totals
** and averages are presented through this file.
**
****************************************************/-->
<!--dispGlobal.php-->
<!--
	displays all information regarding timestamps more massive than one week
-->
<?php

	// Navigation header to access all pages
	include("header.php");
	// File that contains all the queries that are used
	include_once("Proj2Queries.php");
?>
<div>
<?php
	// Total count in the database
	$totalInDatabase = TotalInDatabase();
	// Total count in the current month
	$totalPerMonth = TotalInMonth();
	// Total count in the current year
	$totalPerYear = TotalInYear();

	// Counts the unique years, months, and days
	// in the database
	$totalNumberOfYears = TotalNumberOfYears();
	$totalNumberOfMonths = TotalNumberOfMonths();
	$totalNumberOfDays = TotalNumberOfDays();

	$numHoursPerDay = 24;											//Total Number of Hours in a Day
	// Total number of hours in the database					
	$totalNumberOfHours = $totalNumberOfDays * $numHoursPerDay;

	// Prints information to the website page
	echo("<h2> Totals: <br></h2>");

	// Totals for the current month and year 
	echo("This Month, <b>" . $totalPerMonth . "</b> People have walked by your sensor<br>");
	echo("This Year, <b>" . $totalPerYear . "</b> People have walked by your sensor<br><br>");

	echo("<h2> Averages: <br></h2>");

	// Returns the average amount of people per year/month/day/hour of the entire database
	echo("On average, every year <b>" . number_format($totalInDatabase/$totalNumberOfYears,2) . "</b> people walk by your sensor<br>");
	echo("On average, every month <b>" . number_format($totalInDatabase/$totalNumberOfMonths,2) . "</b> people walk by your sensor<br>");
	echo("On average, every day <b>" . number_format($totalInDatabase/$totalNumberOfDays,2) . "</b> people walk by your sensor<br>");
	echo("On average, every hour <b>" . number_format($totalInDatabase/$totalNumberOfHours,2) . "</b> people walk by your sensor<br><br>");

	echo("<h2> Database Total: <br></h2>");
	echo("In total, <b>" . $totalInDatabase . "</b> people have walked by your sensor");
?>
</div>
</body>
</html>