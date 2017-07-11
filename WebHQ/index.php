<?php
// header("refresh: 60;");
$fdir = "/home/pi/monitoringoutputs/";
// $fdir = "../monitoringoutputs/";
$fAlerts = "PublicAlert.json";
// $fAlerts = "PublicAlert_eq.json";
$fIssues = "MonitoringIssues.txt";

error_reporting(E_ERROR | E_PARSE);

$myfile1 = fopen($fdir . $fAlerts, "r") or die("Unable to open file!");
$publicAlertJSON = fread($myfile1,filesize($fdir . $fAlerts));
fclose($myfile1);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Monitoring Outputs</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/handlebars.js"></script>
</head>		
<body>

	<!-- Start of Alert Level 3 Template -->
	<script id="alert-3" type="text/x-handlebars-template">
		{{#each alerts}}
        <!-- Start of Accordion -->
        <div class="panel panel-danger">
            <div class="panel-heading" data-toggle="collapse" data-parent="#content-alert-3" href="#a3-{{site}}">
                <h4 class="panel-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <small>{{timestamp}}</small> | <b><i>{{#uppercase}} {{site}} {{/uppercase}}</i></b> | {{internal_alert}}
                            &nbsp <span class="caret"></span> 
                        </div>
                        <div class="col-xs-6 text-right">
                        	<span class="badge">valid until: {{validity}}</span>
                        </div>
                    </div>
                </h4>   
            </div>     
            <div id="a3-{{site}}" class="panel-collapse collapse">
                {{> partial}}
            </div>
        </div>
        <!-- End of Accordion -->		
        {{/each}}
	</script>
	<!-- End of Alert Level 3 Template -->

	<!-- Start of Alert Level 2 Template -->
	<script id="alert-2" type="text/x-handlebars-template">
		{{#each alerts}}
        <!-- Start of Accordion -->
        <div class="panel panel-warning">
            <div class="panel-heading" data-toggle="collapse" data-parent="#content-alert-2" href="#a2-{{site}}">
                <h4 class="panel-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <small>{{timestamp}}</small> | <b><i>{{#uppercase}} {{site}} {{/uppercase}}</i></b> | {{internal_alert}}
                            &nbsp <span class="caret"></span> 
                        </div>
                        <div class="col-xs-6 text-right">
                        	<span class="badge">valid until: {{validity}}</span>
                        </div>
                    </div>
                </h4>   
            </div>     
            <div id="a2-{{site}}" class="panel-collapse collapse">
                {{> partial}}
            </div>
        </div>
        <!-- End of Accordion -->		
        {{/each}}
	</script>
	<!-- End of Alert Level 2 Template -->

	<!-- Start of Alert Level 1 Template -->
	<script id="alert-1" type="text/x-handlebars-template">
		{{#each alerts}}
        <!-- Start of Accordion -->
        <div class="panel panel-info">
            <div class="panel-heading" data-toggle="collapse" data-parent="#content-alert-1" href="#a1-{{site}}">
                <h4 class="panel-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <small>{{timestamp}}</small> | <b><i>{{#uppercase}} {{site}} {{/uppercase}}</i></b> | {{internal_alert}}
                            &nbsp <span class="caret"></span>
                        </div>
                        <div class="col-xs-6 text-right">
                        	<span class="badge">valid until: {{validity}}</span>
                        </div>
                    </div>
                </h4>   
            </div>     
            <div id="a1-{{site}}" class="panel-collapse collapse">
                {{> partial}}
            </div>
        </div>
        <!-- End of Accordion -->		
        {{/each}}
	</script>
	<!-- End of Alert Level 1 Template -->

	<!-- Start of Alert Level 0 Template -->
	<script id="alert-0" type="text/x-handlebars-template">
		{{#each alerts}}
        <!-- Start of Accordion -->
        <div class="panel panel-success">
            <div class="panel-heading" data-toggle="collapse" data-parent="#content-alert-0" href="#a0-{{site}}">
                <h4 class="panel-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <small>{{timestamp}}</small> | <b><i>{{#uppercase}} {{site}} {{/uppercase}}</i></b> | {{internal_alert}}
                            &nbsp <span class="caret"></span>
                        </div>
                    </div>
                </h4>   
            </div>     
            <div id="a0-{{site}}" class="panel-collapse collapse">
                {{> partial}}
            </div>
        </div>
        <!-- End of Accordion -->		
        {{/each}}
	</script>
	<!-- End of Alert Level 0 Template -->

	<!-- Start of With Alert Partial Template -->
	<script id="alert-partial" type="text/x-handlebars-template">
                <div class="panel-body text-dark">
                	<div class="row">
	                	<div class="col-sm-4">
	                		{{#if retriggerTS}}
	                		<label><u>Triggers and Retriggers</u></label>
	                		<table class="table table-hover table-condensed">
	                			<thead>
	                				<tr>
	                					<th>Op Trigger</th>
	                					<th>Timestamp</th>
	                				</tr>
	                			</thead>
	                			<tbody>
	                				{{#each retriggerTS}}
	                				<tr>
	                					<td>{{retrigger}}</td>
	                					<td>{{timestamp}}</td>
	                				</tr>
	                				{{/each}}
	                			</tbody>
	                		</table>
	                		{{/if}}
	                	</div>
		                <div class="col-sm-4">
		                	<label><u>Alert Status</u></label>
		                    <table class="table table-hover table-condensed">
		                    	<thead>
		                    		<tr>
		                    			<th>Op Trigger</th>
		                    			<th>Status</th>
		                    		</tr>
		                    	</thead>
		                    	<tbody>
		                    		{{#if ground_alert}}
		                    		<tr>
		                    			<td>Surficial Ground Measurement</td>
		                    			<td>{{ground_alert}}</td>
		                    		</tr>
		                    		{{/if}}
		                    		{{#if rain_alert}}
		                    		<tr>
		                    			<td>Rainfall</td>
		                    			<td>{{rain_alert}}</td>
		                    		</tr>
		                    		{{/if}}
		                    		{{#if eq_alert}}
		                    		<tr>
		                    			<td>Earthquake</td>
		                    			<td>{{eq_alert}}</td>
		                    		</tr>
		                    		{{/if}}
		                    		{{#if od_alert}}
		                    		<tr>
		                    			<td>On Demand</td>
		                    			<td>{{od_alert}}</td>
		                    		</tr>
		                    		{{/if}}
		                    	</tbody>
		                    </table>
		                </div>
	                	<div class="col-sm-4">
		                	{{#if sensor_alert}}
		                    <label><u>Underground Sensors</u></label>
		                    <table class="table table-hover table-condensed">
		                    	<thead>
		                    		<tr>
		                    			<th>Sensor Name</th>
		                    			<th>Status</th>
		                    		</tr>
		                    	</thead>
		                    	<tbody>
	                                {{#each sensor_alert}}
	                                <tr>
	                                	<td>{{sensor}}</td>
	                                	<td>{{alert}}</td>
	                                </tr>
	                                {{/each}}
		                    	</tbody>
		                    </table>
		                    {{else}}
		                    <label class="text-danger">No Underground Sensors...</label>
		                    {{/if}}
		                </div>
		            </div>
		        {{#if tech_info}}    
		            <div class="row">
		            	<div class="col-sm-12">
		            		<h3><u>Technical Info</u></h3>
		            	</div>
		            	<div class="col-sm-8">
		            		{{#if tech_info.sensor_tech}}
		            			<label>Sensor: </label>
		            			<p>{{tech_info.sensor_tech}}</p>
		            		{{/if}}
		            		{{#if tech_info.ground_tech}}
		            			<label>Surficial Ground Measurement: </label>
		            			<p>{{tech_info.ground_tech}}</p>
		            		{{/if}}
		            		{{#if tech_info.rain_tech}}
		            			<label>Rainfall: </label>
		            			<p>{{tech_info.rain_tech}}</p>
		            		{{/if}}
		            		{{#if tech_info.eq_tech}}
		            			<label>Earthquake: </label>
			                    <table class="table table-hover table-condensed">
			                    	<tbody>
		                                <tr>
		                                	<td>Magnitude</td>
		                                	<td>{{tech_info.eq_tech.magnitude}}</td>
		                                </tr>
		                                <tr>
			                    			<td>Longitude</td>
		                                	<td>{{tech_info.eq_tech.longitude}}</td>
		                                </tr>
		                                <tr>
			                    			<td>Latitude</td>
		                                	<td>{{tech_info.eq_tech.latitude}}</td>
		                                </tr>
		                                <tr>
			                    			<td>Info</td>
		                                	<td>{{tech_info.eq_tech.info}}</td>
		                                </tr>
			                    	</tbody>
			                    </table>
		            		{{/if}}
		            		{{#if tech_info.od_tech}}
		            			<label>On Demand: </label>
		            			<p>{{tech_info.od_tech}}</p>
		            		{{/if}}
		            	</div>
		            </div>
		        {{/if}}
                </div>
	</script>
	<!-- End of With Alert Partial Template -->

	<!-- Start of No Alert Partial Template -->
	<script id="no-alert-partial" type="text/x-handlebars-template">
                <div class="panel-body text-dark">
                	<div class="row">
		                <div class="col-sm-6">
		                	<label><u>Alert Status</u></label>
		                    <table class="table table-hover table-condensed">
		                    	<thead>
		                    		<tr>
		                    			<th>Op Trigger</th>
		                    			<th>Status</th>
		                    		</tr>
		                    	</thead>
		                    	<tbody>
		                    		{{#if ground_alert}}
		                    		<tr>
		                    			<td>Surficial Ground Measurement</td>
		                    			<td>{{ground_alert}}</td>
		                    		</tr>
		                    		{{/if}}
		                    		{{#if rain_alert}}
		                    		<tr>
		                    			<td>Rainfall</td>
		                    			<td>{{rain_alert}}</td>
		                    		</tr>
		                    		{{/if}}
		                    		{{#if eq_alert}}
		                    		<tr>
		                    			<td>Earthquake</td>
		                    			<td>{{eq_alert}}</td>
		                    		</tr>
		                    		{{/if}}
		                    		{{#if od_alert}}
		                    		<tr>
		                    			<td>On Demand</td>
		                    			<td>{{od_alert}}</td>
		                    		</tr>
		                    		{{/if}}
		                    	</tbody>
		                    </table>
		                </div>
	                	<div class="col-sm-6">
		                	{{#if sensor_alert}}
		                    <label><u>Underground Sensors</u></label>
		                    <table class="table table-hover table-condensed">
		                    	<thead>
		                    		<tr>
		                    			<th>Sensor Name</th>
		                    			<th>Status</th>
		                    		</tr>
		                    	</thead>
		                    	<tbody>
	                                {{#each sensor_alert}}
	                                <tr>
	                                	<td>{{sensor}}</td>
	                                	<td>{{alert}}</td>
	                                </tr>
	                                {{/each}}
		                    	</tbody>
		                    </table>
		                    {{else}}
		                    <label class="text-danger">No Underground Sensors...</label>
		                    {{/if}}
		                </div>
		            </div>
                </div>
	</script>
	<!-- End of No Alert Partial Template -->

	<!-- Start of Invalidated Alert Template -->
	<script id="invalidated-alert" type="text/x-handlebars-template">
{{#if invalids}}
	{{#each invalids}}
		{{#if_eq alert 'A3'}}
		<p class="bg-danger">
		{{/if_eq}}
		{{#if_eq alert 'A2'}}
		<p class="bg-warning">
		{{/if_eq}}
		{{#if_eq alert 'A1'}}
		<p class="bg-info">
		{{/if_eq}}
			{{timestamp}} | <b><i>{{#uppercase}} {{site}} {{/uppercase}}</i></b> | Invalid <u>{{alert}}</u> from <u>{{source}}</u> data<Br/>
			IOMP: {{iomp}} <Br/>
			Remarks: {{remarks}}
		</p>
	{{/each}}
{{else}}
		<h3 class="text-success">No Invalidated triggers...</h3>
{{/if}}
	</script>
	<!-- End of Invalidated Alert Template -->

	<div class="container-fluid">
		<div class="row">
			<div id="sites-alert-status" class="col-sm-7">
				<div class="row col-sm-12">
					<h2>Alerts</h2>
					<div id="div-alert-3" hidden>
						<Br/><h4>Alert Level 3 (<i class="alert-count"></i>)</h4>
						<div id="content-alert-3"></div>
					</div>
					<div id="div-alert-2" hidden>
						<Br/><h4>Alert Level 2 (<i class="alert-count"></i>)</h4>
						<div id="content-alert-2"></div>
					</div>
					<div id="div-alert-1" hidden>
						<Br/><h4>Alert Level 1 (<i class="alert-count"></i>)</h4>
						<div id="content-alert-1"></div>
					</div>
					<div id="div-alert-0" hidden>
						<Br/><h4>No Alert (<i class="alert-count"></i>)</h4>
						<div id="content-alert-0"></div>
					</div>
				</div>

				<div id="test-sites-alert" class="row col-sm-12">
				</div>
			</div>
			<div class="col-sm-5">
				<div id="invalidated" class="row col-sm-12">
					<h2>Invalidated Alerts</h2><Br/>
					<div id="invalid-triggers"></div>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	function add_alert(context, alert_level) {
		var targetScript = null;
		var targetHtmlAccumulator = null;

		// The name of our helper is provided as the first parameter - in this case 'uppercase'
		Handlebars.registerHelper('uppercase', function(options) {
			return options.fn(this).toUpperCase();
		});

		switch(alert_level) {
			case 3:
				targetScript = "#alert-3";
				partialScript = "#alert-partial"
				targetHtmlAccumulator = "#content-alert-3";
				break;
			case 2:
				targetScript = "#alert-2";
				partialScript = "#alert-partial"
				targetHtmlAccumulator = "#content-alert-2";
				break;	
			case 1:
				targetScript = "#alert-1";
				partialScript = "#alert-partial"
				targetHtmlAccumulator = "#content-alert-1";
				break;	
			case 0:
				targetScript = "#alert-0";
				partialScript = "#no-alert-partial"
				targetHtmlAccumulator = "#content-alert-0";
				break;	
			default:
				break;
		}

		// Grab the template script
		var theTemplateScript = $(targetScript).html();

		// Compile the template
		var theTemplate = Handlebars.compile(theTemplateScript);

		// Include Partial Script
		Handlebars.registerPartial("partial", $(partialScript).html());

		// Pass our data to the template
		var theCompiledHtml = theTemplate(context);

		// Add the compiled html to the page
		$(targetHtmlAccumulator).html(theCompiledHtml);
	}

	function add_alert_set (data_set, alert_level) {
		var temp = {};
		var cur_alert = "A" + alert_level;

		temp.alerts = $.grep( data_set.alerts, function( n, i ) {
			return n.alert===cur_alert;
		});

		var numAlerts = temp.alerts.length;
		var targetDiv = "#div-alert-" + alert_level;

		if (numAlerts > 0) {
			$(targetDiv).show();
			$(targetDiv).find(".alert-count").text(numAlerts)
			add_alert(temp, alert_level);
		} 
		else {
			$(targetDiv).hide();
		}
	}

	function add_invalids(context) {
		var targetScript = null;
		var targetHtmlAccumulator = null;

		// The name of our helper is provided as the first parameter - in this case 'uppercase'
		Handlebars.registerHelper('uppercase', function(options) {
			return options.fn(this).toUpperCase();
		});

		// Helper for comparing values
		Handlebars.registerHelper('if_eq', function(a, b, opts) {
		    if (a == b) {
		        return opts.fn(this);
		    } 
		    else {
		        return opts.inverse(this);
		    }
		});

		targetScript = "#invalidated-alert";
		// partialScript = "#alert-partial"
		targetHtmlAccumulator = "#invalid-triggers";

		// Grab the template script
		var theTemplateScript = $(targetScript).html();

		// Compile the template
		var theTemplate = Handlebars.compile(theTemplateScript);

		// Pass our data to the template
		var theCompiledHtml = theTemplate(context);

		// Add the compiled html to the page
		$(targetHtmlAccumulator).html(theCompiledHtml);
	}

	var text = <?php echo "$publicAlertJSON"; ?>;
	context_all = text[0];

	// add_alert(test_A3, 3);
	// add_alert(test_A2, 2);
	// add_alert(test_A1, 1);
	// add_alert(test_A0, 0);

	//Generate Alerts display based on context
	for (var alert_level = 3; alert_level >= 0; alert_level--) {
		add_alert_set(context_all, alert_level);
	}

	//Generate Invalidated Triggers display
	add_invalids(context_all);


</script>
</html>




