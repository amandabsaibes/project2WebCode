<!--dispOther.php-->
<!--
	This script only prints the total number of people who have walked by,
along with the most recent timestamp
-->
<?php
	$host = "database.cse.tamu.edu";
	$username = "emmaleepk";
	$password = "csce315AAE";
	$dbname = "emmaleepk";
	$connection = new mysqli($host, $username, $password, $dbname);
	include("header.php");
	include_once("Proj2Queries.php");
?>
<div>
<?php
	echo("<h2>Total Number Since Beginning</h2>");
	$totalSinceBeginning = TotalSinceBeginning();
	echo($totalSinceBeginning);
?>
</div>
</body>
</html>