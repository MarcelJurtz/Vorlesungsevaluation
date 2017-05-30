<!DOCTYPE html>
<html>
<head>
	<link href="stylesheet.css" rel="stylesheet" type="text/css" />
	<script src="Chart.bundle.min.js"></script>
	<script src="functions.js"></script>
</head>
<body>

<canvas id="myChart"></canvas>

<?php
	$data = array(1,3,5,4,2);
	$fields = array("a","b","c","d","e");
	$trueCol = "rgba(0,0,255,0.2)";
	$falseCol = "rgba(255,0,0,0.2)";
	$trueColBorder = "rgba(0,0,255,0.8)";
	$falseColBorder = "rgba(255,0,0,0.8)";
	$colors = array($trueCol,$falseCol,$falseCol,$trueCol,$falseCol);
	$borderColors = array($trueColBorder,$falseColBorder,$falseColBorder,$trueColBorder,$falseColBorder);
					
	echo '<script>DrawChart('. json_encode($fields) .','.json_encode($data).','.json_encode($colors).','.json_encode($borderColors).')</script>';
?>
</body>
</html>