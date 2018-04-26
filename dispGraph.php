<!--dispGraph.php-->
<!--
	This script gathers all the relevant data from mySQL server,
and create graphs to represent that data
-->
<?php
	
	//connect to the database
	//include the top menu links
	include("header.php");
	include_once("Proj2Queries.php");


	CanvasOne();
	CanvasTwo();
?>