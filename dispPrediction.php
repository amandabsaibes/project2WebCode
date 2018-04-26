
<?php
	#include '/vendor/autoload.php';
	#use Phpml\Regression\SVR;

	$host = "database.cse.tamu.edu";
	$username = "emmaleepk";
	$password = "csce315AAE";
	$dbname = "emmaleepk";
	$connection = mysql_connect($host, $username, $password);
	mysql_select_db($dbname);
	include("header.php");
?>
<div>
<?php
	$parkingLots = array();
	$notParkingLots = array(2,16,17,28,29,31,39,46,52,53,56,57,105,106,116,121);
	$letterParkingLots = array(10,30,33,36,40,72,95,99,100,122);

	for($i=1; $i<123; $i++)
	{
		if(in_array($i,$notParkingLots) == false)
		{
			array_push($parkingLots, ''.$i.'');
		}
		// if(in_array($i, $letterParkingLots))
		// {
		// 	array_push($parkingLots, ''.$i.'a');
		// 	if($i != 30){array_push($parkingLots, ''.$i.'b');}
		// 	if($i == 30 || $i == 36 || $i == 40 || $i == 100 || $i == 122)
		// 	{
		// 		array_push($parkingLots, ''.$i.'c');
		// 		if($i != 122)
		// 		{
		// 			array_push($parkingLots, ''.$i.'d');
		// 			if($i != 40)
		// 			{
		// 				array_push($parkingLots, ''.$i.'e');
		// 				if($i == 100)
		// 				{
		// 					array_push($parkingLots, ''.$i.'f', ''.$i.'g', ''.$i.'j', ''.$i.'m');
		// 				}
		// 			}
		// 		}

		// 	}
		// }
	}
	echo('<h2>Please select which TAMU Parking Lot you are interested in <br></h2>');
	echo("<form action='dispPrediction.php'>");
		echo("<input list='ParkingLots' name='PL'>");
		echo("<datalist id='ParkingLots'>");
			foreach ($parkingLots as $lot){
				echo("<option value = '".$lot."'>");
			}
		echo("</datalist> <br>");
		echo("<input type='submit'>");
	echo("</form>");
	$parkingLotSelection = $_GET['PL'];



	if($parkingLotSelection != NULL)
	{
		echo("yo you picked ".$parkingLotSelection);
	}

	function predictByHour()
	{
		$recordOfDay = array();
		$sql = "SELECT DATE_FORMAT(`time`, '%H') as Time, COUNT(`record`) as Count FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%H') ";
		$result = mysql_query($sql);
		if($result == false){
			echo mysql_error();
		}
		while($row = mysql_fetch_assoc($result))
		{
			$recordOfDay[]=$row;
			#echo $row[`record`];
		}	
		
		#Train#
		$samples = array();
		$hours = array();
		for($i=0; $i<sizeof($recordOfDay);$i++)
		{		
			array_push($samples, $recordOfDay[$i]['Count']);
			array_push($hours, $recordOfDay[$i]['Time']);		
		}
		$regression = new LeastSquares();
		$regression->train($samples, $targets);
		echo($regression->predict([11]));
	}

	function predictByHourAndDay($hour, $day)
	{
		$dayHourArray = array();
		$sqlSum = "SELECT COUNT(`record`) as SUM FROM `Entries` WHERE DATE_FORMAT(`time`, '%d') = {$day}";
		$resultOne = mysql_query($sqlSum);
		$sum = mysql_result($resultOne, 0);
		$sql = "SELECT DATE_FORMAT(`time`, '%d') as Day, DATE_FORMAT(`time`, '%h')as Hour, COUNT(`record`) as Count FROM `Entries` WHERE DATE_FORMAT(`time`, '%d') ={$day} GROUP BY DATE_FORMAT(`time`, '%h')";
		$result = mysql_query($sql);

		while($row = mysql_fetch_assoc($result))
		{
			$dayHourArray[] = $row;
		}
		print_r($dayHourArray);
		for($i=0; $i < count($dayHourArray); $i++){
			if($dayHourArray[$i]['Hour']==$hour)
			{
				$hourTotal = $dayHourArray[$i]['Count'];
				break;
			}							
		}
		$average = ($sum+$hourTotal)/2;
		echo($average);		
	}

	function predictByDayAndMonth($day, $month)
	{
		$monthDayArray = array();
		$sqlSum = "SELECT COUNT(`record`) as SUM FROM `Entries` WHERE DATE_FORMAT(`time`, '%m') = {$month}";
		$resultOne = mysql_query($sqlSum);
		$sum = mysql_result($resultOne, 0);
		$sql = "SELECT DATE_FORMAT(`time`, '%m') as Month, DATE_FORMAT(`time`, '%d')as Day, COUNT(`record`) as Count FROM `Entries` WHERE DATE_FORMAT(`time`, '%m') ={$month} GROUP BY DATE_FORMAT(`time`, '%d')";
		$result = mysql_query($sql);

		while($row = mysql_fetch_assoc($result))
		{
			$monthDayArray[] = $row;
		}

		for($i=0; $i < count($monthDayArray); $i++){
			if($monthDayArray[$i]['Day']==$day)
			{
				$dayTotal = $monthDayArray[$i]['Count'];
				break;
			}							
		}
		$average = ($sum+$dayTotal)/2;
		echo($average);
		
	}

	function predictByMonthAndYear($month, $year)
	{
		$yearMonthArray = array();
		$sqlSum = "SELECT COUNT(`record`) as SUM FROM `Entries` WHERE DATE_FORMAT(`time`, '%Y') = {$year}";
		$resultOne = mysql_query($sqlSum);
		$sum = mysql_result($resultOne, 0);
		$sql = "SELECT DATE_FORMAT(`time`, '%Y') as Year, DATE_FORMAT(`time`, '%m')as Month, COUNT(`record`) as Count FROM `Entries` WHERE DATE_FORMAT(`time`, '%Y') ={$year} GROUP BY DATE_FORMAT(`time`, '%m')";
		$result = mysql_query($sql);

		while($row = mysql_fetch_assoc($result))
		{
			$yearMonthArray[] = $row;
		}

		for($i=0; $i < count($yearMonthArray); $i++){
			if($yearMonthArray[$i]['Month']==$month)
			{
				$monthTotal = $yearMonthArray[$i]['Count'];
				break;
			}							
		}
		$average = ($sum+$monthTotal)/2;
		echo($average);		
	}
	predictByMonthAndYear(04,2018);
	

?>
</div>
</body>
</html>

