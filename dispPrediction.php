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
    date_defualt_timezone_set("America/Chicago");
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
    echo("<form action='dispPredictionChart.php'>");
        echo("<input list='ParkingLots' name='PL'>");
        echo("<datalist id='ParkingLots'>");
            foreach ($parkingLots as $lot){
                echo("<option value = '".$lot."'>");
            }
        echo("</datalist> <br>");


    echo("<input type='submit'>");
    echo("</form>");


?>

</div>
</body>
</html>

