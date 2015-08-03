<input id="did" value="<?php echo $did?>" type="hidden" />
<input id="sdate" value="<?php echo $sDate?>" type="hidden" />
<div class="span12" style="margin-left: 0.5%; padding: 0;">
	<div class="row-fluid">
		<div class="span12">
			<div class="box">
				<header>
					<div id="tracker-header-info" style="margin: 2px 0 2px 10px"
						class="pull-left">
						<img style="width: 32px; height: 32px;"
							class="contact-item-object v-icon tracker-btn" alt="tracker" src="">
						<div class="btn-group">
							<!--notification-->
							<a class="btn btn-info" data-toggle="dropdown"
								data-original-title="Tracker Information" rel="tooltip"
								data-placement="bottom" href="#" id="lnkTrackerId"></a>


							<div
								style="padding: 10px; min-width: 300px; border: 2px solid #BCE8F1;"
								class="dropdown-menu dropdown-notification2"
								id="trackerInfoTableId">
								<table style="width: 100%;">
									<thead>
										<tr>
											<th colspan="2" align="center"
												style="background-color: #BCE8F1;">Tracker Information</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><strong>Registration Number:</strong></td>
											<td id="trckr-inf-reg"></td>
										</tr>
										<tr style="background-color: #BCE8F1;">
											<td><strong>Expiry Date:</strong></td>
											<td id="trckr-inf-exdt"></td>
										</tr>
										<tr>
											<td><strong>Type:</strong></td>
											<td id="trckr-inf-dtpe"></td>
										</tr>
										<tr style="background-color: #BCE8F1;">
											<td><strong>Description:</strong></td>
											<td id="trckr-inf-desc"></td>
										</tr>
										<tr>
											<td><strong>Unit SIM:</strong></td>
											<td id="trckr-inf-cell"></td>
										</tr>
										<tr style="background-color: #BCE8F1;">
											<td><strong>Speed Limit:</strong></td>
											<td id="trckr-inf-lmt"></td>
										</tr>
									</tbody>
								</table>
							</div>
							<!--notification-->

						</div>
						<a data-original-title="Highlight Last Location" rel="tooltip"
							data-placement="bottom"
							onclick="VTS_LIVE_TRACKING.focusMarker();" href="#"
							class="btn btn-info"><i class="icon-screenshot"></i> </a>

					</div>


					<div class="pull-right btn-group" style="margin: 2px 15px 2px 0">

						<div class="btn-group">
							<a href="#live-tracker-info" data-toggle="tab"
								data-placement="bottom" data-original-title="Sensors"
								rel="tooltip" class="btn menu-ajax btn-info" id="sensorId"> <i
								class="icon-gamepad"></i>
							</a> <a href="#live-tracker-history" data-toggle="tab"
								data-placement="bottom" data-original-title="Live-Update"
								rel="tooltip" class="btn menu-ajax" id="updateId"> <i
								class="icon-time"></i> <span class="label"
								id="tracker-notifications-count">0</span>
							</a>
						</div>
						<!-- 					<div class="btn-group"> -->
						<!-- 						<a href="#live-tracker-history" data-toggle="tab" -->
						<!-- 							data-placement="bottom" data-original-title="Live-Update" -->
						<!-- 							rel="tooltip" class="btn btn-metis-4 menu-ajax"> <i class="icon-time"></i> -->
						<!-- 							<span class="label btn-metis-6" id="tracker-notifications-count">0</span> </a> -->
						<!-- 					</div> -->
					</div>
				</header>
				<div id="live-tracking-map" class="gMap"
					style="width: 79%; margin: 0; padding-left: 0; float: left;"></div>


				<div class="body tab-content"
					style="float: left; width: 20%; background-color: #fff; margin: 0; padding: 0;">
					<div id="live-tracker-info" class="tab-pane active">

						<ul id="sensors" style="margin-left: 1.5%;">
							<!-- 							<li id="tracker-type" style="padding: 5px 0;"><span
								class="badge badge-info">Vehicle Tracker</span> -->
							<!-- 							</li> -->
							<li id="tracker-type" style="padding: 5px 2px;">Type: <span
								class="badge badge-info">Vehicle Tracker</span>
							</li>
							<li id="tracker-ignition" style="padding: 5px 2px;">Ignition: <span
								class="badge badge-important">Off</span>
							</li>
							<li><hr/></li>
							
							<!-- 							
							<li>
								<h4>Odometer</h4>
								<div id="live-odometer" class="counter1"></div> Km</li>
							<li>
								<h4>Fuel</h4>
								<div id="live-gauge-fuel" class="jgauge"></div>
							</li>  -->
							
							<li>
								<div id="live-gauge-speed" class="jgauge"></div>
							</li>
							<li style="text-align: center;"><span class="badge badge-info">SPEED</span>
							</li>
						</ul>
					</div>
					<div id="live-tracker-history" class="tab-pane"
						style="float: left; width: 100%;">
						<table class="table table-condensed table-hovered sortableTable"
							style="float: left">
							<thead>
								<tr>
									<th colspan="3">Live-Update:</th>
								</tr>
								<tr>
									<th>Date-Time</th>
									<th>Ignition</th>
									<th>Location</th>
								</tr>
							</thead>
							<tbody id="tracker-notifications-title">

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>

<div id="tracker-status-info" class="pull-left" style="margin-left: 8px;">
	<div
		style="margin-bottom: 0; color: #000 !important; background-color: #fff; border: 2px solid #BCE8F1; padding: 10px 5px">
		<i class="icon-map-marker"></i> <b>Location:</b><strong><span
			id="trakcer-location-info"> </span> </strong>
	</div>
</div>
<style type="text/css">
#trackerInfoTableId tr td {
	font-size: 0.7em;
	padding: 2px;
}

#tracker-status-info {
	bottom: 20px;
	left: 0px;
	position: fixed;
	z-index: 999;
	width: 220px;
	font-size: 0.9em;
}

#sensors {
	float: left;
	list-style: none;
}

#map,html,body {
	padding: 0;
	margin: 0;
	height: 100%;
}

#panel {
	font-family: Arial, sans-serif;
	font-size: 13px;
	float: right;
	margin: 10px;
}

#color-palette {
	clear: both;
}

.color-button {
	width: 14px;
	height: 14px;
	font-size: 0;
	margin: 2px;
	float: left;
	cursor: pointer;
}

.simplecolorpicker.icon {
	border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3;
	border-image: none;
	border-radius: 4px 4px 4px 4px;
	border-style: solid;
	border-width: 1px;
	box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px
		rgba(0, 0, 0, 0.05);
	color: #333333;
	cursor: pointer;
	display: inline-block;
	font-size: 14px;
	line-height: 20px;
	margin-bottom: 0;
	padding: 4px 12px;
	text-align: center;
	text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
	vertical-align: middle;
}

div.jgauge p.label {
	background-color: transparent;
}

.counter1 {
	width: 150px;
	height: 31px;
	border: 1px solid #fff;
	overflow: hidden;
	position: relative;
	background-color: #000;
}

.counter1 img {
	border: 1px solid #eee;
}

.jgauge {
	margin: 0 0 10px 10px !important;
}

.alert_info {
	border-color: #666;
}

/* your custom CSS \*/
/* your custom CSS \*/
@
-moz-keyframes pulsate {from { -moz-transform:scale(0.25);
	opacity: 1.0;
}

95%
{
-moz-transform
:
 
scale
(1
.3
);

			
opacity
:
 
0;
}
to {
	-moz-transform: scale(0.3);
	opacity: 0;
}

}
@
-webkit-keyframes pulsate {from { -webkit-transform:scale(0.25);
	opacity: 1.0;
}

95%
{
-webkit-transform
:
 
scale
(1
.3
);

			
opacity
:
 
0;
}
to {
	-webkit-transform: scale(0.3);
	opacity: 0;
}

}
/* get the container that's just outside the marker image, 
		which just happens to have our Marker title in it */
#live-tracking-map div.gmnoprint[title="Last Position"] {
	-moz-animation: pulsate 1.5s ease-in-out infinite;
	-webkit-animation: pulsate 1.5s ease-in-out infinite;
	border: 1pt solid #fff;
	/* make a circle */
	-moz-border-radius: 51px;
	-webkit-border-radius: 51px;
	border-radius: 51px;
	/* multiply the shadows, inside and outside the circle */
	-moz-box-shadow: inset 0 0 5px #06f, inset 0 0 5px #06f, inset 0 0 5px
		#06f, 0 0 5px #06f, 0 0 5px #06f, 0 0 5px #06f;
	-webkit-box-shadow: inset 0 0 5px #06f, inset 0 0 5px #06f, inset 0 0
		5px #06f, 0 0 5px #06f, 0 0 5px #06f, 0 0 5px #06f;
	box-shadow: inset 0 0 5px #06f, inset 0 0 5px #06f, inset 0 0 5px #06f,
		0 0 5px #06f, 0 0 5px #06f, 0 0 5px #06f;
	/* set the ring's new dimension and re-center it */
	height: 51px !important;
	margin: -10px 0 0 -10px;
	width: 51px !important;
}
/* hide the superfluous marker image since it would expand and shrink with its containing element */
/*	#live-tracking-map div[style*="987654"][title] img {*/
#live-tracking-map div.gmnoprint[title="Last Position"] img {
	display: none;
}
/* compensate for iPhone and Android devices with high DPI, add iPad media query */
@media only screen and (-webkit-min-device-pixel-ratio: 1.5) , only
	screen and (device-width: 768px) {
	#live-tracking-map div.gmnoprint[title="Last Position"] {
		margin: -10px 0 0 -10px;
	}
}

#live-tracker-history th {
	font-size: .8em;
	line-height: .9em;
}

#live-tracker-history td {
	line-height: .9em;
}

#live-tracker-history td span {
	line-height: .9em;
}
</style>

<script type="text/javascript">
	var VTS_LIVE_Gauge_Fule;
	var VTS_LIVE_Gauge_Speed;
	var VTS_LIVE_TRACKING = {
			mapid: '#live-tracking-map',
			map: null,
			zoomlevel: 14,
			did: '',
			
			Odometer: null,
			
			prevLatLong:null,
			poly7:new Array(),
			lastEventNumber:0,
			prevMarker:"",

			deviceType : "VT",
			vehicleType : "human",
	
			initTimer:function () {		        
				$.timer("live_tracking_timer", function() { 
					VTS_LIVE_TRACKING.getTrackerStatusData();
				}, 20);				
		        $.timer("live_tracking_timer").start(); 
		      },
			initMap:function () {
				var h = $(window).height();
		        MAP_HELPER.initMap(VTS_LIVE_TRACKING.mapid, "79%", h - 110);

				VTS_LIVE_TRACKING.setMapCenter(23.789720, 90.376460);
		        
		      },
		      initGauges:function(){  
		    	VTS_LIVE_Gauge_Speed = new jGauge(); // Create a new jGauge.
				VTS_LIVE_Gauge_Speed.id = 'live-gauge-speed'; // Link the new jGauge to the placeholder DIV.
				VTS_LIVE_Gauge_Speed.autoPrefix = autoPrefix.si; // Use SI prefixing (i.e. 1k = 1000).
				VTS_LIVE_Gauge_Speed.imagePath = APP_COMMON.app_root+'img/jgauge_face_taco.png';
				VTS_LIVE_Gauge_Speed.segmentStart = -225;
				VTS_LIVE_Gauge_Speed.segmentEnd = 45;
				VTS_LIVE_Gauge_Speed.width = 170;
				VTS_LIVE_Gauge_Speed.height = 170;
				VTS_LIVE_Gauge_Speed.needle.imagePath = APP_COMMON.app_root+'img/jgauge_needle_taco.png';
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

				//VTS_LIVE_Gauge_Fule.init();           				
				VTS_LIVE_Gauge_Speed.init();
			  },			
			  initOdometer:function(){
				  VTS_LIVE_TRACKING.Odometer = $('#live-odometer').jOdometer({spaceNumbers: 2, increment: 1, counterStart:'000000000000', numbersImage: APP_COMMON.app_root+'img/jodometer-numbers.png', spaceNumbers: 1, offsetRight:-1});
					var vl = MAP_HELPER.zeroFill( 0, 10 );
					VTS_LIVE_TRACKING.Odometer.goToNumber(vl);
			  },			
			  initDeviceInfo:function(dvPrf){
				    $('#lnkTrackerId').html(dvPrf.ClientDevice.name);
					$('#trckr-inf-dtpe').html(dvPrf.DeviceType.name);
					$('#trckr-inf-cell').html(dvPrf.ClientDevice.mob_no);
					$('#trckr-inf-reg').html(dvPrf.ClientDevice.name);
					$('#trckr-inf-lmt').html(dvPrf.ClientDevice.speed_limit);
					$('#trckr-inf-exdt').html(dvPrf.ClientDeviceSubscription.expiry_date);
			  },
			  initInfo:function(tdif, add){		
					var tdif = MAP_HELPER.ReturnTimeDiff(tdif);
					var t = " For last "+tdif + " <br/>" + add;
					$("#trakcer-location-info").html(t);
				},
				setTitleIcon : function(t, s, i){
					
					var ticon = MAP_HELPER.getTrackerImg("large", t, s, i);
					
					$("#tracker-header-info img[alt=tracker]").attr("src", ticon);
				},
				setInitInfo :function (tdif, add){	
					if(tdif == 0){
						$("#trakcer-location-info").html('  No Update');
						}
					else{	
						var tdif = MAP_HELPER.ReturnTimeDiff(tdif);
						var t = " For last "+tdif + " <br/>" + add;
						$("#trakcer-location-info").html(t);
					}
				},
							
				setMapCenter:function(lat,lng){
					$(VTS_LIVE_TRACKING.mapid).gmap3('get').setCenter(new google.maps.LatLng(lat,lng));
				},
				focusMarker:function(){
					VTS_LIVE_TRACKING.setMapCenter(this.prevLatLong[0],this.prevLatLong[1]);
					var marker = $(VTS_LIVE_TRACKING.mapid).gmap3({get:{name:"marker",tag:this.lastEventNumber}});
					if(marker)					
						google.maps.event.trigger(marker,'click');
				},
				focusMarkerById:function(id){		
					var marker = $(VTS_LIVE_TRACKING.mapid).gmap3({get:{name:"marker",tag:id.toString()}});
					if(marker)					
						google.maps.event.trigger(marker,'click');
				},
				refreshMsgBox:function(tdif, add){
					VTS_LIVE_TRACKING.setInitInfo(tdif, add);
					$("#tracker-status-info .alert").effect("highlight", {}, 1500);
				},	
				clearMarkers:function (){
					$(VTS_LIVE_TRACKING.mapid).gmap3('clear', 'markers');
					for(var i=0;i<this.poly7.length;i++) {				
						this.poly7[i].removeAll();				
					}			
					this.poly7=null;
				},	  

				addToTrackerHistoryList:function(v){
					//var msg = '<li><a href="#" style="white-space:normal" onclick="VTS_LIVE_TRACKING.focusMarkerById('+v.recordEventNumber+');return false;">'+
					var msg = '<tr style="cursor: pointer; padding: 0px; font-size:10px" onclick="VTS_LIVE_TRACKING.focusMarkerById('+v.recordEventNumber+');return false;">'
							  + '<td>'+v.serverDateTime
							  + '</td>'
							  + '<td>'+getMovingStatus(v.vehicleSpeed,v.ignitionStatus)
							  + '</td>'
							  + '<td>'+v.nearaddress
							  + '</td>'
							  + '</tr>';									
					
					$("#tracker-notifications-title").append(msg);
					var cnt = $("#tracker-notifications-title tr").size();
					$("#tracker-notifications-count").html(cnt);	
				},
				drawLineArwLine:function(dt){
					//lat,lng, plat, plng){
					var pts7 = new Array();
					
					pts7.push (new google.maps.LatLng(this.prevLatLong[0], this.prevLatLong[1]));
					pts7.push (new google.maps.LatLng(dt.latLng[0], dt.latLng[1]));						
					this.poly7.push(new BDCCArrowedPolyline(pts7,"#FF0000",2,1,null,30,5,"#0000FF",2,1));
					
				},	
				changeMarkerTitle:function(){
					var marker = $(VTS_LIVE_TRACKING.mapid).gmap3({get:{name:"marker",tag:VTS_LIVE_TRACKING.lastEventNumber}});
					if(marker){
						//marker.setIcon(this.prevMarker);
						marker.setTitle("");
						//$('#live-tracking-map div.gmnoprint[title="Last Position"]').attr("title","");
					}					
				},
				addMarker :function(data){
					//var l = data.length-1;
					var centerLatLng = data.latLng;
					
					MAP_HELPER.putMarkerOnMap(VTS_LIVE_TRACKING.mapid, data);
					MAP_HELPER.setMapCenterOfPoints(VTS_LIVE_TRACKING.mapid, centerLatLng);	
				},
				getTrackerStatusData:function(){
					APP_COMMON.loadReportDeviceStatusByDid(VTS_LIVE_TRACKING.did,$('#sdate').val(),function(){
	    				// get device record
	    				var device_record = APP_COMMON.getDeviceStatusByDeviceid(VTS_LIVE_TRACKING.did);
	    				
	    				VTS_LIVE_TRACKING.updateTrackerInfo(device_record);	
	        		});					
				},
				updateTrackerInfo:function(device_record){

					var v = device_record;

					if(VTS_LIVE_TRACKING.lastEventNumber == v.recordEventNumber){
						VTS_LIVE_TRACKING.setTitleIcon(VTS_LIVE_TRACKING.vehicleType, v.vehicleSpeed,v.ignitionStatus);
						return;
					}
					var data = MAP_HELPER.getInfoBubbleData2(v);//getInfoBubbleData2(v);
					var icon = MAP_HELPER.getMarkerImg(VTS_LIVE_TRACKING.vehicleType,v.vehicleSpeed, v.ignitionStatus);
					var dt = {
						latLng : [ v.vehicleLat, v.vehicleLng ],
						data : data,
						id : v.recordEventNumber,	
						tag : v.recordEventNumber,					
						 options:{
			            		optimized: false,
				            	icon: icon,
				              	draggable: false,
				              	title: "Last Position"
				              	}											
						};
						
					this.addMarker(dt);
					
					if(VTS_LIVE_TRACKING.prevLatLong){
						VTS_LIVE_TRACKING.drawLineArwLine(dt);
						VTS_LIVE_TRACKING.changeMarkerTitle();
					}
					VTS_LIVE_TRACKING.prevLatLong = [v.vehicleLat,v.vehicleLng];
					
					// update the view tracker-odometer  knob-speed
					var vl = MAP_HELPER.zeroFill( v.vehicleOdometer, 10 );
					//VTS_LIVE_TRACKING.Odometer.goToNumber(vl);
					
					//VTS_LIVE_Gauge_Fule.setValue(v.vehicleFuel);
					VTS_LIVE_Gauge_Speed.setValue(v.vehicleSpeed);

					var st = getMovingStatus(v.vehicleSpeed,v.ignitionStatus);
					$("#tracker-ignition").html('Ignition: '+st);

					// refresh the msg box
					VTS_LIVE_TRACKING.refreshMsgBox(v.timeDiff, v.nearaddress);
					// add record to list
					VTS_LIVE_TRACKING.addToTrackerHistoryList(v);

					VTS_LIVE_TRACKING.lastEventNumber = v.recordEventNumber;

					//
					var mst = ""; 
					if(v.ignitionStatus!="0"){
						mst = getMovingStatus(v.vehicleSpeed,v.ignitionStatus);				
					}

					VTS_LIVE_TRACKING.setTitleIcon(VTS_LIVE_TRACKING.vehicleType, v.vehicleSpeed,v.ignitionStatus);
					
					$("#tracker-moving-status").html(mst);
				},
				init: function(){

					APP_COMMON.app_root = APP_URL_ROOT;
					
					VTS_LIVE_TRACKING.initMap();
					VTS_LIVE_TRACKING.initGauges();
					//VTS_LIVE_TRACKING.initOdometer();

					APP_COMMON.bindResizeDiv(VTS_LIVE_TRACKING.mapid,110);
					APP_COMMON.bindResizeDiv('#live-tracker-info',110);
					APP_COMMON.bindResizeDiv('#live-tracker-history',110);					

					VTS_LIVE_TRACKING.did = $('#did').val();

					VTS_LIVE_TRACKING.getTrackerStatusData();
					
					var deviceInfo = APP_COMMON.getDeviceProfileByDeviceid(VTS_LIVE_TRACKING.did);

					VTS_LIVE_TRACKING.deviceType = deviceInfo.DeviceType.name;
					
					if(VTS_LIVE_TRACKING.deviceType == "VT"){
						VTS_LIVE_TRACKING.vehicleType = deviceInfo.VehicleType.name;
					}
					
					VTS_LIVE_TRACKING.initDeviceInfo(deviceInfo);
					
					$("#tracker-status-info .alert").effect("highlight", {}, 1500);

					VTS_LIVE_TRACKING.initTimer();
					VTS_LIVE_TRACKING.setInitInfo(0,'');
					
				}
					
	};
	
	$(function(){
		
		APP_COMMON.initPage('Live Tracking');
		VTS_LIVE_TRACKING.init();

		$("#sensorId").bind('click', function(){
			$(this).addClass('btn-info');
			$("#updateId").removeClass('btn-info');
			});
		$("#updateId").bind('click', function(){
			$(this).addClass('btn-info');
			$("#sensorId").removeClass('btn-info');
			});
    });

</script>
