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
function queryOther($connection)
{
	$sql = "SELECT * FROM Entries ORDER BY time DESC";
	$statement = $connection->query($sql);
	if($statement->num_rows < 0)
	{
		return -1;
	}
	$total = $statement->num_rows;
	$row = $statement->fetch_assoc();
	echo ("<b>" . $total . "</b> People have walked by your sensor so far, most recently at <b>" . $row['time'] . "</b><br>");
}
queryOther($connection);

?>