
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
		echo("yo yo yo you picked ".$parkingLotSelection);
	}
	

	function getMonthAverage($month)
	{
		$averageTotal = 0;
		$averageMonthArray = array();
		$sql = "SELECT DATE_FORMAT(`time`, '%m') as Month, AVG(`record`) as Average FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%m')";
		$result = mysql_query($sql);

		while($row = mysql_fetch_assoc($result))
		{
			$averageMonthArray[] = $row;
		}

		for($i=0; $i < count($averageMonthArray); $i++){
			if($averageMonthArray[$i]['Month']==$month)
			{
				$averageTotal = $averageMonthArray[$i]['Average'];
				break;
			}							
		}

		return $averageTotal;		
	}	
	#print(getMonthAverage(04));

	#0=Sunday 6=Saturday#
	function getDayAverage($day)
	{
		$averageTotal = 0;
		$averageWeekArray = array();
		$sql = "SELECT DATE_FORMAT(`time`, '%w') as Day, AVG(`record`) as Average FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%w')";
		$result = mysql_query($sql);

		while($row = mysql_fetch_assoc($result))
		{
			$averageWeekArray[] = $row;
		}

		for($i=0; $i < count($averageWeekArray); $i++){
			if($averageWeekArray[$i]['Day']==$day)
			{
				$averageTotal = $averageWeekArray[$i]['Average'];
				break;
			}										
		}	
		return $averageTotal;	
	}
	#print(getDayAverage(5));
	

	function predictByDayAndMonth($day, $month)
	{
		$prediction = 0;
		$averageDay = getDayAverage($day);
		#print($averageDay);
		$averageMonth = getMonthAverage($month);
		#print($averageMonth);
		if (($averageDay == 0) || ($averageMonth == 0))
		{
			$prediction = "Not enough data!";
			return $prediction;
		}
		else
		{
			$prediction = ($averageDay+$averageMonth)/2;
		}
		return $prediction;		
	}
	print(predictByDayAndMonth(5,04));

	

?>
</div>
</body>
</html>

