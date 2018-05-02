
<!-- /****************************************************
** File: Proj2Header
** Project: Project 2 
**
** This file contains the main navigation header that is
** displayed at the top of every page of the webpage. 
** This allows the user to access all the pages at any 
** point
**
****************************************************/-->

<html>
    <head>
        <title>People Sensor 9000</title>
        <!-- How to refresh the page consistently - every 10 seconds -->
        <meta http-equiv="refresh" content="60" />
        <!-- Connection to stylesheet to make the webpage more visually appealing  -->
        <link href = "./Proj2Style.css?<?php echo time();?>" type = "text/css" rel = "stylesheet">
    </head>
    
<body>
	<!-- List that links to other pages in the project -->
	<ul name = "topMenu">
		<li class = "menuItem"> <a href = "index.php"> Home </a></li>
		<li class = "menuItem"> <a href = "dispDaily.php"> Daily Values </a></li>
		<li class = "menuItem"> <a href = "dispGraph.php"> Graphing </a></li>
		<li class = "menuItem"> <a href = "dispGlobal.php"> Global Values </a></li>
		<li class = "menuItem"> <a href = "dispPrediction.php"> Prediction Model </a></li>	
		<li class = "menuItem"> <a href = "dispOther.php"> Other  </a></li>	
	</ul>
