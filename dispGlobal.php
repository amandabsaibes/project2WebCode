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
function queryGlobal($connection)
{
	//TOTAL values for MONTH and YEAR
	$sql = "SELECT * FROM Entries WHERE time > DATE_SUB(NOW(), INTERVAL 1 MONTH)";
	$statement = $connection->query($sql);
	if($statement->num_rows < 0)
	{
		return -1;
	}
	$total = $statement->num_rows;
	echo("This Month, <b>" . $total . "</b> People have walked by your sensor<br>");
	$sql = "SELECT * FROM Entries WHERE time > DATE_SUB(NOW(), INTERVAL 1 YEAR)";
	$statement = $connection->query($sql);
	if($statement->num_rows < 0)
	{
		return -1;
	}
	$total = $statement->num_rows;
	echo("This Year, <b>" . $total . "</b> People have walked by your sensor<br>");
	//AVERAGE values for MONTH and YEAR

	$sql = "SELECT * FROM Entries ORDER BY time";
	$statement = $connection->query($sql);
	if($statement->num_rows < 0)
	{
		return -1;
	}
	$total =  $statement->num_rows;
	$row = $statement->fetch_assoc();
	echo($row['time']);
	$firstTime = strtotime($row['time']);
	echo($firstTime);
	echo('<br>'.time().'<br>');
	echo($total);
	echo('<br>'.strtotime(time()).'<br>');
	$totalTime = time() - $firstTime;
	if($totalTime < 0)
	{
		return -1;
	}
	echo('total time: ' . $totalTime);
	echo('<br>');
	echo("what... " . ($totalTime/(60*60*24*30)));
	echo("On average, every Month <b>" . number_format($total/($totalTime/(60*60*24*30)),2) . "</b> People walk by your sensor<br>");
	echo("On average, every Year <b>" . number_format($total/($totalTime/(60*60*24*365)),2) . "</b> People walk by your sensor<br>");

	$sql = "SELECT * FROM Entries";
	$statement = $connection->query($sql);
	if($statement->num_rows < 0)
	{
		return -1;
	}
	//Total number who have walked by
	$total = $statement->num_rows;
	echo("In total, <b>" . $total . "</b> people have walked by your sensor");
	
}
queryGlobal($connection);
?>