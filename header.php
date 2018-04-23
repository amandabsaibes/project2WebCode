
<!-- /****************************************************
** File: Proj2Header
** Project: Project 2 
**
** This file contains the queries for the database.
** There are multiple functions that access the database
** and return information based on what the HTML form
** asks for. 
**
****************************************************/-->
<!--header.php-->
<!--
	Creates top Menu
-->
<html>
    <head>
        <title>People Sensor 9000</title>
        <meta http-equiv="refresh" content="10" />
        <link href = "./Proj2Style.css?<?php echo time();?>" type = "text/css" rel = "stylesheet">
    </head>
<body>

	<ul name = "topMenu">
		<li class = "menuItem"> <a href = "index.php"> Home </a></li>
		<li class = "menuItem"> <a href = "dispDaily.php"> Daily Values </a></li>
		<li class = "menuItem"> <a href = "dispGraph.php"> Graphing </a></li>
		<li class = "menuItem"> <a href = "dispGlobal.php"> Global Values </a></li>
		<li class = "menuItem"> <a href = "dispPrediction.php"> Prediction Model </a></li>	
		<li class = "menuItem"> <a href = "dispOther.php"> Other  </a></li>	
	</ul>
