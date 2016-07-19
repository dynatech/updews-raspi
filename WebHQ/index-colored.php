<?php
header("refresh: 60;");
$fdir = "/home/pi/monitoringoutputs/";
$fname1 = "PublicAlert.txt";
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
		$handle = fopen($fdir . $fname1, "r");
		if ($handle) {
		    while (($line = fgets($handle)) !== false) {
		    	// $line = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),"",$line);
		    	// $line = str_replace("<br>L2","<br><h2>L2",$line);
		    	// $line = str_replace("$","</h2>",$line);
		    	$a2 = stripos($line,"A2");
		    	$a3 = stripos($line,"A3");

		    	if ($a3 !== false) {
		    		echo '<p class="bg-danger">' . $line . '</p>';
		    	} 
		    	elseif ($a2 !== false) {
		    		echo '<p class="bg-warning">' . $line . '</p>';
		    	}
		    	else {
		    		echo '<p class="bg-success">' . $line . '</p>';
		    	}
		    }

		    fclose($handle);
		} else {
		    // error opening the file.
		    echo "<p>Error: File cannot be found!</p>";
		} 
		?>

	</div>
</body>
</html>




