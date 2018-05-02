<!-- /****************************************************
** File: Proj2DispPrediction
** Project: Project 2 
**
** 
**
****************************************************/-->

<?php

	#include '/vendor/autoload.php';
	#use Phpml\Regression\SVR;

	// Navigation header to access all pages
	include("header.php");
	// File that contains all the queries that are used
	include_once("Proj2Queries.php");
?>

<?php
	$arrayDaysAndCount = array();
	$arrayDaysAndCount = DaysAndCountOfCurrentweek();
	$arrayDays = array();
	$arrayCount = array();
	$arrayDays = $arrayDaysAndCount[0];
	$arrayCount = $arrayDaysAndCount[1];
	$dataPoints = array();
	for($i = 0; $i < count($arrayDays); $i++)
	{
		$data = array("y"=>$arrayCount[$i], "label"=>$arrayDays[$i]);
		array_push($dataPoints, $data);
	}

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
	}
	echo('<h2>Please select which TAMU Parking Lot you are interested in <br></h2>');
	echo("<form action='dispPrediction.php'>");
		echo("<input list='ParkingLots' name='PL'>");
		echo("<datalist id='ParkingLots'>");
			foreach ($parkingLots as $lot){
				echo("<option value = '".$lot."'>");
			}
		echo("</datalist> <br>");
		// echo('<h2>Please select the date that you want a prediction for<br></h2>');
		// echo('<input type = "date" name = "selectedDay">');


	echo("<input type='submit'>");
	echo("</form>");
	$parkingLotSelection = $_GET['PL'];
	// $dateSelection = $_GET['selectedDay'];

	if($parkingLotSelection != NULL)
	{
		// $monthSelected = substr($dateSelection, 5, 2);
		// echo(PredictionByDayAndMonth($dayOfWeekNumber, $monthSelected));
	}


	//print(PredictionByDayAndMonth('04/19/2018',"04"));
	$dataPointsPrediction = array();
	$dataPrediction = array("y"=>PredictionByDayAndMonth('04/22/2018','04'), "label" => '04/22/2018');
	array_push($dataPointsPrediction, $dataPrediction);
	$dataPrediction = array("y"=>PredictionByDayAndMonth('04/23/2018','04'), "label" => '04/23/2018');
	array_push($dataPointsPrediction, $dataPrediction);
	$dataPrediction = array("y"=>PredictionByDayAndMonth('04/24/2018','04'), "label" => '04/24/2018');
	array_push($dataPointsPrediction, $dataPrediction);
	$dataPrediction = array("y"=>PredictionByDayAndMonth('04/25/2018','04'), "label" => '04/25/2018');
	array_push($dataPointsPrediction, $dataPrediction);
	$dataPrediction = array("y"=>PredictionByDayAndMonth('04/26/2018','04'), "label" => '04/26/2018');
	array_push($dataPointsPrediction, $dataPrediction);
	$dataPrediction = array("y"=>PredictionByDayAndMonth('04/27/2018','04'), "label" => '04/27/2018');
	array_push($dataPointsPrediction, $dataPrediction);
	$dataPrediction = array("y"=>PredictionByDayAndMonth('04/28/2018','04'), "label" => '04/28/2018');
	array_push($dataPointsPrediction, $dataPrediction);
	//var_dump($dataPointsPrediction);




/*	
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
*/

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

?>

<script>
	window.onload = function () {
    	var chart1 = new CanvasJS.Chart("chartContainer1", 
    	{
	        animationEnabled: true,
	        exportEnabled: true,
	        //theme: "light1",
	        backgroundColor: "#fffdd0",
	        title:{
	        text: "hello"
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
	        data: [
		{
		        markerColor: "#FF1493",
	       		type: "line",
	        	markerType: "square",
	        	markerSize: 10,
	        	//toolTipContent: "Count: {y} person<br>Weight: {x} kg",
	        	dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK);?>
       		}]
        });
	chart1.render();
        
	var chart2 = new CanvasJS.Chart("chartContainer2", {
        animationEnabled: true,
        exportEnabled: true,
        //theme: "light1",
        backgroundColor: "#fffdd0",
        title:{
        text: "wtf"
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
        markerColor: "green",
        type: "line",
        markerType: "circle",

        markerSize: 10,
        //toolTipContent: "Count: {y} person<br>Weight: {x} kg",
        dataPoints: <?php echo json_encode($dataPointsPrediction, JSON_NUMERIC_CHECK); ?>
        }]
        });

        chart2.render();
      }

</script>


<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<div id="chartContainer1" style="width: 45%; height: 300px;display: inline-block;"></div> 
<div id="chartContainer2" style="width: 45%; height: 300px;display: inline-block;"></div><br/>

<?php PredictNextWeek();?>


</div>
</body>
</html>

