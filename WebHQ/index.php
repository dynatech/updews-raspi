<?php
header("refresh: 60;");
$fdir = "/home/pi/monitoringoutputs/";
$fname1 = "PublicAlert.json";
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Monitoring Outputs</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>		
<body>
	<div class="container">
		<h1><?php echo $fname1; ?></h1>

		<?php
			$myfile1 = fopen($fdir . $fname1, "r") or die("Unable to open file!");
			$txt1 = fread($myfile1,filesize($fdir . $fname1));
			fclose($myfile1);

			$jsonTxt = json_decode($txt1);

			$numSites = count($jsonTxt);

			$level3 = [];
			$level2 = [];
			$level1 = [];
			$noAlert = [];
			for ($i=0; $i < $numSites ; $i++) { 
				$ts = $jsonTxt[$i]->timestamp;
				$site = $jsonTxt[$i]->site;
				$alert = $jsonTxt[$i]->alert;
				$source = $jsonTxt[$i]->source;
				$ial = $jsonTxt[$i]->internal_alert;
				$validity = $jsonTxt[$i]->validity;
				$sensor = $jsonTxt[$i]->sensor_alert;
				$rain = $jsonTxt[$i]->rain_alert;

				$line = "$ts $site $alert $source $ial $validity $sensor $rain";

				if ( ($alert == "A3") || ($ial == "A3") ) {
					array_push($level3, $line);
				}
				elseif ( ($alert == "A2") || ($ial == "A2") ) {
					array_push($level2, $line);
				}
				elseif ( ($alert == "A1") || ($ial == "A1") ) {
					array_push($level1, $line);
				}
				else {
					array_push($noAlert, $line);
				}
			}

			$countA3 = count($level3);
			if ($countA3 > 0) {
				echo "<h3>Alert Level 3 ($countA3)</h3>";
			}
			foreach ($level3 as $alert) {
				echo '<p class="bg-danger">' . $alert . '</p>';
			}

			$countA2 = count($level2);
			if ($countA2 > 0) {
				echo "<h3>Alert Level 2 ($countA2)</h3>";
			}
			foreach ($level2 as $alert) {
				echo '<p class="bg-warning">' . $alert . '</p>';
			}

			$countA1 = count($level1);
			if ($countA1 > 0) {
				echo "<h3>Alert Level 1 ($countA1)</h3>";
			}
			foreach ($level1 as $alert) {
				echo '<p class="bg-info">' . $alert . '</p>';
			}

			$countNoAlert = count($noAlert);
			if ($countNoAlert > 0) {
				echo "<h3>NO Alert ($countNoAlert)</h3>";
			}			
			foreach ($noAlert as $alert) {
				echo '<p class="bg-success">' . $alert . '</p>';
			}
		?>

	</div>
</body>
</html>




