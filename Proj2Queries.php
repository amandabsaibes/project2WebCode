<!-- /****************************************************
** File: Proj2Queries.php
** Project: Project 2 
**
** This file contains the queries for the database.
** There are multiple functions that access the database
** and return information based on what the HTML form
** asks for. 
**
****************************************************/-->
<?php
	//connect to database
	$host = "database.cse.tamu.edu";
	$username = "emmaleepk";
	$password = "csce315AAE";
	$dbname = "emmaleepk";
	$connection = new mysqli($host, $username, $password, $dbname);

	//----------------------------------------------------------------
    // Name: TotalInDatabase
    // PreCondition: Database is created and has values
    // PostCondition: Returns total number of rows in database 
    //----------------------------------------------------------------
	function TotalInDatabase()
	{
		//Total Number of Entries in the database
		global $connection;
		$sql = "SELECT * FROM Entries";
		$statement = $connection->query($sql);
		if($statement->num_rows < 0) {return -1;}
		$totalInDatabase = $statement->num_rows;
		return $totalInDatabase;

	}

	//----------------------------------------------------------------
    // Name: TotalInMonth
    // PreCondition: Database is created and has values
    // PostCondition: Returns total number of rows for the month given 
    //----------------------------------------------------------------
	function TotalInMonth()
	{
		global $connection;
		//Total value of entries in the database for the current month
		$currentTime = time();
		$currentMonth = date("Y-m",$currentTime);
		$currentMonth = $currentMonth . "-01 00:00:00";

		$sql = "SELECT * FROM Entries WHERE time >= '".$currentMonth."'";
		$statement = $connection->query($sql);
		if($statement->num_rows < 0) {return -1;}
		//the number of rows calculates the number of people who have walked by this month
		$totalPerMonth = $statement->num_rows;
		return $totalPerMonth;
	}

	//----------------------------------------------------------------
    // Name: TotalInYear
    // PreCondition: Database is created and has values
    // PostCondition: Returns total number of rows for the year given 
    //----------------------------------------------------------------
	function TotalInYear()
	{
		global $connection;
		//Total value of entries in the database for the current year
		$year = date("Y",$currentTime);
		$currentYear = $year . "01-01 00:000:00";
		$sql = "SELECT * FROM Entries WHERE time >= '".$currentYear."'";
		$statement = $connection->query($sql);
		if($statement->num_rows < 0) {return -1;}

		//the number of rows calculates the number of people who have walked by this year
		$totalPerYear = $statement->num_rows;
		return $totalPerYear;
	}

	//----------------------------------------------------------------
    // Name: TotalInHour
    // PreCondition: Database is created and has values
    // PostCondition: Returns total number of rows for the hour given 
    //----------------------------------------------------------------
	function TotalInHour()
	{
		//TOTAL people who walked by for the Hour, day, and week
		global $connection;
		$sql = "SELECT * FROM Entries WHERE time > DATE_FORMAT(NOW(),'%Y-%m-%d %H:00:00')";
		$statement = $connection->query($sql);
		$total = $statement->num_rows;
		if($statement->num_rows < 0) {return -1;}
		$TotalInHour = "This Hour, <b>" . $total . "</b> cars have driven by your sensor<br>";
		return $TotalInHour;
	}

	//----------------------------------------------------------------
    // Name: TotalInDay
    // PreCondition: Database is created and has values
    // PostCondition: Returns total number of rows for the day given 
    //----------------------------------------------------------------
	function TotalInDay()
	{
		global $connection;
		$sql = "SELECT * FROM Entries WHERE time >= CURDATE() ORDER BY time";
		$statement = $connection->query($sql);
		$total = $statement->num_rows;
		if($statement->num_rows < 0)
		{
			return -1;
		}
		$TotalInDay = "Today, <b>" . $total . "</b> cars have driven by your sensor<br>";
		return $TotalInDay;
	}

	//----------------------------------------------------------------
    // Name: TotalInWeek
    // PreCondition: Database is created and has values
    // PostCondition: Returns total number of rows for the week given 
    //----------------------------------------------------------------
	function TotalInWeek()
	{
		global $connection;
		$sql = "SELECT * FROM Entries WHERE time > DATE_SUB(NOW(), INTERVAL 7 DAY)";
		$statement = $connection->query($sql);
		$total = $statement->num_rows;
		if($statement->num_rows < 0)
		{
			return -1;
		}
		$TotalInWeek = "This Week, <b>" . $total . "</b> People have walked by your sensor<br><br>";
		return $TotalInWeek;
	}

	//----------------------------------------------------------------
    // Name: TotalNumberOfYears
    // PreCondition: Database is created and has values
    // PostCondition: Returns total number of distinct years 
    //----------------------------------------------------------------
	function TotalNumberOfYears() 
	{
		global $connection;
		//calculates the unique year in the database -- to be used for averages 
		//averages will only consider months that an entry has been made
		$sql = "SELECT DATE_FORMAT(`time`, '%Y') Time FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%Y')";
		$statement = $connection->query($sql);
		$totalNumberOfYears = $statement->num_rows;
		return $totalNumberOfYears;
	}

	//----------------------------------------------------------------
    // Name: TotalNumberOfMonth
    // PreCondition: Database is created and has values
    // PostCondition: Returns total number of distinct months
    //----------------------------------------------------------------
	function TotalNumberOfMonths()
	{
		global $connection;
		//calculates the unique months in the database -- to be used for averages 
		//averages will only consider months that an entry has been made
		$sql = "SELECT DATE_FORMAT(`time`, '%Y-%m') Time FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%Y-%m')";
		$statement = $connection->query($sql);
		$totalNumberOfMonths = $statement->num_rows;
		return $totalNumberOfMonths;
	}

	//----------------------------------------------------------------
    // Name: TotalNumberOfDays
    // PreCondition: Database is created and has values
    // PostCondition: Returns total number of distinct days 
    //----------------------------------------------------------------
	function TotalNumberOfDays()
	{
		global $connection;
		//calculates the unique days in the database -- to be used for averages 
		//averages will only consider months that an entry has been made
		$sql = "SELECT DATE_FORMAT(`time`, '%Y-%m-%d') Time FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%Y-%m-%d')";
		$statement = $connection->query($sql);
		$totalNumberOfDays = $statement->num_rows;
		return $totalNumberOfDays;
	}

	//----------------------------------------------------------------
    // Name: MaxAndMinHour
    // PreCondition: Database is created and has values
    // PostCondition: Returns the most and least popular hour for the 
    // current hour
    //----------------------------------------------------------------
	function MaxAndMinHour ()
	{
		global $connection;
		//find the most and least busy hours
		$sql = "SELECT * FROM Entries WHERE time >= CURDATE() ORDER BY time";
		$statement = $connection->query($sql);
		$hoursInDay = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
		if($statement->num_rows < 0) {return -1;}
		while($row = $statement->fetch_assoc())
		{
			$currentTime = $row['time'];
			$currentHour = date('H',strtotime($currentTime));
			$hoursInDay[$currentHour]++;		
		}
		$minHour = array_search(min($hoursInDay),$hoursInDay);
		$maxHour = array_search(max($hoursInDay),$hoursInDay);
		if($minHour > 12){ $minTime = ($minHour - 12).'PM'; }
		else 
		{
			if($minHour == 0) {$minTime = '12AM';}
			else{$minHour = $minTime . 'AM';}
		}
		if($maxHour > 12){ $maxTime = ($maxHour - 12).'PM'; }
		else 
		{
			if($maxHour == 0) {$maxTime = '12AM';}
			else{$maxHour = $maxTime . 'AM';}
		}

		$minAndMax = "Today, the fewest people (".$hoursInDay[$minHour].") walked at <b>" . $minTime . "</b><br>" .
					 "Today, the most people (".$hoursInDay[$maxHour].") walked by at <b>" . $maxTime . "</b><br><br>";

		return $minAndMax;
	}

	//----------------------------------------------------------------
    // Name: MaxAndMinDay
    // PreCondition: Database is created and has values
    // PostCondition: Returns the most and least popular day for the 
    // current week
    //----------------------------------------------------------------
	function MaxAndMinDay()
	{
		global $connection;
		//find the most and least busy days for last week
		$sql = "SELECT * FROM Entries WHERE time >= DATE_SUB(curdate(),INTERVAL 7 DAY) AND time < curdate()";
		$statement = $connection->query($sql);
		if($statement->num_rows < 0) {return -1;}
		$daysInWeek = array(0,0,0,0,0,0,0);
		$dayNames = array("Sunday" => 0,"Monday" => 0,"Tuesday" => 0,"Wednesday" => 0,"Thursday" => 0,"Friday" => 0,"Saturday" => 0);
		while($row = $statement->fetch_assoc())
		{
			$time = $row['time'];
			$dayOfWeek = date('l', strtotime($time));
			$dayNames[$dayOfWeek]++;			
		}
		$minDay = array_search(min($dayNames),$dayNames);
		$maxDay = array_search(max($dayNames),$dayNames);
		if($minDay < 0 || $minDay > count($daysInWeek)) {return -1;}
		if($maxDay < 0 || $maxDay > count($daysInWeek)) {return -1;}
		
		$minAndMax = "Last week, the fewest people walked by on <b>" . $minDay . "</b> (".$dayNames[$minDay].")<br>" . 
					 "Last week, the most people walked by on <b>" . $maxDay . "</b> (".$dayNames[$maxDay].")<br><br>";

		return $minAndMax;
	}

	//----------------------------------------------------------------
    // Name: TotalSinceBeginning
    // PreCondition: Database is created and has values
    // PostCondition: Returns total number of rows in database
    //----------------------------------------------------------------
	function TotalSinceBeginning()
	{
		global $connection;
		$sql = "SELECT * FROM Entries ORDER BY time DESC";
		$statement = $connection->query($sql);
		if($statement->num_rows < 0) {return -1;}
		$total = $statement->num_rows;
		$row = $statement->fetch_assoc();
		$totalSince = "<b>" . $total . "</b> people have walked by your sensor so far, most recently at <b>" . $row['time'] . "</b><br>";
		return $totalSince;
	}
	

	//----------------------------------------------------------------
    // Name: TotalSinceBeginning
    // PreCondition: Database is created and has values
    // PostCondition: Returns total number of rows in database
    //----------------------------------------------------------------
	function CanvasOne() 
	{
		global $connection;
		$sql = "SELECT * FROM Entries WHERE time >= CURDATE() ORDER BY time";
		$statement = $connection->query($sql);
		if($statement->num_rows < 0) {return -1;}
		//initial array of hours in the day
		$hours = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
		while($row = $statement->fetch_assoc())
		{
			$time = $row['time'];
			$hour = date('H',strtotime($time));
			$hours[$hour]++;			
		}
?>
	<canvas style = "border: 2px solid #000;" id="graphHour" width="280" height="140" ></canvas>
	<script>
		var canvas = document.getElementById("graphHour");
		var paintbrush = canvas.getContext("2d");
		var hours = <?php echo json_encode($hours); ?>;
		<?php
			if(json_encode($hours) == FALSE) {return -1;}
		?>
		
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
		
		//plot data pointsfor all 24 hours
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
<?php
return;
	}
?>
<?php 
	function CanvasTwo() 
	{
		global $connection;
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
	return;
	}

	//----------------------------------------------------------------
    // Name: GetMonthCount
    // PreCondition: Database is created and has values
    // PostCondition: Returns array (size of number of months) and at
    // index corresponding to month number is the total count of that month
    //----------------------------------------------------------------
	function GetMonthCount()
	{
		global $connection;

		// Set up the array of months (initially empty)
		$monthOfYearCount = array("01" => 0, "02" => 0, "03" => 0, "04" => 0, "05" => 0, "06" => 0, "07" => 0, "08" => 0, "09" => 0, "10" => 0, "11" => 0, "12" => 0);

		// Grabs each month and its corresponding count
		$sql = "SELECT DATE_FORMAT(`time`, '%m') Time, COUNT(*) FROM `Entries` GROUP BY DATE_FORMAT(`time`,'%m')";
		$result = $connection->query($sql);

		// Loops through table and stores count in array at correct month
		while($row = $result->fetch_assoc())
		{
			$monthOfYearCount[$row['Time']] = $row['COUNT(*)'];
		}

		// Returns an array of the values
		return $monthOfYearCount;
		
	}


	//----------------------------------------------------------------
    // Name: GetActiveDaysInMonth
    // PreCondition: Database is created and has values
    // PostCondition: Returns array (size of number of months) that 
    // has the count of the number of days that the sensor was used 
    // at corresponding month
    //----------------------------------------------------------------

	function GetActiveDaysInMonth()
	{
		global $connection;
		// Sets up array with the indices corresponding to correct month
		$monthActiveDayCount = array("01" => 0, "02" => 0, "03" => 0, "04" => 0, "05" => 0, "06" => 0, "07" => 0, "08" => 0, "09" => 0, "10" => 0, "11" => 0, "12" => 0);

		// Returns table with one column that says a month
		// with a row corresponding to each active day
		$sql = "SELECT DATE_FORMAT(`time`, '%m') Time FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%Y-%m-%d')";
		$result = $connection->query($sql);

		// Loop through table and update value of active day number
		while ($row = $result->fetch_assoc())
		{
			$monthActiveDayCount[$row['Time']] += 1;
		}
		return $monthActiveDayCount;
	}	

	//----------------------------------------------------------------
    // Name: MonthAverage
    // PreCondition: Database is created and has values
    // PostCondition: Returns array (size of number of months) and at
    // index corresponding to month number is the total count of that month
    // divided by the total number of active days that month
    //----------------------------------------------------------------
	function MonthAverage()
	{
		// Obtain an array of all the counts per month
		$countOfMonths = array();
		$countOfMonths = GetMonthCount();

		// Calculate the number of active days per month
		$activeDaysInMonth = array();
		$activeDaysInMonth = GetActiveDaysInMonth();

		//After calclating the number of active days per month, we can calculate the average per month for the entire year
		$averagePerMonth = array("01" => 0, "02" => 0, "03" => 0, "04" => 0, "05" => 0, "06" => 0, "07" => 0, "08" => 0, "09" => 0, "10" => 0, "11" => 0, "12" => 0);
		for($i = 1; $i < 13; $i++)
		{
			// Ensures that it matches with the indices of the array
			if($i < 10){$count = "0".$i;}
			else {$count = "".$i."";}

			//prevents division by 0 error :)
			if($activeDaysInMonth[$count] != 0) 
			{
				// Creates average!
				$averagePerMonth[$count] = $countOfMonths[$count]/$activeDaysInMonth[$count];
			}
		}
		return $averagePerMonth;
	}


	//----------------------------------------------------------------
    // Name: DayOfWeekToNumber
    // PreCondition: Database is created and has values and date is passed
    // PostCondition: Returns a number corresponding to the day of the week
    //----------------------------------------------------------------
	function DayOfWeekToNumber($date)
	{
		// Converts timestamp to day of week (sunday, Monday, ...)
		$dayOfWeek = date('l', strtotime($date));

		// Associative array to communicate which day means which number
		$dayOfWeekToNumber = array("Sunday" => 0, "Monday" => 1, "Tuesday" => 2, "Wednesday" => 3, "Thursday" => 4, "Friday" => 5, "Saturday" => 6);

		// Evaluates the number of the given day
		$dayOfWeekNumber = $dayOfWeekToNumber[$dayOfWeek];
		return $dayOfWeekNumber;
	}


	//----------------------------------------------------------------
    // Name: DayAverage
    // PreCondition: Database is created and has values
    // PostCondition: Returns array (size of number of days of a week - 7) 
    // and at index corresponding to day of week number, average for that 
    // day is calculated
    //----------------------------------------------------------------
	function DayAverage()
	{
		global $connection;
		// This query returns the count for every day of the week
		// Sunday = 0, Monday = 1, ... , Saturday = 6
		$countForDayOfWeek = array();
		$sql = "SELECT DATE_FORMAT(`time`, '%w') Time, COUNT(*) FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%w')";
		$result = $connection->query($sql);
		
		// Pushes back the count into an array
		// Resulting array is size 7 (each index corresponds to a day of the week)
		while($row = $result->fetch_assoc())
		{
			array_push($countForDayOfWeek, $row['COUNT(*)']);
		}

		// Now, need to find the NUMBER of time the day of the week appeared
		// i.e. how many Sundays or Mondays, etc.
		$uniqueDayOfWeek = array(0, 0, 0, 0, 0, 0, 0);
		// Query returns every unique date
		$sql = "SELECT DATE_FORMAT(`time`, '%Y-%m-%d') Time FROM `Entries` GROUP BY DATE_FORMAT(`time`, '%Y-%m-%d')";
		$result = $connection->query($sql);

		// Loop through the result and update the array at the correct index (found with a defined function)
		while($row = $result->fetch_assoc())
		{
			$dayOfWeekNumber = DayOfWeekToNumber($row['Time']);
			$uniqueDayOfWeek[$dayOfWeekNumber] += 1;
		}

		// Now, need to average the values
		// ex) (Count of entries for all Sundays) / (Unique number of Sundays) = Average for Sundays 
		$averagePerDay = array();
		for ($i = 0; $i < count($uniqueDayOfWeek); $i++)
		{
			// Index 0 = Sunday, ..., 6 = Saturday for both arrays
			$average = $countForDayOfWeek[$i] / $uniqueDayOfWeek[$i];
			array_push($averagePerDay, $average);	
		}	
		return $averagePerDay;
	}

	//----------------------------------------------------------------
    // Name: PredictionByDayAndMonth
    // PreCondition: Database is created and has values. 
    // Date time stamp passed in and month (only two number - ex. (04)) 
    // PostCondition: returns an average of the average of the passed in month 
    // and an average of the day of the week of the passed in day 
    // to return a predicted count for that day or returns no answer
    // if either averages are 0
    //----------------------------------------------------------------
	function PredictionByDayAndMonth($day, $month)
	{
		$averagePerDay = array();
		// Obtains the averages of the days of the week
		$averagePerDay = DayAverage();
		$dayToNumber = DayOfWeekToNumber($day);		
		// Retrieves the average for the selected day
		$selectedDayAvg = $averagePerDay[$dayToNumber];

		$averagePerMonth = array();
		// Obtains the average of the months
		$averagePerMonth = MonthAverage();
		// Retrieves the average for the specific month
		$selectedMonthAvg = $averagePerMonth[$month];

		// Checks to ensure that valid averages were obtained
		if (($selectedDayAvg <= 0) || ($selectedMonthAvg <= 0))
		{
			$prediction = "Not enough data!";
			return $prediction;
		}
		else
		{
			// Averages the values to develop a prediction for the specified day
			$prediction = ($selectedDayAvg + $selectedMonthAvg) / 2;
		}
		return $prediction;
	}

?>