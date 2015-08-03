
<div class="body collapse in" id="reportResult">
	<table class="table table-bordered responsive">
		<tbody id="">
			<?php 
			switch ($title) {
				case 'Distance':
					$index = 0;
					$data = array();
					foreach($devices as $device){
						$data = array();
						$data[] = array("Date", "Distance");
						$title = '';
						foreach($device as $d){
							$data[] = array($d['date'], floatval($d['d_dist']));

							$title = $d['regNumber']?$d['regNumber'] : $d['reg_number'];
						}
						?>
			<tr>
				<td><div id="chart_div_<?php echo $index;?>"
						style="width: 100%; height: 300px;"></div>
				</td>
			</tr>
			<script type="text/javascript">
									var d = google.visualization.arrayToDataTable($.parseJSON('<?php echo json_encode($data)?>'));
									
								    var options = {
								      title: '<?php echo $title;?>',
								      fontSize:11,
								      hAxis: {title: 'Date', titleTextStyle: {color: 'red'}},
								      legend:{textStyle:{fontSize:'12'}},
								      tooltip:{textStyle:{fontSize:'12'}}
								    };
		
								    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_<?php echo $index;?>'));
								    chart.draw(d, options);
								</script>
			<?php
			$index++;
			unset($data);
					}
					break;

case 'Halt':
	$index = 0;
	$data = array();
	foreach($devices as $device){
		$data = array();
		$data[] = array("Date", "Interval");
		$title = '';
		if(!empty($device)){
		foreach($device as $d){
			$data[] = array($d['record_date'], floatval($d['duration']));
			$title = $d['regNumber']?$d['regNumber'] : $d['reg_number'];
		}
		?>
			<tr>
				<td><div id="chart_div_<?php echo $index;?>"
						style="width: 100%; height: 300px;"></div>
				</td>
			</tr>
			<script type="text/javascript">
									var d = google.visualization.arrayToDataTable($.parseJSON('<?php echo json_encode($data)?>'));
									
									 var options = {
										      title: '<?php echo $title;?>',
										      fontSize:11,
										      hAxis: {title: 'Date', titleTextStyle: {color: 'red'}},
										      legend:{textStyle:{fontSize:'12'}},
										      tooltip:{textStyle:{fontSize:'12'}}
										    };
		
								    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_<?php echo $index;?>'));
								    chart.draw(d, options);
								</script>
			<?php
		}
			$index++;
			unset($data);
	}

	break;
case 'OverSpeed':
	$index = 0;
	$data = array();
	foreach($devices as $device){
		$data = array();
		$data[] = array("Date", "Over Speed");
		$title = '';
		foreach($device as $d){
			$data[] = array($d['record_date'], floatval($d['speed']));
			$title = $d['regNumber']?$d['regNumber'] : $d['reg_number'];
		}
		?>
			<tr>
				<td><div id="chart_div_<?php echo $index;?>"
						style="width: 100%; height: 300px;"></div>
				</td>
			</tr>
			<script type="text/javascript">
										var d = google.visualization.arrayToDataTable($.parseJSON('<?php echo json_encode($data)?>'));
										
										 var options = {
											      title: '<?php echo $title;?>',
											      fontSize:11,
											      hAxis: {title: 'Date', titleTextStyle: {color: 'red'}},
											      legend:{textStyle:{fontSize:'12'}},
											      tooltip:{textStyle:{fontSize:'12'}}
											    };
			
									    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_<?php echo $index;?>'));
									    chart.draw(d, options);
									</script>
			<?php
			$index++;
			unset($data);
	}
	break;
case 'Fuel Consumption':
	$index = 0;
	$data = array();
	foreach($devices as $device){
		$data = array();
		$data[] = array("Date", "Fuel Consumption");
		$title = '';
		foreach($device as $d){
			$data[] = array($d['date'], floatval($d['fuel']));
			$title = $d['regNumber']?$d['regNumber'] : $d['reg_number'];
		}
		?>
			<tr>
				<td><div id="chart_div_<?php echo $index;?>"
						style="width: 100%; height: 300px;"></div>
				</td>
			</tr>
			<script type="text/javascript">
											var d = google.visualization.arrayToDataTable($.parseJSON('<?php echo json_encode($data)?>'));
											 var options = {
												      title: '<?php echo $title;?>',
												      fontSize:11,
												      hAxis: {title: 'Date', titleTextStyle: {color: 'red'}},
												      legend:{textStyle:{fontSize:'12'}},
												      tooltip:{textStyle:{fontSize:'12'}}
												    };
				
										    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_<?php echo $index;?>'));
										    chart.draw(d, options);
										</script>
			<?php
			$index++;
			unset($data);
	}
	break;
case 'Speed':
	$index = 0;
	$data = array();
	foreach($devices as $device){
		$data = array();
		$data[] = array("Date", "Average Speed", "Max Speed");
		$title = '';
		if(!empty($device)){
		foreach($device as $d){
			$data[] = array($d['date'], floatval($d['avg_speed']), floatval($d['max_speed']));
			$title = $d['regNumber']?$d['regNumber'] : $d['reg_number'];
		}
		?>
			<tr>
				<td><div id="chart_div_<?php echo $index;?>"
						style="width: 100%; height: 300px;"></div>
				</td>
			</tr>
			<script type="text/javascript">
											var d = google.visualization.arrayToDataTable($.parseJSON('<?php echo json_encode($data)?>'));
											 var options = {
												      title: '<?php echo $title;?>',
												      fontSize:11,
												      hAxis: {title: 'Date', titleTextStyle: {color: 'red'}},
												      legend:{textStyle:{fontSize:'12'}},
												      tooltip:{textStyle:{fontSize:'12'}}
												    };
				
										    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_<?php echo $index;?>'));
										    chart.draw(d, options);
										</script>
			<?php
		}
			$index++;
			unset($data);
	}
	break;
default:
	;
	break;


			}
			?>

		</tbody>
	</table>
</div>

<style>
<!--
#reportResult table tr {
	font-size: 0.85em;
}

#reportResult table thead tr {
	background-color: #555555;
	font-size: 0.85em;
	font-style: bold;
	color: white;
}
-->
</style>
