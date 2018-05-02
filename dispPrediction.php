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
	$dataPoints = array();
	$dataPoints = DaysAndCountOfCurrentweek();
	$hourData = HoursAndCountOfCurrentDay();
	var_dump(HourAverage());
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
	$dataPointsPrediction = PredictNextWeek();


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
	        text: "Last Week With Data"
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
        text: "Next Week of Predicted Data"
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
        markerType: "square",

        markerSize: 10,
        //toolTipContent: "Count: {y} person<br>Weight: {x} kg",
        dataPoints: <?php echo json_encode($dataPointsPrediction, JSON_NUMERIC_CHECK); ?>
        }]
        });

        chart2.render();
      var chart3 = new CanvasJS.Chart("chartContainer3", {
        animationEnabled: true,
        exportEnabled: true,
        //theme: "light1",
        backgroundColor: "#fffdd0",
        title:{
        text: "Next Week of Predicted Data"
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
        maximum: 500,
        interval: 100
        },
        data: [{
        markerColor: "green",
        type: "line",
        markerType: "square",

        markerSize: 10,
        //toolTipContent: "Count: {y} person<br>Weight: {x} kg",
        dataPoints: <?php echo json_encode($hourData, JSON_NUMERIC_CHECK); ?>
        }]
        });

        chart3.render();
      }

</script>


<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<div id="chartContainer1" style="width: 45%; height: 300px;display: inline-block;"></div> 
<div id="chartContainer2" style="width: 45%; height: 300px;display: inline-block;"></div>
<div id="chartContainer3" style="width: 45%; height: 300px;display: inline-block;"></div><br/>

<?php PredictNextWeek();?>


</div>
</body>
</html>

