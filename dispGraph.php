
<!-- /****************************************************
** File: Proj2DispGraph
** Project: Project 2 
**
** This file contains the queries for the database.
** There are multiple functions that access the database
** and return information based on what the HTML form
** asks for. 
**
****************************************************/-->
<!--dispGraph.php-->
<!--
	This script gathers all the relevant data from mySQL server,
and create graphs to represent that data
-->
<?php
	
	//connect to the database
	$host = "database.cse.tamu.edu";
	$username = "emmaleepk";
	$password = "csce315AAE";
	$dbname = "emmaleepk";
	$connection = new mysqli($host, $username, $password, $dbname);
	//include the top menu links
	include("header.php");
	include_once("Proj2Queries.php");
?>
<div>
<?php
$hoursInDay = array();
$hoursInDay = CanvasOne();
var_dump($hoursInDay);
function queryGraph($connection)
{
	
	//Collect information for canvas 2
	$sql = "SELECT * FROM Entries WHERE time >= DATE_SUB(curdate(),INTERVAL 7 DAY) AND time < curdate()";
	$statement = $connection->query($sql);
	if($statement->num_rows < 0)
	{
		return -1;
	}
	$days = array(0,0,0,0,0,0,0);
	$dayNames = array("Sunday" => 0,"Monday" => 0,"Tuesday" => 0,"Wednesday" => 0,"Thursday" => 0,"Friday" => 0,"Saturday" => 0);
	while($row = $statement->fetch_assoc())
	{
		$time = $row['time'];
		$dayOfWeek = date('l', strtotime($time));
		$dayNames[$dayOfWeek]++;			
	}
	$i=0;
	foreach($dayNames as $key=>$value)
	{
		$days[$i] = $value;
		$i++;
	}



?>
<!--create canvas one-->
<canvas style = "border: 2px solid #000;" id="graphHour" width="280" height="140" ></canvas>
<script>
	var canvas = document.getElementById("graphHour");
	var paintbrush = canvas.getContext("2d");
	var hoursInDay = <?php echo json_encode($hoursInDay); ?>;
	<?php
	if(json_encode($hoursInDay) == FALSE)
	{
		return -1;
	}?>
	//create the labels
	
	paintbrush.fillText("People Per Hour Today",20,10);
	paintbrush.fillText("0",22,130);
	paintbrush.fillText("8",102,130);
	paintbrush.fillText("16",182,130);
	paintbrush.fillText("23",252,130);
	paintbrush.fillText("0",2,117);
	paintbrush.fillText("5",2,115-25+2);
	paintbrush.fillText("10",2,115-50+2);
	paintbrush.fillText("15",2,115-75+2);
	paintbrush.fillText("20",2,17);
	paintbrush.rect(20,20,240,100);
	paintbrush.stroke();
	var i = 0;
	
	//plot data points for all 24 hours
	for(i = 0; i<24; i++)
	{
		paintbrush.fillRect(i*10+22,115 - hoursInDay[i],5,5);
		if(i > 0)
		{
			paintbrush.moveTo((i-1)*10+22,115 - hoursInDay[i-1]+2);
			paintbrush.lineTo(i*10+22,115 - hoursInDay[i]+2);
			paintbrush.stroke();
		}
	}
</script>
<br>
<!-- create canvas two -->
<canvas style = "border: 2px solid #000;" id="graphWeek" width="280" height="140" ></canvas>
<script>

	canvas = document.getElementById("graphWeek");
	paintbrush = canvas.getContext("2d");
	var days = <?php echo json_encode($days); ?>;
	<?php
	if(json_encode($hours) == FALSE)
	{
		return -1;
	}?>
	//create labels 
	paintbrush.fillText("People Per Day Last Week",20,10);
	paintbrush.fillText("Sun",22,130);
	paintbrush.fillText("Tue",102,130);
	paintbrush.fillText("Thur",182,130);
	paintbrush.fillText("Sat",252,130);
	paintbrush.fillText("0",2,117);
	paintbrush.fillText("5",2,115-25+2);
	paintbrush.fillText("10",2,115-50+2);
	paintbrush.fillText("15",2,115-75+2);
	paintbrush.fillText("20",2,17);
	paintbrush.rect(20,20,240,100);
	paintbrush.stroke();
	i = 0;
	//plot data for all 7 days
	for(i = 0; i<7; i++)
	{
		paintbrush.fillRect((i*38)+22,115 - days[i],5,5);
		if(i > 0)
		{
			paintbrush.moveTo((i-1)*38+22,115 - (days[i-1])/2+2);
			paintbrush.lineTo(i*38+22,115 - days[i]/2+2);
			paintbrush.stroke();
		}
	}
	
</script>
<?php
}
queryGraph($connection);
?>
</div>
</body>
</html>