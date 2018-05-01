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
		echo(predictionByDayAndMonth($dayOfWeekNumber, $monthSelected));
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

	function getMonthCount()
	{
		// Here we are counting the total occurances per month so that we can later average
		// the months with their number of active days
		$monthOfYearCount = array("01" => 0, "02" => 0, "03" => 0, "04" => 0, "05" => 0, "06" => 0, "07" => 0, "08" => 0, "09" => 0, "10" => 0, "11" => 0, "12" => 0);
		$sql = "SELECT DATE_FORMAT(`time`, '%m') Time, COUNT(*) FROM `Entries` GROUP BY DATE_FORMAT(`time`,'%m')";
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result))
		{
			$monthOfYearCount[$row['Time']] = $row['COUNT(*)'];
		}
		return $monthOfYearCount;
		
	}

	function getActiveDaysInMonth()
	{
		$monthActiveDayCount = array("01" => 0, "02" => 0, "03" => 0, "04" => 0, "05" => 0, "06" => 0, "07" => 0, "08" => 0, "09" => 0, "10" => 0, "11" => 0, "12" => 0);
		$sql = "SELECT DATE_FORMAT(`time`, '%m') Time FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%Y-%m-%d')";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_assoc($result))
		{
			$monthActiveDayCount[$row['Time']] += 1;
		}
		return $monthActiveDayCount;
	}	

	function MonthAverage()
	{
		// obtain an array of all the counts per month
		$countOfMonths = array();
		$countOfMonths = getMonthCount();
		// We need to calculate the number of active days per month
		$activeDaysInMonth = array();
		$activeDaysInMonth = getActiveDaysInMonth();
		//After calclating the number of active days per month, we can calculate the average per month for the entire year
		$averagePerMonth = array("01" => 0, "02" => 0, "03" => 0, "04" => 0, "05" => 0, "06" => 0, "07" => 0, "08" => 0, "09" => 0, "10" => 0, "11" => 0, "12" => 0);
		for($i = 1; $i < 13; $i++)
		{
			if($i < 10){$count = "0".$i;}
			else {$count = "".$i."";}
			if($activeDaysInMonth[$count] != 0) 
			{
				$averagePerMonth[$count] = $countOfMonths[$count]/$activeDaysInMonth[$count];
			}
		}
		return $averagePerMonth;
	}


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
		return $averagePerDay;
	}

/*
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
	}*/

	function predictionByDayAndMonth($day, $month)
	{
		$averagePerDay = array();
		$averagePerDay = DayAverage();
		
		$dayToNumber = DayOfWeekToNumber($day);		

		$selectedDayAvg = $averagePerDay[$dayToNumber];
		$averagePerMonth = MonthAverage();
		$selectedMonthAvg = $averagePerMonth[$month];
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

	print(predictionByDayAndMonth('04/19/2018',"04"));


?>
</div>
</body>
</html>

