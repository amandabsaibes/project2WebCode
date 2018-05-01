<!-- /****************************************************
** File: Proj2DispOther.php
** Project: Project 2 
**
** This file prints the total number of information in the
** database since the beginning. It also displays the most
** recent timestamp
** 
****************************************************/-->

<?php
	// Navigation header to access all pages
	include("header.php");
	// File that contains all the queries that are used
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