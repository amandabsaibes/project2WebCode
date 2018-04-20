<!--dispGlobal.php-->
<!--
	displays all information regarding timestamps more massive than one week
-->
<?php
	//connect to the database
	$host = "database.cse.tamu.edu";
	$username = "emmaleepk";
	$password = "csce315AAE";
	$dbname = "emmaleepk";
	$connection = new mysqli($host, $username, $password, $dbname);
	//include top menu
	include("header.php");
?>
<div>
<?php
function queryGlobal($connection)
{
	//Total Number of Entries in the database
	$sql = "SELECT * FROM Entries";
	$statement = $connection->query($sql);
	if($statement->num_rows < 0) {return -1;}
	$totalInDatabase = $statement->num_rows;

	//Total value of entries in the database for the current month
	$currentTime = time();
	$currentMonth = date("Y-m",$currentTime);
	$currentMonth = $currentMonth . "-01 00:00:00";
	$sql = "SELECT * FROM Entries WHERE time >= '".$currentMonth."'";
	$statement = $connection->query($sql);
	if($statement->num_rows < 0) {return -1;}

	//the number of rows calculates the number of people who have walked by this month
	$totalPerMonth = $statement->num_rows;

	//Total value of entries in the database for the current year
	$year = date("Y",$currentTime);
	$currentYear = $year . "01-01 00:000:00";
	$sql = "SELECT * FROM Entries WHERE time >= '".$currentYear."'";
	$statement = $connection->query($sql);
	if($statement->num_rows < 0) {return -1;}

	//the number of rows calculates the number of people who have walked by this year
	$totalPerYear = $statement->num_rows;
	
	//calculates the unique year in the database -- to be used for averages 
	//averages will only consider months that an entry has been made
	$sql = "SELECT DATE_FORMAT(`time`, '%Y') Time FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%Y')";
	$statement = $connection->query($sql);
	$totalNumberOfYears = $statement->num_rows;

	//calculates the unique months in the database -- to be used for averages 
	//averages will only consider months that an entry has been made
	$sql = "SELECT DATE_FORMAT(`time`, '%Y-%m') Time FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%Y-%m')";
	$statement = $connection->query($sql);
	$totalNumberOfMonths = $statement->num_rows;

	//calculates the unique days in the database -- to be used for averages 
	//averages will only consider months that an entry has been made
	$sql = "SELECT DATE_FORMAT(`time`, '%Y-%m-%d') Time FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%Y-%m-%d')";
	$statement = $connection->query($sql);
	$totalNumberOfDays = $statement->num_rows;

	$numHoursPerDay = 24;
	$totalNumberOfHours = $totalNumberOfDays * $numHoursPerDay;
	
	echo("<h2> Total: <br></h2>");
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
	
}

queryGlobal($connection);
?>
</div>
</body>
</html>