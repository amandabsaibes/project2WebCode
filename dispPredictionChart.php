<?php 
    // Navigation header to access all pages
    include("header.php");
    // File that contains all the queries that are used
    include_once("Proj2Queries.php");

    $parkingLotSelection = $_GET['PL'];
    echo("You selected lot: ".$parkingLotSelection.'! <br>');

    /******************************************************************
                               ENTERING DATA
    ******************************************************************/
    // Outputs the datapoints to be used for the graph for the Last Week
    // Also outputs the maximum for the graph
    $LastWeekEnter = array();
    $dataPointsLastWeekEnter = array();
    $LastWeekEnter = DaysAndCountOfCurrentWeek($parkingLotSelection, 1);
    $dataPointsLastWeekEnter = $LastWeekEnter[0];
    $maxCountLastWeekEnter = $LastWeekEnter[1];

    // Outputs the prediction datapoints to be used for the graph for Next Week
    // Also outputs the maximum for the graph
    $PredictionWeekEnter = array();
    $PredictionWeekEnter = PredictNextWeek($parkingLotSelection, 1);
    $dataPointsPredictionWeekEnter = array();
    $dataPointsPredictionWeekEnter = $PredictionWeekEnter[0];
    $maxCountPredictionWeekEnter = $PredictionWeekEnter[1];

    // Outputs the datapoints to be used for the graph for the Last Day
    // Also outputs the maximum for the graph
    $LastDayEnter = array();
    $LastDayEnter = HoursAndCountOfCurrentDay($parkingLotSelection, 1);
    $dataPointsLastDayEnter = array();
    $dataPointsLastDayEnter = $LastDayEnter[0];
    $maxCountLastDayEnter = $LastDayEnter[1];

    // Outputs the prediction datapoints to be used for the graph for Next Week
    // Also outputs the maximum for the graph
    $PredictionDayEnter = array();
    $PredictionDayEnter = PredictNextDay($parkingLotSelection, 1);
    $dataPointsPredictionDayEnter = array();
    $dataPointsPredictionDayEnter = $PredictionDayEnter[0];
    $maxCountPredictionDayEnter = $PredictionDayEnter[1];


    /******************************************************************
                               EXITIING DATA
    ******************************************************************/
    // Outputs the datapoints to be used for the graph for the Last Week
    // Also outputs the maximum for the graph
    $LastWeekExit = array();
    $dataPointsLastWeekExit = array();
    $LastWeekExit = DaysAndCountOfCurrentWeek($parkingLotSelection, 0);
    $dataPointsLastWeekExit = $LastWeekExit[0];
    $maxCountLastWeekExit = $LastWeekExit[1];

    // Outputs the prediction datapoints to be used for the graph for Next Week
    // Also outputs the maximum for the graph
    $PredictionWeekExit = array();
    $PredictionWeekExit = PredictNextWeek($parkingLotSelection, 0);
    $dataPointsPredictionWeekExit = array();
    $dataPointsPredictionWeekExit = $PredictionWeekExit[0];
    $maxCountPredictionWeekExit = $PredictionWeekExit[1];

    // Outputs the datapoints to be used for the graph for the Last Day
    // Also outputs the maximum for the graph
    $LastDayExit = array();
    $LastDayExit = HoursAndCountOfCurrentDay($parkingLotSelection, 0);
    $dataPointsLastDayExit = array();
    $dataPointsLastDayExit = $LastDayExit[0];
    $maxCountLastDayExit = $LastDayExit[1];

    // Outputs the prediction datapoints to be used for the graph for Next Week
    // Also outputs the maximum for the graph
    $PredictionDayExit = array();
    $PredictionDayExit = PredictNextDay($parkingLotSelection, 0);
    $dataPointsPredictionDayExit = array();
    $dataPointsPredictionDayExit = $PredictionDayExit[0];
    $maxCountPredictionDayExit = $PredictionDayExit[1];

?>

<script>
    window.onload = function () {
        /******************************************************************
                               ENTERING DATA
        ******************************************************************/
        var chart1 = new CanvasJS.Chart("chartContainer1", 
        {
            animationEnabled: true,
            exportEnabled: true,
            //theme: "light1",
            backgroundColor: "#BBC7BA",
            title:{
            text: "Last Week"
            },
            axisX:{
            title: "Timeframe",
            suffix: " "
        },
            axisY:{
            title: "Count",
            suffix: " cars",
            minimum: 0,
            //max depends  on the max count found above
            maximum:  <?php echo json_encode($maxCountLastWeekEnter + 25)?>,
            interval: <?php echo json_encode(($maxCountLastWeekEnter + 25)/10, JSON_NUMERIC_CHECK);?>
            },
            data: [
        {
                markerColor: "#FF1493",
                type: "line",
                markerType: "square",
                markerSize: 10,
                //toolTipContent: "Count: {y} person<br>Weight: {x} kg",
                dataPoints: <?php echo json_encode($dataPointsLastWeekEnter, JSON_NUMERIC_CHECK);?>
            }]
        });
    chart1.render();
        
    var chart2 = new CanvasJS.Chart("chartContainer2", {
        animationEnabled: true,
        exportEnabled: true,
        backgroundColor: "#BBC7BA",
        title:{
        text: "Next Week of Predicted Data"
        },
        axisX:{
        title: "Timeframe",
        suffix: " "
        },
        axisY:{
        title: "Count",
        suffix: " cars",
        minimum: 0,
        //max depends  on the max count found above
        maximum: <?php echo json_encode($maxCountPredictionWeekEnter + 25)?>,
        interval: <?php echo json_encode($maxCountPredictionWeekEnter + 25)/10?>
        },
        data: [{
        markerColor: "green",
        type: "line",
        markerType: "square",

        markerSize: 10,
        //toolTipContent: "Count: {y} person<br>Weight: {x} kg",
        dataPoints: <?php echo json_encode($dataPointsPredictionWeekEnter, JSON_NUMERIC_CHECK); ?>
        }]
        });

        chart2.render();
      var chart3 = new CanvasJS.Chart("chartContainer3", {
        animationEnabled: true,
        exportEnabled: true,
        //theme: "light1",
        backgroundColor: "#BBC7BA",
        title:{
        text: "Last 24 Hours"
        },
        axisX:{
        title: "Timeframe",
        suffix: " "
        },
        axisY:{
        title: "Count",
        suffix: " cars",
        maximum: <?php echo json_encode($maxCountLastDayEnter + 10)?>,
        interval: <?php echo json_encode($maxCountLastDayEnter + 10)/10?>
        },
        data: [{
        markerColor: "purple",
        type: "line",
        markerType: "square",

        markerSize: 10,
        //toolTipContent: "Count: {y} person<br>Weight: {x} kg",
        dataPoints: <?php echo json_encode($dataPointsLastDayEnter, JSON_NUMERIC_CHECK); ?>
        }]
        });

        chart3.render();
       var chart4 = new CanvasJS.Chart("chartContainer4", {
        animationEnabled: true,
        exportEnabled: true,
        //theme: "light1",
        backgroundColor: "#BBC7BA",
        title:{
        text: "Next Day of Predicted Data"
        },
        axisX:{
        title: "Timeframe",
        suffix: " "
        },
        axisY:{
        title: "Count",
        suffix: " cars",
        minimum: 0,
        //max depends  on the max count found above
        maximum: <?php echo json_encode($maxCountPredictionDayEnter + 10)?>,
        interval: <?php echo json_encode($maxCountPredictionDayEnter + 10)/10?>
        },
        data: [{
        markerColor: "yellow",
        type: "line",
        markerType: "square",

        markerSize: 10,
        //toolTipContent: "Count: {y} person<br>Weight: {x} kg",
        dataPoints: <?php echo json_encode($dataPointsPredictionDayEnter, JSON_NUMERIC_CHECK); ?>
        }]
        });

        chart4.render();




        /******************************************************************
                               EXITIING DATA
        ******************************************************************/
        var chart5 = new CanvasJS.Chart("chartContainer5", 
        {
            animationEnabled: true,
            exportEnabled: true,
            //theme: "light1",
            backgroundColor: "#F9D5D3",
            title:{
            text: "Last Week"
            },
            axisX:{
            title: "Timeframe",
            suffix: " "
        },
            axisY:{
            title: "Count",
            suffix: " cars",
            minimum: 0,
            //max depends  on the max count found above
            maximum:  <?php echo json_encode($maxCountLastWeekExit + 25)?>,
            interval: <?php echo json_encode(($maxCountLastWeekExit + 25)/10, JSON_NUMERIC_CHECK);?>
            },
            data: [
        {
                markerColor: "#FF1493",
                type: "line",
                markerType: "square",
                markerSize: 10,
                //toolTipContent: "Count: {y} person<br>Weight: {x} kg",
                dataPoints: <?php echo json_encode($dataPointsLastWeekExit, JSON_NUMERIC_CHECK);?>
            }]
        });
    chart5.render();
        
    var chart6 = new CanvasJS.Chart("chartContainer6", {
        animationEnabled: true,
        exportEnabled: true,
        backgroundColor: "#F9D5D3",
        title:{
        text: "Next Week of Predicted Data"
        },
        axisX:{
        title: "Timeframe",
        suffix: " "
        },
        axisY:{
        title: "Count",
        suffix: " cars",
        minimum: 0,
        //max depends  on the max count found above
        maximum: <?php echo json_encode($maxCountPredictionWeekExit + 25)?>,
        interval: <?php echo json_encode($maxCountPredictionWeekExit + 25)/10?>
        },
        data: [{
        markerColor: "green",
        type: "line",
        markerType: "square",

        markerSize: 10,
        //toolTipContent: "Count: {y} person<br>Weight: {x} kg",
        dataPoints: <?php echo json_encode($dataPointsPredictionWeekExit, JSON_NUMERIC_CHECK); ?>
        }]
        });

        chart6.render();
      var chart7 = new CanvasJS.Chart("chartContainer7", {
        animationEnabled: true,
        exportEnabled: true,
        //theme: "light1",
        backgroundColor: "#F9D5D3",
        title:{
        text: "Last 24 Hours"
        },
        axisX:{
        title: "Timeframe",
        suffix: " "
        },
        axisY:{
        title: "Count",
        suffix: " cars",
        maximum: <?php echo json_encode($maxCountLastDayExit + 10)?>,
        interval: <?php echo json_encode($maxCountLastDayExit + 10)/10?>
        },
        data: [{
        markerColor: "purple",
        type: "line",
        markerType: "square",

        markerSize: 10,
        dataPoints: <?php echo json_encode($dataPointsLastDayExit, JSON_NUMERIC_CHECK); ?>
        }]
        });

        chart7.render();
       var chart8 = new CanvasJS.Chart("chartContainer8", {
        animationEnabled: true,
        exportEnabled: true,
        backgroundColor: "#F9D5D3",
        title:{
        text: "Next Day of Predicted Data"
        },
        axisX:{
        title: "Timeframe",
        suffix: " "
        },
        axisY:{
        title: "Count",
        suffix: " cars",
        minimum: 0,
        //max depends  on the max count found above
        maximum: <?php echo json_encode($maxCountPredictionDayExit + 10)?>,
        interval: <?php echo json_encode($maxCountPredictionDayExit + 10)/10?>
        },
        data: [{
        markerColor: "yellow",
        type: "line",
        markerType: "square",

        markerSize: 10,
        //toolTipContent: "Count: {y} person<br>Weight: {x} kg",
        dataPoints: <?php echo json_encode($dataPointsPredictionDayExit, JSON_NUMERIC_CHECK); ?>
        }]
        });

        chart8.render();
      }

</script>

<br> <h2>Entering Data</h2>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<div class = "chart" id="chartContainer1" style="width: 45%; height: 300px; display: inline-block;"></div> 
<div class = "chart" id="chartContainer2" style="width: 45%; height: 300px; display: inline-block;"></div>
<div class = "chart" id="chartContainer3" style="width: 45%; height: 300px; display: inline-block;"></div>
<div class = "chart" id="chartContainer4" style="width: 45%; height: 300px; display: inline-block;"></div><br/>

<br><br><h2>Exiting Data</h2>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<div class = "chart" id="chartContainer5" style="width: 45%; height: 300px; display: inline-block;"></div> 
<div class = "chart" id="chartContainer6" style="width: 45%; height: 300px; display: inline-block;"></div>
<div class = "chart" id="chartContainer7" style="width: 45%; height: 300px; display: inline-block;"></div>
<div class = "chart" id="chartContainer8" style="width: 45%; height: 300px; display: inline-block;"></div><br/>

