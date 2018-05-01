<!-- /****************************************************
** File: Proj2DispGraph.php
** Project: Project 2 
**
** This file gathers all relevant data from the database 
** and creates charts to provide visual representations of
** the data.  
** 
****************************************************/-->

<?php
	
	// Navigation header to access all pages
	include("header.php");
	// File that contains all the queries that are used
	include_once("Proj2Queries.php");

	// Calls the function to draw information for the first graph
	CanvasOne();
	// Calls the function to draw information for the second graph
	CanvasTwo();
?>