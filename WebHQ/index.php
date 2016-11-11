<?php
header("refresh: 60;");
$fdir = "/home/pi/monitoringoutputs/";
$fAlerts = "PublicAlert.json";
$fIssues = "MonitoringIssues.txt";
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
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-7">
				<h2><i><?php echo $fAlerts; ?></i></h2>
				<?php
					$myfile1 = fopen($fdir . $fAlerts, "r") or die("Unable to open file!");
					$txt1 = fread($myfile1,filesize($fdir . $fAlerts));
					fclose($myfile1);

					$jsonTxt = json_decode($txt1);
					
					//Get Alert Level of All Sites
					$alerts = $jsonTxt[0]->alerts;

					$level3 = [];
					$level2 = [];
					$level1 = [];
					$noAlert = [];

					//Parsing of Public Alerts
					foreach ($alerts as $single_alert) {
						$ts = $single_alert->timestamp;
						$site = $single_alert->site;
						$alert = $single_alert->alert;
						$source = $single_alert->source;
						$ial = $single_alert->internal_alert;
						$validity = $single_alert->validity;
						$sensor = $single_alert->sensor_alert;
						$rain = $single_alert->rain_alert;
						$retrigger = " (Retrigger: " . $single_alert->retriggerTS . ")";

						$line = "$ts $site $alert $source $ial $validity $sensor $rain";


						if ( ($alert == "A3") || ($ial == "A3") ) {
							array_push($level3, $line . $retrigger);
						}
						elseif ( ($alert == "A2") || ($ial == "A2") ) {
							array_push($level2, $line . $retrigger);
						}
						elseif ( ($alert == "A1") || ($ial == "A1") ) {
							array_push($level1, $line . $retrigger);
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
			<div class="col-sm-5">
				<row>
					<h2><i>Invalidated Alerts</i></h2>
					<?php
						//Get Invalidations
						$invalids = $jsonTxt[0]->invalids;

						$InvalidLevel3 = [];
						$InvalidLevel2 = [];
						$InvalidLevel1 = [];
						$InvalidOthers = [];

						//Parsing of Invalidated Alerts
						foreach ($invalids as $invalid) {
							$ts = $invalid->timestamp;
							$site = $invalid->site;
							$alert = $invalid->alert;
							$iomp = $invalid->iomp;
							$remarks = $invalid->remarks;

							$line = "$ts $site <Br/>";
							$remarks = "IOMP: $iomp <Br/> Remarks: $remarks";


							if ( ($alert == "A3") || ($ial == "A3") ) {
								array_push($InvalidLevel3, $line . $remarks);
							}
							elseif ( ($alert == "A2") || ($ial == "A2") ) {
								array_push($InvalidLevel2, $line . $remarks);
							}
							elseif ( ($alert == "A1") || ($ial == "A1") ) {
								array_push($InvalidLevel1, $line . $remarks);
							}
							else {
								array_push($InvalidOthers, $line . $remarks);
							}
						}					

						$countInvA3 = count($InvalidLevel3);
						if ($countInvA3 > 0) {
							echo "<h3>Invalid Alert Level 3 ($countInvA3)</h3>";
						}
						foreach ($InvalidLevel3 as $alert) {
							echo '<p class="bg-danger">' . $alert . '</p>';
						}

						$countInvA2 = count($InvalidLevel2);
						if ($countInvA2 > 0) {
							echo "<h3>Invalid Alert Level 2 ($countInvA2)</h3>";
						}
						foreach ($InvalidLevel2 as $alert) {
							echo '<p class="bg-warning">' . $alert . '</p>';
						}

						$countInvA1 = count($InvalidLevel1);
						if ($countInvA1 > 0) {
							echo "<h3>Invalid Alert Level 1 ($countInvA1)</h3>";
						}
						foreach ($InvalidLevel1 as $alert) {
							echo '<p class="bg-info">' . $alert . '</p>';
						}
					?>
				</row>
				<row>
					<h2><i><?php echo $fIssues; ?></i></h2>
					<?php
						$issuesFile = fopen($fdir . $fIssues, "r") or die("Unable to open file!");
						$txtIssues = fread($issuesFile,filesize($fdir . $fIssues));
						fclose($issuesFile);

						echo "<p>". nl2br($txtIssues) ."</p>";
					?>
				</row>
			</div>
		</div>

		



	</div>
</body>
</html>




