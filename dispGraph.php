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

function queryGraph($connection)
{
	//Collect the info for canvas one
	$sql = "SELECT * FROM Entries WHERE time >= CURDATE() ORDER BY time";
	$statement = $connection->query($sql);
	if($statement->num_rows < 0)
	{
		return -1;
	}
	$hours = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);//initial array of hours in the day
	while($row = $statement->fetch_assoc())
	{
		$time = $row['time'];
		$hour = date('H',strtotime($time));
		$hours[$hour]++;			
	}
	
	//Collect info for canvas two
	$sql = "SELECT * FROM Entries WHERE time >= DATE_SUB(curdate(),INTERVAL DAYOFWEEK(curdate()) + 6 DAY)
		AND time < DATE_SUB(curdate(), INTERVAL DAYOFWEEK(curdate()) - 1 DAY)";
	$statement = $connection->query($sql);
	if($statement->num_rows < 0)
	{
		return -1;
	}
	$days = array(0,0,0,0,0,0,0);//array of days per week
	$dayNames = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
	while($row = $statement->fetch_assoc())
	{
		$time = strtotime($row['time']);
		$timeNow = unixtojd(time());
		$timeNow = (1 + $timeNow) % 7;
		$timeNow = floor((time() - $timeNow * 60 * 60 *24));
		$timeDif = floor(($timeNow - $time)/(60*60 * 24))+1;
		$days[7-$timeDif]++;			
	}


?>
<!--create canvas one-->
<canvas style = "border: 2px solid #000;" id="graphHour" width="280" height="140" ></canvas>
<script>
	var canvas = document.getElementById("graphHour");
	var paintbrush = canvas.getContext("2d");
	var hours = <?php echo json_encode($hours); ?>;
	<?php
	if(json_encode($hours) == FALSE)
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
	paintbrush.fillText("25",2,115-25+2);
	paintbrush.fillText("50",2,115-50+2);
	paintbrush.fillText("75",2,115-75+2);
	paintbrush.fillText("100",2,17);
	paintbrush.rect(20,20,240,100);
	paintbrush.stroke();
	var i = 0;
	
	//plot data points for all 24 hours
	for(i = 0; i<24; i++)
	{
		paintbrush.fillRect(i*10+22,115 - hours[i],5,5);
		if(i > 0)
		{
			paintbrush.moveTo((i-1)*10+22,115 - hours[i-1]+2);
			paintbrush.lineTo(i*10+22,115 - hours[i]+2);
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
	paintbrush.fillText("125",2,115-25+2);
	paintbrush.fillText("250",2,115-50+2);
	paintbrush.fillText("375",2,115-75+2);
	paintbrush.fillText("500",2,17);
	paintbrush.rect(20,20,240,100);
	paintbrush.stroke();
	i = 0;
	//plot data for all 7 days
	for(i = 0; i<7; i++)
	{
		paintbrush.fillRect((i*38)+22,115 - days[i],5,5);
		if(i > 0)
		{
			paintbrush.moveTo((i-1)*38+22,115 - (days[i-1])/5+2);
			paintbrush.lineTo(i*38+22,115 - days[i]/5+2);
			paintbrush.stroke();
		}
	}
	
</script>
<?php
}
queryGraph($connection);
?>