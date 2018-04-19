<!--dispDaily.php-->
<!--
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

function queryDaily($connection)
{
	//TOTAL people who walked by for the Hour, day, and week
	$sql = "SELECT * FROM Entries WHERE time > DATE_FORMAT(NOW(),'%Y-%m-%d %H:00:00')";
	$statement = $connection->query($sql);
	$total = $statement->num_rows;
	if($statement->num_rows < 0)
	{
		return -1;
	}
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
	
	//find the most and least busy days for Last week
	$sql = "SELECT * FROM Entries WHERE time >= DATE_SUB(curdate(),INTERVAL DAYOFWEEK(curdate()) - 6 DAY)
		AND time < DATE_SUB(curdate(), INTERVAL DAYOFWEEK(curdate()) + 1 DAY)";
	$statement = $connection->query($sql);
	if($statement->num_rows < 0)
	{
		return -1;
	}
	$days = array(0,0,0,0,0,0,0);
	$dayNames = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
	while($row = $statement->fetch_assoc())
	{
		$time = strtotime($row['time']);
		$timeNow = unixtojd(time());
		$timeNow = (1 + $timeNow) % 7;
		$timeNow = floor((time() - $timeNow * 60 * 60 *24));
		$timeDif = floor(($timeNow - $time)/(60*60 * 24))+1;
		$days[7-$timeDif]++;			
	}
	$min = array_search(min($days),$days);
	$max = array_search(max($days),$days);
	if($min < 0 || $min >count($days))
	{
		return -1;
	}
	if($max < 0 || $max >count($days))
	{
		return -1;
	}
	echo("Last week, the fewest people walked by on <b>" . $dayNames[$min] . "</b><br>");
	echo("Last week, the most people walked by on <b>" . $dayNames[$max] . "</b><br>");
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
	echo("On Average, every Day <b>" . number_format($total/($totalTime/(60*60*24)),2) . "</b> People walk by your sensor<br>");
}
queryDaily($connection);
?>