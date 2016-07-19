<?php
header("refresh: 60;");
$fdir = "/home/pi/monitoringoutputs/";
$fname1 = "query_latest_report_output.txt";
$myfile1 = fopen($fdir . $fname1, "r") or die("Unable to open file!");
$txt1 = fread($myfile1,filesize($fdir . $fname1));
$txt1 = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),"<br>",$txt1);
$txt1 = str_replace(array("\t"),"&nbsp",$txt1);
fclose($myfile1);

print <<< EOT
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Monitoring Outputs</title>
</head>
<body>
<h1>$fname1</h1>
<p>$txt1</p>
</body>
</html>

EOT;

// <h1>testalert_withTNLwithSmooting.txt</h1>
// <p>$txt2</p>
// <h1>rainfallalert.txt</h1>
// <p>$txt3</p>
?>

