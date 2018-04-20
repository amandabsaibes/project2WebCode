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
	$currentTime = time();
	$currentMonth = date("Y-m",$currentTime);
	$currentMonth = $currentMonth . "-01 00:00:00";
	$sql = "SELECT * FROM Entries WHERE time >= '".$currentMonth."'";
	$statement = $connection->query($sql);
	if($statement->num_rows < 0)
	{
		return -1;
	}
	$total = $statement->num_rows;
	echo("This Month, <b>" . $total . "</b> People have walked by your sensor<br>");

	$year = date("Y",$currentTime);
	$currentYear = $year . "01-01 00:000:00";
	$sql = "SELECT * FROM Entries WHERE time >= '".$currentYear."'";
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
	$firstTime = $row['time'];
	while($row = $statement->fetch_assoc())
	{
		$lastTime = $row['time'];		
	}

	echo("first: ".$firstTime."<br> Last: ".$lastTime."<br>");
	$firstMonth = substr($firstTime,0,-9);
    $lastMonth = substr($lastTime,0,-9);
    echo($lastMonth."<br>");
    $datetime1 = date_create($firstMonth);
	$datetime2 = date_create($lastMonth);
	$interval = date_diff($datetime1, $datetime2);
	echo $interval->format('%M months');
    

	$runningTotal = 0;
	for($i = 1; $i < 13;	 $i++)
	{
		if($i < 10){$i = '0'.$i;}
		$j = $i + 1;
		if($j<10){$j='0'.$j;}
		$countingMonth = $year ."-".$i. "-01 00:00:00";
		if($j == 13)
		{
			$year++;
			$j = '01';
		}
		$nextMonth = $year ."-".$j. "-01 00:00:00";

		$sql = "SELECT * FROM Entries WHERE time >= '".$countingMonth."' AND time < '".$nextMonth."'";
		$statement = $connection->query($sql);
		if($statement->num_rows < 0)
		{
			return -1;
		}
		$total = $statement->num_rows;
		$runningTotal += $total;
	}
	echo($runningTotal);

	echo('total time: ' . $totalTime);
	echo('<br>');
	echo("what... " . ($totalTime/(60*60*24*30)));
	echo("On average, every Month <b>" . number_format($total/($totalTime/(60*60*24*30)),2) . "</b> People walk by your sensor<br>");
	echo("On average, every Year <b>" . number_format($total/($totalTime/(60*60*24*365)),2) . "</b> People walk by your sensor<br>");

// add in a daily average here
		echo("On Average, every Day <b>" . number_format($total/($totalTime/(60*60*24)),2) . "</b> People walk by your sensor<br>");

		//determine averages for seconds, minutes, hours, and days
	$sql = "SELECT * FROM Entries ORDER BY time";
	$statement = $connection->query($sql);
	if($statement->num_rows < 0)
	{
		return -1;
	}
	$total =  $statement->num_rows;
	$row = $statement->fetch_assoc();
	$firstTime = strtotime($row['time']);
	$totalTime = time() - $firstTime;
	if($totalTime < 0)
	{
		return -1;
	}
	echo("On Average, every Second <b>" . number_format($total/$totalTime,2) . "</b> People walk by your sensor<br>");
	echo("On Average, every Minute <b>" . number_format($total/($totalTime/60),2) . "</b> People walk by your sensor<br>");
	echo("On Average, every Hour <b>" . number_format($total/($totalTime/(60*60)),2) . "</b> People walk by your sensor<br>");


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