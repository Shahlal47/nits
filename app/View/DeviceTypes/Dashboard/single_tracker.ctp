<?php //pr($deviceInfo);?>

<div
	class="content" style="overflow: hidden; margin: 0;">
	<!-- content-header -->
	<div class="content-header" style="height: 32px; padding: 5px 20px">
		<ul class="content-header-action pull-right" style="height: 30px;">
		<?php if($role=="groupd"){?>
			<li><select id="inputSelectGroup" data-form="select2"
				style="width: 200px" data-placeholder="Please Select Tracker">
					<option value=""></option>
					<optgroup label="Personal Tracker">
					<?php foreach($deviceInfo['DeviceProfiles'] as &$p){
						if($p['DeviceType']['name']=="PT"){
							?>

						<option>
						<?php echo $p['ClientDevice']['deviceid'];?>
						</option>
						<?php }}?>
					</optgroup>
					<optgroup label="Vahicle Tracker">
					<?php foreach($deviceInfo['DeviceProfiles'] as &$p){
						if($p['DeviceType']['name']=="VT"){
							?>

						<option>
						<?php echo $p['ClientDevice']['deviceid'];?>
						</option>
						<?php }}?>
					</optgroup>
			</select>
			</li>

			<li><a id="btn-live-view" class="btn" href="#" onclick=""
				data-placement="bottom" rel="tooltip"
				data-original-title="Load Tracker"><i class="icofont-download-alt"></i>
			</a></li>

			<li><a class="btn" href="#" data-placement="bottom" rel="tooltip"
				data-original-title="Show Geofences"><i class="icofont-road"></i> </a>
			</li>
			<?php }?>
			<li><a class="btn" href="#"
				onclick="VTS_LIVE_TRACKING.focusMarker();return false;"
				data-placement="bottom" rel="tooltip"
				data-original-title="Highlight Last Location"><i
					class="icon-screenshot"></i> </a></li>
		</ul>
		<div class="pull-left" style="margin-top: 0px"
			id="tracker-header-info">
			<?php
			//pr($deviceInfo);
			$vt = "human";
			$deviceid = $deviceInfo['ClientDevice']['deviceid'];
			$hname = "";
			$clr = "ash";
			if(isset($deviceInfo['DeviceStatus'])){
				if($deviceInfo['DeviceStatus']['ignitionStatus']==0
				&& $deviceInfo['DeviceStatus']['vehicleSpeed']==0)
				{$clr = "red";}
				else if($deviceInfo['DeviceStatus']['ignitionStatus']==0
				&& $deviceInfo['DeviceStatus']['vehicleSpeed']>0)
				{$clr = "org";}
				else if($deviceInfo['DeviceStatus']['ignitionStatus']==1
				&& $deviceInfo['DeviceStatus']['vehicleSpeed']==0)
				{$clr = "blu";}
				else if($deviceInfo['DeviceStatus']['ignitionStatus']==1
				&& $deviceInfo['DeviceStatus']['vehicleSpeed']>0)
				{$clr = "grn";}
			}
			if($deviceInfo['DeviceType']['name']=="PT"){
				$hname = $deviceInfo['ClientDevice']['name'];
			}else{
				if($deviceInfo['ClientDevice']['vehicle_type_id']){
					$vt = $deviceInfo['VehicleType']['name'];
				}
				$hname = $deviceInfo['ClientDevice']['name'];
			}
			if(isset($deviceInfo['VehicleType'] )&& !empty($deviceInfo['VehicleType']))
			$ttype = $deviceInfo['VehicleType']['name'];
			else
			$ttype = "human";

			echo $this->Html->image('tracker/64/'.$ttype.'-'.$clr.'.png', array(
											'alt' => 'tracker',
											'class'=>"contact-item-object v-icon",
											'style'=>"width: 32px; height: 32px;"));
			?>
			<div class="btn-group" style="white-space: normal">
				<!--notification-->
				<a href="#" data-placement="bottom" rel="tooltip"
					data-original-title="notifications" data-toggle="dropdown"
					class="btn btn-success btn-small" id="tracker-notifications-count">1</a>
				<table
					class="table table-hover table-striped dropdown-menu dropdown-notification"
					id="tracker-notifications"
					style="padding: 10px; width: 450px; min-width: 450px; font-size: 12px; line-height: 10px;">
					<thead>
						<tr style="padding: 0px; font-size: 12px">
							<th colspan="3">Live-Update: <?php 
							//echo date_default_timezone_get();
							//echo date('Y-m-d H:i:s', $this->Time->convert(time(), 'Asia/Dhaka'));

							?>
							</th>
						</tr>
						<tr style="padding: 0px; font-size: 10px">
							<th style="padding: 0px; width: 25%; font-size: 10px">Date-Time</th>
							<th style="padding: 0px; width: 15%; font-size: 10px">Ignition-Status</th>
							<th style="padding: 0px; width: 60%; font-size: 10px">Location</th>
						</tr>
					</thead>
					<tbody id="tracker-notifications-title">

					</tbody>
				</table>
				<!--notification-->

			</div>

			<div class="btn-group">
				<!--notification-->
				<a href="#" data-placement="bottom" rel="tooltip"
					data-original-title="Tracker Information" data-toggle="dropdown"
					class="btn btn-inverse btn-small"><?php echo $hname?> </a>

				<table
					class="table table-hover dropdown-menu dropdown-notification2"
					style="padding: 10px; min-width: 450px;">
					<thead>
						<tr>
							<th colspan="2">Tracker Information:</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><strong>Device Id:</strong></td>
							<td><?php echo $deviceInfo['ClientDevice']['deviceid'];?></td>
						</tr>
						<tr>
							<td><strong>Device Type:</strong></td>
							<td><?php echo $deviceInfo['DeviceType']['name'];?></td>
						</tr>
						<tr>
							<td><strong>Device Model:</strong></td>
							<td><?php echo $deviceInfo['DeviceInfo']['name'];?></td>
						</tr>
						<tr>
							<td><strong>Imei:</strong>
							</td>
							<td><?php echo $deviceInfo['ClientDevice']['imei'];?></td>
						</tr>
						<tr>
							<td><strong>Device Mobile:</strong>
							</td>
							<td><?php echo $deviceInfo['ClientDevice']['mob_no'];?></td>
						</tr>
						<?php if($deviceInfo['DeviceType']['name']=="PT"){?>
						<tr>
							<td><strong>Person Name:</strong>
							</td>
							<td><?php echo $deviceInfo['ClientDevice']['person_name'];?></td>
						</tr>
						<?php }else{?>
						<tr>
							<td><strong>Registration Number:</strong>
							</td>
							<td><?php echo $deviceInfo['ClientDevice']['name'];?></td>
						</tr>
						<tr>
							<td><strong>Speed Limit:</strong>
							</td>
							<td><?php echo $deviceInfo['ClientDevice']['speed_limit'];?></td>
						</tr>
						<?php }?>
						<tr>
							<td><strong>Expiry Date:</strong>
							</td>
							<td><?php echo $deviceInfo['ClientDevice']['expiry_date'];?></td>
						</tr>

					</tbody>
				</table>
				<!--notification-->

			</div>
		</div>
		<div id="tracker-status-info" class="pull-left">
			<div class="alert alert-info"
				style="margin-bottom: 0; color: #000 !important; background-color: #fff">
				<i class="icofont-map-marker"></i> Location: <strong><span
					id="trakcer-location-info"> </span></strong>
			</div>

		</div>
	</div>
	<!-- /content-header -->

	<!-- content-body -->
	<div class="content-body" style="padding: 0;">
		<!-- form -->
		<div class="row-fluid">
			<div class="span12">
				<div id="single-tracker-map" style="width: 100%; height: 560px;"></div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var map;
	var VTS_LIVE_Obometer;
	var VTS_LIVE_Gauge_Speed;
	var VTS_LIVE_Gauge_Fule;
	function setInitInfo(tdif, add){		
		var tdif = ReturnTimeDiff(tdif);
		var t = " For last "+tdif + " <br/>" + add;
		$("#trakcer-location-info").html(t);
	}

	
	
	
	var VTS_LIVE_TRACKING={
			device_init_data:<?php echo json_encode($deviceInfo);?>,
			device_data:<?php echo json_encode($deviceInfo);?>,
			map: null,
			mapName: "single-tracker-map",
			trackerType: "<?php echo $vt?>",
			prevLatLong:null,
			poly7:new Array(),
			lastEventNumber:<?php echo $deviceInfo['DeviceStatus']['recordEventNumber']?>,
			prevMarker:"",
			focusMarker:function(){
				this.setMapCenter(this.prevLatLong[0],this.prevLatLong[1]);
				var marker = $("#single-tracker-map").gmap3({get:{name:"marker",tag:this.lastEventNumber}});
				if(marker)					
					google.maps.event.trigger(marker,'click');
			},
			focusMarkerById:function(id){		
				//console.debug(id);		
				var marker = $("#single-tracker-map").gmap3({get:{name:"marker",tag:id.toString()}});
				if(marker)					
					google.maps.event.trigger(marker,'click');
			},
			updateTrackerInfo:function(){
				var device_data= this.device_data;
				var v = device_data.DeviceStatus;
				
				var deviceInfo = getDeviceInfoById(v.deviceid);
				
				var color = getMarkerColor(v.vehicleSpeed, v.ignitionStatus);
				
				var lblCnt = "";
				var lbl = "human";
				console.debug(device_data);
				if (deviceInfo.DeviceType.name == "PT") {
					lblCnt = deviceInfo.ClientDevice.person_name;
				} else {
					lblCnt = deviceInfo.ClientDevice.registration_number;
					lbl = "car";
				}
				var data = getInfoBubbleData(v);
				var icon = "/vts/img/tracker/marker-" + lbl + "-"+color+".png";
				var dt = {
					latLng : [ v.vehicleLat, v.vehicleLng ],
					data : data,
					id : v.recordEventNumber,
					 options:{
		            		optimized: false,
			            	icon: "/vts/img/tracker/live-"+lbl+"-pin.gif",
			              	draggable: false
			              	}
										
					};
					
				this.prevMarker = icon;

				this.addMarker(dt);
				
				if(this.prevLatLong)
					this.drawLineArwLine(dt);
				this.prevLatLong = [device_data.DeviceStatus.vehicleLat,device_data.DeviceStatus.vehicleLng];

				var ticon = getVehicleIcon(this.trackerType,
						device_data.DeviceStatus.vehicleSpeed,device_data.DeviceStatus.ignitionStatus);

				$("#tracker-header-info img[alt=tracker]").attr("src","/vts/img/tracker/64/"+ticon);
				
				// update the view tracker-odometer  knob-speed
				var vl = zeroFill( device_data.DeviceStatus.vehicleOdometer, 10 );
				VTS_LIVE_Obometer.goToNumber(vl);
				
				VTS_LIVE_Gauge_Fule.setValue(device_data.DeviceStatus.vehicleFuel);
				VTS_LIVE_Gauge_Speed.setValue(device_data.DeviceStatus.vehicleSpeed);
				
				if(device_data.DeviceStatus.ignitionStatus=="0"){
					$("#tracker-ignition").html('<span class="badge badge-important">Off</span>');
				}else{
					$("#tracker-ignition").html('<span class="badge badge-success">On</span>');
				}
				// refresh the msg box
				this.refreshMsgBox(device_data.DeviceStatus.nearaddress);
				// add record to list
				this.addToTrackerHistoryList(ticon, device_data);

				this.lastEventNumber = device_data.DeviceStatus.recordEventNumber;

				//
				var mst = ""; 
				if(device_data.DeviceStatus.ignitionStatus!="0"){
					mst = getMovingStatus(device_data.DeviceStatus.vehicleSpeed,device_data.DeviceStatus.ignitionStatus);				
				}
				$("#tracker-moving-status").html(mst);
			},
			addToTrackerHistoryList:function(ticon, device_data){
				//var msg = '<li><a href="#" style="white-space:normal" onclick="VTS_LIVE_TRACKING.focusMarkerById('+device_data.DeviceStatus.recordEventNumber+');return false;">'+
				var msg = '<tr style="cursor: pointer; padding: 0px; font-size:10px" onclick="VTS_LIVE_TRACKING.focusMarkerById('+device_data.DeviceStatus.recordEventNumber+');return false;">'
						  + '<td>'+device_data.DeviceStatus.serverDateTime
						  + '</td>'
						  + '<td>'+getMovingStatus(device_data.DeviceStatus.vehicleSpeed,device_data.DeviceStatus.ignitionStatus)
						  + '</td>'
						  + '<td>'+device_data.DeviceStatus.nearaddress
						  + '</td>'
						  + '</tr>';									
				
				$("#tracker-notifications-title").after(msg);
				var cnt = $("#tracker-notifications-title").length-1;
				$("#tracker-notifications-count").html(cnt);	
			},
			refreshMsgBox:function(data){
				var msg = '<i class="icofont-map-marker"></i> <strong>Location:</strong>'
							+ '<span id="trakcer-location-info">'+data+'</span>';
				$("#tracker-status-info .alert").html(msg);
				$("#tracker-status-info .alert").effect("highlight", {}, 1500);
			},
			getTrackerStatusData:function(){
				$.ajax({
					  url: '<?php echo $this->webroot;?>livetrackerjson/'+VTS_LIVE_TRACKING.device_init_data.ClientDevice.deviceid,
					  
					  type: 'POST',
					  success: function(data, textStatus, jqXHR){	
						  var device_data = JSON.parse(data);	
						  if(device_data.DeviceStatus.recordEventNumber != VTS_LIVE_TRACKING.lastEventNumber){
							  
							  VTS_LIVE_TRACKING.device_data = device_data;
							  VTS_LIVE_TRACKING.updateTrackerInfo();
						  } 							  
					  },
					  error: function(jqXHR, textStatus, errorThrown){
					  }
					});
			},
			drawLineArwLine:function(dt){
				//lat,lng, plat, plng){
				var pts7 = new Array();
				
				pts7.push (new google.maps.LatLng(this.prevLatLong[0], this.prevLatLong[1]));
				pts7.push (new google.maps.LatLng(dt.latLng[0], dt.latLng[1]));						
				this.poly7.push(new BDCCArrowedPolyline(pts7,"#FF0000",2,1,null,30,5,"#0000FF",2,1));
				
			},
			addMarker:function(data){
				//var l = data.length-1;
				var centerLatLng = data.latLng;
				
				putMarkerOnMap('single-tracker-map', data);
				setMapCenterOfPoints('single-tracker-map', centerLatLng);	
				//$('#single-tracker-map').gmap3('get').setCenter(new google.maps.LatLng(centerLatLng[0],centerLatLng[1]));
				// change premarker
				var marker = $("#single-tracker-map").gmap3({get:{name:"marker",tag:this.lastEventNumber}});
				if(marker)
					marker.setIcon(this.prevMarker);
			},
			updateHistoryData:function(data){
				
			},
			setMapCenter:function(lat,lng){
				$('#single-tracker-map').gmap3('get').setCenter(new google.maps.LatLng(lat,lng));
			},
			clearMarkers:function (){
				$('#single-tracker-map').gmap3('clear', 'markers');
				for(var i=0;i<this.poly7.length;i++) {				
					this.poly7[i].removeAll();				
				}			
				this.poly7=null;
			}
		};
	$(document).ready(function(){
		
		$.timer("tracker_timer_<?php echo $deviceInfo['ClientDevice']['deviceid']?>", function() { 
			VTS_LIVE_TRACKING.getTrackerStatusData();
		}, 20);

		VTS_LIVE_Gauge_Fule = new jGauge(); // Create a new jGauge.
		VTS_LIVE_Gauge_Fule.id = 'live-gauge-fuel'; // Link the new jGauge to the placeholder DIV.
		//demoGauge1.label.suffix = 'B'; // Make the value label bytes.
		//demoGauge1.autoPrefix = autoPrefix.binary; // Use binary prefixing (i.e. 1k = 1024).
		//demoGauge1.ticks.count = 5;
		//demoGauge1.ticks.end = 8;

		VTS_LIVE_Gauge_Speed = new jGauge(); // Create a new jGauge.
		VTS_LIVE_Gauge_Speed.id = 'live-gauge-speed'; // Link the new jGauge to the placeholder DIV.
		VTS_LIVE_Gauge_Speed.autoPrefix = autoPrefix.si; // Use SI prefixing (i.e. 1k = 1000).
		VTS_LIVE_Gauge_Speed.imagePath = '/vts/img/jgauge_face_taco.png';
		VTS_LIVE_Gauge_Speed.segmentStart = -225;
		VTS_LIVE_Gauge_Speed.segmentEnd = 45;
		VTS_LIVE_Gauge_Speed.width = 170;
		VTS_LIVE_Gauge_Speed.height = 170;
		VTS_LIVE_Gauge_Speed.needle.imagePath = '/vts/img/jgauge_needle_taco.png';
		VTS_LIVE_Gauge_Speed.needle.xOffset = 0;
		VTS_LIVE_Gauge_Speed.needle.yOffset = 0;
		VTS_LIVE_Gauge_Speed.label.yOffset = 55;
		VTS_LIVE_Gauge_Speed.label.color = '#fff';
		VTS_LIVE_Gauge_Speed.label.precision = 0; // 0 decimals (whole numbers).
		VTS_LIVE_Gauge_Speed.label.suffix = 'Km'; // Make the value label watts.
		VTS_LIVE_Gauge_Speed.ticks.labelRadius = 45;
		VTS_LIVE_Gauge_Speed.ticks.labelColor = '#0ce';
		VTS_LIVE_Gauge_Speed.ticks.start = 0;
		VTS_LIVE_Gauge_Speed.ticks.end = 125;
		VTS_LIVE_Gauge_Speed.ticks.count = 6;
		VTS_LIVE_Gauge_Speed.ticks.color = 'rgba(0, 0, 0, 0)';
		VTS_LIVE_Gauge_Speed.range.color = 'rgba(0, 0, 0, 0)';
                        
		VTS_LIVE_Gauge_Fule.init();
		VTS_LIVE_Gauge_Speed.init();
		
		VTS_LIVE_Obometer = $('#live-odometer').jOdometer({spaceNumbers: 2, increment: 1, counterStart:'000000000000', numbersImage: '/vts/img/jodometer-numbers.png', spaceNumbers: 1, offsetRight:-1});
		var vl = zeroFill( <?php echo $deviceInfo['DeviceStatus']['vehicleOdometer']?>, 10 );
		VTS_LIVE_Obometer.goToNumber(vl);
		
		initMap("single-tracker-map");

		VTS_LIVE_TRACKING.setMapCenter(<?php echo $deviceInfo['DeviceStatus']['vehicleLat']?>,<?php echo $deviceInfo['DeviceStatus']['vehicleLng']?>);
		map = $('#single-tracker-map').gmap3('get');
		$("#tracker-status-info .alert").effect("highlight", {}, 1500);
		$("[rel='tooltip']").tooltip();

		VTS_LIVE_TRACKING.updateTrackerInfo();
        $.timer("tracker_timer_<?php echo $deviceInfo['ClientDevice']['deviceid']?>").start();
        setInitInfo(<?php echo $deviceInfo['DeviceStatus']['timeDiff']?>, 
                		'<?php echo $deviceInfo['DeviceStatus']['nearaddress']?>');

		
	});
	
	function closeModal(){
		$("#modal-place-holder").hide();
	}
</script>
<style>
.text-red {
	color: red !important;
}

#single-tracker-map img {
	max-width: none;
}

#single-tracker-map label {
	width: auto;
	display: inline;
}

#tracker-status-info {
	bottom: 10px;
    left: 12px;
    position: fixed;
    z-index: 999;
}

.table th,.table td {
	line-height: 12px;
}
</style>
