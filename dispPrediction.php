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

<?php
	function uniqueDaysAndCount()
	{
		$uniqueDay = array();
		$countPerDay = array();
		$sql = "SELECT DATE_FORMAT(`time`, '%Y-%m-%d') Time, COUNT(*) FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%Y-%m-%d')";
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result))
		{
			array_push($uniqueDay, $row['Time']);
			array_push($countPerDay, $row['COUNT(*)']);
		}
		$arrayReturn = array();
		array_push($arrayReturn, $uniqueDay, $countPerDay);
		return $arrayReturn;

	}

	$arrayDaysAndCount = array();
	$arrayDaysAndCount = uniqueDaysAndCount();
	$arrayDays = $arrayDaysAndCount[0];
	$arrayCount = $arrayDaysAndCount[1];
	var_dump($arrayDays);
	var_dump($arrayCount);
	$dataPoints = array();
	for($i = 0; $i < count($arrayDays); $i++)
	{
		$data = array("y"=>$arrayCount[$i], "label"=>$arrayDays[$i]);
		array_push($dataPoints, $data);
	}
?>
<script>
    window.onload = function () 
    {
        var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        exportEnabled: true,
        //theme: "light1",
        backgroundColor: "#fffdd0",
        title:{
        text: '<?php echo($chartTitle) ?>'
        },
        axisX:{
        title: "Timeframe",
        suffix: " "
        },
        axisY:{
        title: "Count",
        suffix: " people",
        minimum: 0,
        //max depends  on the max count found above
        maximum: 900,
        interval: 100
        },
        data: [{
        markerColor: "#FF1493",
        type: "line",
        markerType: "square",

        markerSize: 10,
        //toolTipContent: "Count: {y} person<br>Weight: {x} kg",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
        });
        chart.render();
    }
</script>




<div>
<?php
echo('<div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    <script         src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>');
	$parkingLots = array();
	$notParkingLots = array(2,16,17,28,29,31,39,46,52,53,56,57,105,106,116,121);
	$letterParkingLots = array(10,30,33,36,40,72,95,99,100,122);

	for($i=1; $i<123; $i++)
	{
		if(in_array($i,$notParkingLots) == false)
		{
			array_push($parkingLots, ''.$i.'');
		}
	}
	echo('<h2>Please select which TAMU Parking Lot you are interested in <br></h2>');
	echo("<form action='dispPrediction.php'>");
		echo("<input list='ParkingLots' name='PL'>");
		echo("<datalist id='ParkingLots'>");
			foreach ($parkingLots as $lot){
				echo("<option value = '".$lot."'>");
			}
		echo("</datalist> <br>");
		echo('<h2>Please select the date that you want a prediction for<br></h2>');
		echo('<input type = "date" name = "selectedDay">');


	echo("<input type='submit'>");
	echo("</form>");
	$parkingLotSelection = $_GET['PL'];
	$dateSelection = $_GET['selectedDay'];

	if($parkingLotSelection != NULL)
	{
		//echo("yo you picked ".$parkingLotSelection." and ".$dateSelection);
		$monthSelected = substr($dateSelection, 5, 2);
		//echo $monthSelected;
		$dayOfWeekNumber = DayOfWeekToNumber($dateSelection);
		echo(predictByDayAndMonth($dayOfWeekNumber, $monthSelected));

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

	function DayOfWeekToNumber($date)
	{
		$dayOfWeek = date('l', strtotime($date));
		$dayOfWeekToNumber = array("Sunday" => 0, "Monday" => 1, "Tuesday" => 2, "Wednesday" => 3, "Thursday" => 4, "Friday" => 5, "Saturday" => 6);
		$dayOfWeekNumber = $dayOfWeekToNumber[$dayOfWeek];
		return $dayOfWeekNumber;
	}

	function DayAverage()
	{
		$countForDayOfWeek = array();
		$sql = "SELECT DATE_FORMAT(`time`, '%w') Time, COUNT(*) FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%w')";
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result))
		{
			array_push($countForDayOfWeek, $row['COUNT(*)']);
		}
		$uniqueDayOfWeek = array(0, 0, 0, 0, 0, 0, 0);
		$sql = "SELECT DATE_FORMAT(`time`, '%Y-%m-%d') Time FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%Y-%m-%d')";
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result))
		{
			$dayOfWeekNumber = DayOfWeekToNumber($row['Time']);
			$uniqueDayOfWeek[$dayOfWeekNumber] += 1;
		}
		
		$averagePerDay = array();
		for ($i = 0; $i < count($uniqueDayOfWeek); $i++)
		{
			$average = $countForDayOfWeek[$i] / $uniqueDayOfWeek[$i];
			array_push($averagePerDay, $average);	
		}	
		//$dayRequested = DayOfWeekToNumber($dayOfWeek);
		return $averagePerDay;
	}


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
	//print(getDayAverage(5));
	

	function predictByDayAndMonth($day, $month)
	{
		$prediction = 0;
		$averageDay = getDayAverage($day);
		echo($averageDay.'<br>');
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

	function predictionByDayAndMonth($day, $month)
	{
		$averagePerDay = array();
		$averagePerDay = DayAverage();
		
		$dayToNumber = DayOfWeekToNumber($day);		

		$selectedDayAvg = $averagePerDay[$dayToNumber];
		echo($selectedDayAvg.' ');
		$selectedMonthAvg = getMonthAverage($month);
		echo($selectedMonthAvg.' ');	
		if (($selectedDayAvg == 0) || ($selectedMonthAvg == 0))
		{
			$prediction = "Not enough data!";
			return $prediction;
		}
		else
		{
			$prediction = ($selectedDayAvg+$selectedMonthAvg)/2;
		}
		return $prediction;
	}

	print(predictionByDayAndMonth('04/19/2018',04));


?>
</div>
</body>
</html>

