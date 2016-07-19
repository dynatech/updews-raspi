<?php
header("refresh: 60;");
$fdir = "/home/pi/monitoringoutputs/";
$fname1 = "textalert2_withTNLwithSmoothing.txt";
$myfile1 = fopen($fdir . $fname1, "r") or die("Unable to open file!");
$txt1 = fread($myfile1,filesize($fdir . $fname1));
$txt1 = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),"<br>",$txt1);
$txt1 = str_replace("<br>L2","<br><h2>L2",$txt1);
$txt1 = str_replace("$","</h2>",$txt1);
fclose($myfile1);

$fname2 = "textalert2.txt";
$myfile2 = fopen($fdir . $fname2, "r") or die("Unable to open file!");
$txt2 = fread($myfile2,filesize($fdir . $fname2));
$txt2 = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),"<br>",$txt2);
$txt2 = str_replace("<br>L2","<br><h2>L2",$txt2);
$txt2 = str_replace("$","</h2>",$txt2);
$txt2 = str_replace(",",", ",$txt2);
fclose($myfile1);

$fname3 = "rainfallalert.txt";
$myfile3 = fopen($fdir . $fname3, "r") or die("Unable to open file!");
$txt3 = fread($myfile3,filesize($fdir . $fname3));
$txt3 = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),"<br>",$txt3);
$txt3 = str_replace("<br>r1a","<br><h2>r1a",$txt3);
$txt3 = str_replace("$","</h2>",$txt3);
$txt3 = str_replace(",",", ",$txt3);
fclose($myfile3);


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

<h1>$fname2</h1>
<p>$txt2</p>

<h1>$fname3</h1>
<p>$txt3</p>


</body>
</html>

EOT;

// <h1>testalert_withTNLwithSmooting.txt</h1>
// <p>$txt2</p>
// <h1>rainfallalert.txt</h1>
// <p>$txt3</p>
?>

