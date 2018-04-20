<!-- /****************************************************
** File: Proj1Queries
** Project: Project 1 
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
	//connect to database
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
function queryDaily($connection)
{
	//TOTAL people who walked by for the Hour, day, and week
	$sql = "SELECT * FROM Entries WHERE time > DATE_FORMAT(NOW(),'%Y-%m-%d %H:00:00')";
	$statement = $connection->query($sql);
	$total = $statement->num_rows;
	if($statement->num_rows < 0) {return -1;}
	echo("This Hour, <b>" . $total . "</b> People have walked by your sensor<br>");

	$sql = "SELECT * FROM Entries WHERE time >= CURDATE() ORDER BY time";
	$statement = $connection->query($sql);
	$total = $statement->num_rows;
	if($statement->num_rows < 0)
	{
		return -1;
	}
	echo("Today, <b>" . $total . "</b> People have walked by your sensor<br>");

	$sql = "SELECT * FROM Entries WHERE time > DATE_SUB(NOW(), INTERVAL 7 DAY)";
	$statement = $connection->query($sql);
	$total = $statement->num_rows;
	if($statement->num_rows < 0)
	{
		return -1;
	}
	echo("This Week, <b>" . $total . "</b> People have walked by your sensor<br><br>");


	//find the most and least busy hours
	$sql = "SELECT * FROM Entries WHERE time >= CURDATE() ORDER BY time";
	$statement = $connection->query($sql);
	$hours = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
	if($statement->num_rows < 0)
	{
		return -1;
	}
	while($row = $statement->fetch_assoc())
	{
		$time = $row['time'];
		$hour = date('H',strtotime($time));
		$hours[$hour]++;		
	}
	$min = array_search(min($hours),$hours);
	$max = array_search(max($hours),$hours);
	if($min > 12){ $minTime = ($min - 12).'PM'; }
	else 
	{
		if($min == 0) {$minTime = '12AM';}
		else{$min = $minTime . 'AM';}
	}
	if($max > 12){ $maxTime = ($max - 12).'PM'; }
	else 
	{
		if($max == 0) {$maxTime = '12AM';}
		else{$max = $maxTime . 'AM';}
	}

	echo("Today, the fewest people (".$hours[$min].") walked at <b>" . $minTime . "</b><br>");
	echo("Today, the most people (".$hours[$max].") walked by at <b>" . $maxTime . "</b><br><br>");
	
	//find the most and least busy days for last week
	$sql = "SELECT * FROM Entries WHERE time >= DATE_SUB(curdate(),INTERVAL 7 DAY) AND time < curdate()";
	$statement = $connection->query($sql);
	if($statement->num_rows < 0)
	{
		return -1;
	}
	$days = array(0,0,0,0,0,0,0);
	$dayNames = array("Sunday" => 0,"Monday" => 0,"Tuesday" => 0,"Wednesday" => 0,"Thursday" => 0,"Friday" => 0,"Saturday" => 0);
	while($row = $statement->fetch_assoc())
	{
		$time = $row['time'];
		$dayOfWeek = date('l', strtotime($time));
		$dayNames[$dayOfWeek]++;			
	}
	$min = array_search(min($dayNames),$dayNames);
	$max = array_search(max($dayNames),$dayNames);
	if($min < 0 || $min > count($days))
	{
		return -1;
	}
	if($max < 0 || $max > count($days))
	{
		return -1;
	}
	echo("Last week, the fewest people walked by on <b>" . $min . "</b> (".$dayNames[$min].")<br>");
	echo("Last week, the most people walked by on <b>" . $max . "</b> (".$dayNames[$max].")<br><br>");
}
queryDaily($connection);
?>
</div>
</body>
</html>