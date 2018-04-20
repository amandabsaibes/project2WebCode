<html>
<body>
<?php
	$host = "database.cse.tamu.edu";
	$username = "emmaleepk";
	$password = "csce315AAE";
	$dbname = "emmaleepk";
	$connection = new mysqli($host, $username, $password, $dbname);
	include("header.php");
	$parkingLots = array();
	$notParkingLots = array(2,16,17,28,29,31,39,46,52,53,56,57,105,106,116,121);
	$letterParkingLots = array(10,30,33,36,40,72,95,99,100,122);

	for($i=1; $i<123; $i++)
	{
		if(in_array($i,$notParkingLots) == false)
		{
			array_push($parkingLots, ''.$i.'');
		}
		if(in_array($i, $letterParkingLots))
		{
			array_push($parkingLots, ''.$i.'a');
			if($i != 30){array_push($parkingLots, ''.$i.'b');}
			if($i == 30 || $i == 36 || $i == 40 || $i == 100 || $i == 122)
			{
				array_push($parkingLots, ''.$i.'c');
				if($i != 122)
				{
					array_push($parkingLots, ''.$i.'d');
					if($i != 40)
					{
						array_push($parkingLots, ''.$i.'e');
						if($i == 100)
						{
							array_push($parkingLots, ''.$i.'f', ''.$i.'g', ''.$i.'j', ''.$i.'m');
						}
					}
				}

			}
		}
	}
	echo('Please select which TAMU Parking Lot you are interested in <br>');
	echo("<form action='dispPrediction.php'>");
		echo("<input list='ParkingLots' name='PL'>");
		echo("<datalist id='ParkingLots'>");
			foreach ($parkingLots as $lot){
				echo("<option value = '".$lot."'>");
			}
		echo("</datalist>");
		echo("<input type='submit'>");
	echo("</form>");



?>
</body>
</html>

