<!--header.php-->
<!--
	Creates top Menu
-->
<html>
<head>
<title>People Sensor 9000</title>
<meta http-equiv="refresh" content="10" />

<style>

body
{
	background: linear-gradient(to bottom,#F9D5D3, #BBC7BA);
	font-family: Arial;
}

h2
{
	color: #807F89;
}

div
{
	margin-top: 5%;
}

ul 
{
    list-style-type: none;
    margin: 0;
    margin-left:-1%;
    padding: 0;
    overflow: hidden;
    background-color: floralwhite;
    position: fixed;
    top: 0;
    width: 103%;
}

li {
    float: left;
}

li a {
    display: block;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover:not(.active) {
    background-color: #BBC7BA;
}

.active {
    background-color: #BBC7BA;
}

</style>


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
