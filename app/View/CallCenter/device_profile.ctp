<div id="modal-place-holder">
	<?php //echo $this->element('Dashboard/tracker_info');?>	
</div>

<div class="span12" style="margin: 0; padding: 0;">
	<div class="row-fluid">
		<div class="span12">
			<div class="box">
				<header>
				<h5><i class="icon-map-marker"></i> Tracking Summary</h5>
				<div class="" style="margin: 5px 0 0 50px; float: left">
					<div class="btn-group">					
						<a href="javascript:;" id="btnToggleCluster" data-toggle="buttons-checkbox"
							data-placement="bottom" data-original-title="Toggle Cluster"
							rel="tooltip" class="btn btn-metis-6"> <i class="icon-asterisk"></i>
						</a>
					</div>
				</div>
				<div class="pull-right" style="padding: 0 20px;width: 200px;">
					<h5 style="margin:5px 0;padding:0;">Total Trackers : <span style="font-size:1.5em; padding: 5px;" class="label btn-metis-6" id="totalTrackers">2</span></h5> 
				</div>
				</header>
				<div id="live-tracking-map" class="gMap"
					style="width: 79%; margin: 0; padding-left: 0; float: left;">
				</div>
			</div>
		</div>

	</div>

</div>


<style>

#tracker-list {
	min-height: 100px;
	overflow-y: scroll;
	padding: 5px 0 0 5px;
}

.tracker {
	margin: 0;
}

.tracker li {
	background-color: #F5F5F5;
    background-image: linear-gradient(to bottom, #FFFFFF, #E6E6E6);
	border-radius: 3px 3px 3px 3px;
	box-shadow: 0 0 0 1px #F8F8F8 inset, 0 0 0 1px #CCCCCC;
	display: inline-block;
	line-height: 18px;
	margin: 0 0 5px 0;
	padding: 0 10px;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.6);
	
}


#tracker-list li {
	display: block;
	margin: 2px 0;
	padding: 0;
	float: left;
	width: 98%;
	height: 38px;
}

.lnkTracker {
	display: block;
	float: left;
	font-weight: bold;
	color: #000;
	text-decoration: none;
	font-size: .8em;
	height: 38px;
	
	text-align: center;
}
.lnkTracker:hover{
	text-decoration: none;
}

.lnkTracker span {
    height: 30px;
    text-align: center;
    vertical-align: sub;
    float: left;
    font-size: .9em;
    line-height: 1.3em;
    margin-top: 5px; 
}
.lnkTracker img {
	margin: 0;
	padding: 0;
	float: left;
	width: 32px;

    color: #333333;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    line-height: 17px;
    margin: 2px;
    padding: 2px;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
    vertical-align: middle;
}

.tracker-btn {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #F5F5F5;
    background-image: linear-gradient(to bottom, #FFFFFF, #E6E6E6);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3;
    border-image: none;
    border-radius: 4px 4px 4px 4px;
    border-style: solid;
    border-width: 1px;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
    color: #333333;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    line-height: 17px;
    margin-bottom: 0;
    padding: 4px 12px;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
    vertical-align: middle;
    height: 24px;
}

.tracker-btn {
    border-radius: 0px 4px 4px 0px;
    float: right;
    margin: 2px;
}
</style>
<style type="text/css">
#tracker-status-info {
	bottom: 20px;
	left: 20px;
	position: fixed;
	z-index: 999;
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
	@-moz-keyframes pulsate {
		from {
			-moz-transform: scale(0.25);
			opacity: 1.0;
		}
		95% {
			-moz-transform: scale(1.3);
			opacity: 0;
		}
		to {
			-moz-transform: scale(0.3);
			opacity: 0;
		}
	}
	@-webkit-keyframes pulsate {
		from {
			-webkit-transform: scale(0.25);
			opacity: 1.0;
		}
		95% {
			-webkit-transform: scale(1.3);
			opacity: 0;
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
<style>
.knobd {
	overflow: hidden;
}

.stat-label {
	margin-top: -100px;
}

.side-contact ul.contact-list {
	height: 550px;
	max-height: 550px;
	overflow-y: auto;
	overflow-x: hidden;
}

.side-contact ul.contact-list .contact-alt {
	height: 60px;
}

.side-contact ul.contact-list .contact-alt a {
	height: 52px;
	max-height: 52px;
}

.cluster {
	color: #FFFFFF;
	text-align: center;
	font-family: 'Arial, Helvetica';
	font-size: 11px;
	font-weight: bold;
}

.cluster-1 {
	background-image: url(img/tracker/m1.png);
	line-height: 53px;
	width: 53px;
	height: 52px;
}

.cluster-2 {
	background-image: url(img/tracker/m2.png);
	line-height: 53px;
	width: 56px;
	height: 55px;
}

.cluster-3 {
	background-image: url(img/tracker/m3.png);
	line-height: 66px;
	width: 66px;
	height: 65px;
}

.label-number-plate {
	color: #000;
	background-color: #fff; /*#498af3; #d33e3e, #75c200*/
	font-family: "Lucida Grande", "Arial", sans-serif;
	font-size: 11px;
	font-weight: bold;
	text-align: left;
	border: 1px solid black;
	padding: 2px 5px;
	white-space: nowrap;
	border-radius: 5px;
	box-shadow: inset 0 0 2px #000000;
}

</style>

<script type="text/javascript">

var VTS_GROUP_Obometer;
var VTS_GROUP_Gauge_Speed;
var VTS_GROUP_Gauge_Fule;

	var VTS_DEVICE_PROFILE = {
			mapid: '#callcenter-tracking-map',
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

			deviceids: new Array(),

			timer_interval: 20,
			hack: true,
	
			initTimer:function () {		        
				$.timer("live_tracking_timer", function() { 
					VTS_DEVICE_PROFILE.getTrackerStatusData();
				}, VTS_DEVICE_PROFILE.timer_interval);	
							
		        $.timer("live_tracking_timer").start(); 
		      },
		      initSensorUI : function (){
		    		//VTS_GROUP_Gauge_Fule = new jGauge(); // Create a new jGauge.
		    		//VTS_GROUP_Gauge_Fule.id = 'live-gauge-fuel'; // Link the new jGauge to the placeholder DIV.
		    		//demoGauge1.label.suffix = 'B'; // Make the value label bytes.
		    		//demoGauge1.autoPrefix = autoPrefix.binary; // Use binary prefixing (i.e. 1k = 1024).
		    		//demoGauge1.ticks.count = 5;
		    		//demoGauge1.ticks.end = 8;

		    		VTS_GROUP_Gauge_Speed = new jGauge(); // Create a new jGauge.
		    		VTS_GROUP_Gauge_Speed.id = 'live-gauge-speed'; // Link the new jGauge to the placeholder DIV.
		    		VTS_GROUP_Gauge_Speed.autoPrefix = autoPrefix.si; // Use SI prefixing (i.e. 1k = 1000).
		    		VTS_GROUP_Gauge_Speed.imagePath = APP_COMMON.app_root+'img/jgauge_face_taco.png';
		    		VTS_GROUP_Gauge_Speed.segmentStart = -225;
		    		VTS_GROUP_Gauge_Speed.segmentEnd = 45;
		    		VTS_GROUP_Gauge_Speed.width = 170;
		    		VTS_GROUP_Gauge_Speed.height = 170;
		    		VTS_GROUP_Gauge_Speed.needle.imagePath = APP_COMMON.app_root+'img/jgauge_needle_taco.png';
		    		VTS_GROUP_Gauge_Speed.needle.xOffset = 0;
		    		VTS_GROUP_Gauge_Speed.needle.yOffset = 0;
		    		VTS_GROUP_Gauge_Speed.label.yOffset = 55;
		    		VTS_GROUP_Gauge_Speed.label.color = '#fff';
		    		VTS_GROUP_Gauge_Speed.label.precision = 0; // 0 decimals (whole numbers).
		    		VTS_GROUP_Gauge_Speed.label.suffix = 'Km'; // Make the value label watts.
		    		VTS_GROUP_Gauge_Speed.ticks.labelRadius = 45;
		    		VTS_GROUP_Gauge_Speed.ticks.labelColor = '#0ce';
		    		VTS_GROUP_Gauge_Speed.ticks.start = 0;
		    		VTS_GROUP_Gauge_Speed.ticks.end = 125;
		    		VTS_GROUP_Gauge_Speed.ticks.count = 6;
		    		VTS_GROUP_Gauge_Speed.ticks.color = 'rgba(0, 0, 0, 0)';
		    		VTS_GROUP_Gauge_Speed.range.color = 'rgba(0, 0, 0, 0)';
		    	                    
		    		//VTS_GROUP_Gauge_Fule.init();
		    		VTS_GROUP_Gauge_Speed.init();
		    		
		    		//VTS_GROUP_Obometer = $('#live-odometer').jOdometer({spaceNumbers: 2, increment: 1, counterStart:'000000000000', numbersImage: '/vts/img/jodometer-numbers.png', spaceNumbers: 1, offsetRight:-1});
		    		var vl = MAP_HELPER.zeroFill( 0, 10 );
		    		VTS_GROUP_Obometer.goToNumber(vl);
		    		
		    	},			
			  initDeviceInfo:function(dvPrf){

					$('#trckr-inf-dtpe').html(dvPrf.DeviceType.name);
					$('#trckr-inf-mdl').html(dvPrf.DeviceInfo.name);
					$('#trckr-inf-imei').html(dvPrf.ClientDevice.imei);
					$('#trckr-inf-cell').html(dvPrf.ClientDevice.mob_no);
					$('#trckr-inf-reg').html(dvPrf.ClientDevice.name);
					$('#trckr-inf-lmt').html(dvPrf.ClientDevice.speed_limit);
					$('#trckr-inf-exdt').html(dvPrf.ClientDevice.expiry_date);
			  },
				setTitleIcon : function(t, s, i){
					var ticon = MAP_HELPER.getTrackerImg("large", t, s, i);
					$("#tracker-header-info img[alt=tracker]").attr("src", ticon);
				},
							
				setMapCenter:function(lat,lng){
					$(VTS_DEVICE_PROFILE.mapid).gmap3('get').setCenter(new google.maps.LatLng(lat,lng));
				},
				focusMarkerById : function (id) {
					var clusterer = $(VTS_DEVICE_PROFILE.mapid).gmap3({
						get : {
							name : "clusterer"
						}
					});
					//console.debug(clusterer);
					if (clusterer) {
						clusterer.disable();
						var marker = clusterer.getById(id);
						if (marker)
							google.maps.event.trigger(marker, 'click');
						$("#btnToggleCluster").addClass("active");
					}
				},
				
				openTrackerInfoBox : function (id) {
					// get device info

					// get device status
					var di = APP_COMMON.getDeviceProfileByDeviceid(id);
					var ds = APP_COMMON.getDeviceStatusByDeviceid(id);
					
					$("#tracker-info-deviceid").html(di.ClientDevice.name);
					$("#tracker-info-lastrecorddate").next().html(ds.serverDateTime);
					$("#tracker-info-nearaddress").next().html(ds.nearaddress);
					$("#tracker-info-latlng").next()
							.html(ds.vehicleLat + " : " + ds.vehicleLng);

					$("#tracker-info-device_type").next().html(di.DeviceType.name);
					$("#tracker-info-device_model").next().html(di.DeviceInfo.name);
					$("#tracker-info-imei").next().html(di.ClientDevice.imei);
					$("#tracker-info-devicemobileno").next().html(
							di.ClientDevice.mob_no);
					$("#tracker-info-person_name").next().html(di.ClientDevice.name);
					$("#tracker-info-registration_number").next().html(
							di.ClientDevice.name);
					$("#tracker-info-speed_limit").next().html(di.ClientDevice.speed_limit);
					$("#tracker-info-expiry_date").next().html(di.ClientDevice.expiry_date);

					// sensor info	
					var vl = MAP_HELPER.zeroFill( ds.vehicleOdometer, 10 );
					VTS_GROUP_Obometer.goToNumber(vl);
					
					VTS_GROUP_Gauge_Fule.setValue(ds.vehicleFuel);
					VTS_GROUP_Gauge_Speed.setValue(ds.vehicleSpeed);
					
					//$("#tracker-info-speed").val(ds.vehicleSpeed);
					//$("#tracker-info-fuel").val(ds.vehicleFuel);
					//$("#tracker-info-odometer").html(ds.vehicleOdometer + " Km");

					$("#tracker-info-icon").attr("src", $("#img-" + id).attr("src"));
					$("#tracker-info-modal").show();
				},


				getTrackerStatusData:function(){

					MAP_HELPER._clusterHack(VTS_DEVICE_PROFILE.mapid);
					
					var p_data = APP_COMMON.getDeviceStatus();
					APP_COMMON.loadUserDeviceUpdatesByDeviceids(VTS_DEVICE_PROFILE.deviceids, function(data){
						
						$.each(p_data, function(i) {						
							//console.debug(this);			
							var n_data = APP_COMMON.getDeviceStatusByDeviceid(p_data[i].deviceid);
							if(n_data.recordEventNumber != p_data[i].recordEventNumber){
								//VTS_DEVICE_PROFILE.changeDeviceStatus(VTS_DEVICE_PROFILE.mapid, this);	
							}				
							VTS_DEVICE_PROFILE.changeDeviceStatus(VTS_DEVICE_PROFILE.mapid, this);									
						});
					});										
				},
				changeDeviceStatus : function (dMap, v) {
					//var deviceStatus = getDeviceStatusById(id);
					var deviceInfo = APP_COMMON.getDeviceProfileByDeviceid(v.deviceid);
					
					var lblCnt = "";
					var lbl = "human";
					if (deviceInfo.DeviceType.name == "PT") {
						//lblCnt = deviceInfo.ClientDevice.name;
					} else {
						//lblCnt = deviceInfo.ClientDevice.name;
						lbl = "car";
					}
					var ticon = getVehicleIcon(deviceInfo.VehicleType.name,
							v.vehicleSpeed, v.ignitionStatus);
					

					$("#img-" + v.deviceid).attr("src", APP_COMMON.app_root+"img/tracker/64/"+ticon);

					VTS_DEVICE_PROFILE.changeMarkerInCluster(VTS_DEVICE_PROFILE.mapid, v);
				},
				changeMarkerInCluster : function (dMap, v) {
										
					var clusterer = $(VTS_DEVICE_PROFILE.mapid).gmap3({
						get : {
							name : "clusterer"
						}
					});
					if (clusterer) {
						console.debug(clusterer);
						var marker = clusterer.getById(v.deviceid);
						console.debug(marker);
						if (marker) {
							//MAP_HELPER.changeMarkerStatus( v, marker);
						} else {
							VTS_DEVICE_PROFILE.createNewMarkerAddInCluster(dMap, v, clusterer);
						}
					} else {
						console.debug("no cluster");
						// no cluster
						var marker = $(dMap).gmap3({
							get : {
								name : "marker",
								tag : v.deviceid
							}
						});
					}
				},
				createNewMarkerAddInCluster : function (dMap,  v, clusterer) {
					clusterer.clearById(v.deviceid);
					$(dMap).gmap3({
						marker : {
							latLng : [ v.vehicleLat,v.vehicleLng ],
							data : v.nearaddress,
							tag : v.deviceid,
							id : v.deviceid,
							options : {
								draggable : true,
								labelAnchor : new google.maps.Point(-6, 33),
								labelClass : "labels",
								labelContent : v.deviceid,
								draggable : false,
								//					icon: icn
								icon : APP_COMMON.app_root+"img/tracker/marker-tag-blue.png"
							},
							events : {
								click : function(marker, event, context) {
									var map = $(this).gmap3("get");

									if (infoBubble.isOpen()) {
										infoBubble.close();

									}
									infoBubble.setContent(context.data);
									infoBubble.open(map, marker);
								}
							}
						}
					});
					var mrkr = $(dMap).gmap3({
						get : {
							name : "marker",
							tag : v.deviceid
						}
					});
					//console.debug(mrkr);
					clusterer.add(mrkr);
				},
				createTrackerList : function(devices){
					$('#tracker-list').html('');
					$.each(devices,function(i){
						var type = "human";
						if(devices[i].DeviceType.name=="VT"){
							type = devices[i].VehicleType.name;
						}
						var v = APP_COMMON.getDeviceStatusByDeviceid(devices[i].ClientDevice.deviceid);;
						var icn = MAP_HELPER.getTrackerImg("small",type,v.vehicleSpeed,v.ignitionStatus);
						var li = 	'<li id="'+devices[i].ClientDevice.deviceid+'">' +
									'	<a href="javascript:;" class="lnkTracker">' +
									'		<img src="'+icn+'">' +
									'		<span>'+devices[i].ClientDevice.name+'</span>' +
									'	</a>' +
									'	<a href="#" class="tracker-btn">' + 
									'		<i class="icon-external-link"></i>' +
									'	</a>' +
									'</li>';
						$('#tracker-list').append(li);		

						VTS_DEVICE_PROFILE.deviceids.push('"'+devices[i].ClientDevice.deviceid+'"');							
					});
					//console.debug(VTS_DEVICE_PROFILE.deviceids);
					$('#totalTrackers').html(devices.length);
				},
				
				loadClusterDataOnMap : function (dMap) 
				{
					var dt = new Array();
					var deviceInfo = "";
					var v = VTS_DEVICE_PROFILE.deviceids;// APP_COMMON.getDeviceStatus();
					$.each(v, function(i) {

						console.debug(v[i]);

						 //APP_COMMON.getDeviceProfileByDeviceid(v[i].deviceid);
						var url = 'clientDevices/getDeviceInfo/'+1;
						APP_HELPER.ajaxSubmitDataCallback(url,'',function(data){
							console.debug(data);
							deviceInfo = data;
							
						});
																	
						var lbl = "human";
						//if (deviceInfo.DeviceType.name == "VT"){
							//lbl = deviceInfo.VehicleType.name;
						//}
						
						
						if (deviceInfo.DeviceType.name == "VT"){
							lbl = deviceInfo.VehicleType.name;
						}
						var icon = MAP_HELPER.getMarkerImg(lbl,v[i].vehicleSpeed, v[i].ignitionStatus);

						var data = MAP_HELPER.getInfoBubbleData2(v[i]);

						var lblCnt = deviceInfo.ClientDevice.name;
						var l = lblCnt.length * 15 / 4;
						dt.push({
							latLng : [ v[i].vehicleLat, v[i].vehicleLng ],
							data : data,
							id : v[i].deviceid,
							tag : v[i].deviceid,
							options : {
								labelAnchor : new google.maps.Point(l, 10),
								labelClass : "label-number-plate",
								labelContent : lblCnt,
								draggable : false,
								icon : icon
							}
						});
					});

					// init the map and create a cluster with some markers
					MAP_HELPER.initClusterMap(VTS_DEVICE_PROFILE.mapid, dt);

					google.maps.event.addListenerOnce(map, 'idle', function(){
					    // do something only the first time the map is loaded
					    //MAP_HELPER._clusterHack(VTS_DEVICE_PROFILE.mapid);
						VTS_DEVICE_PROFILE.initTimer();
						//console.debug('map loaded');
					});
				},

				loadClusterDataOnMapForCallCenter : function (data) 
				{
					$.each(data, function(i) {

						console.debug(data[i]);
																	
						var lbl = "human";
				
						
						if (deviceInfo.DeviceType.name == "VT"){
							lbl = deviceInfo.VehicleType.name;
						}
						var icon = MAP_HELPER.getMarkerImg(lbl,v[i].vehicleSpeed, v[i].ignitionStatus);

						var data = MAP_HELPER.getInfoBubbleData2(v[i]);

						var lblCnt = deviceInfo.ClientDevice.name;
						var l = lblCnt.length * 15 / 4;
						dt.push({
							latLng : [ v[i].vehicleLat, v[i].vehicleLng ],
							data : data,
							id : v[i].deviceid,
							tag : v[i].deviceid,
							options : {
								labelAnchor : new google.maps.Point(l, 10),
								labelClass : "label-number-plate",
								labelContent : lblCnt,
								draggable : false,
								icon : icon
							}
						});
					});

					// init the map and create a cluster with some markers
					MAP_HELPER.initClusterMap(VTS_DEVICE_PROFILE.mapid, dt);

					google.maps.event.addListenerOnce(map, 'idle', function(){
					    // do something only the first time the map is loaded
					    //MAP_HELPER._clusterHack(VTS_DEVICE_PROFILE.mapid);
						VTS_DEVICE_PROFILE.initTimer();
						//console.debug('map loaded');
					});
				},
				openTrackerNewTab : function (id) {
					var win = window.open('trackerTracks/tracker_live_view/' + id, '_blank');
					win.focus();
					return false;
				},
				
				init: function()
				{
					
					// initTrackerList
					//var devices = APP_COMMON.getDeviceProfiles();

					//VTS_DEVICE_PROFILE.createTrackerList(devices);
					VTS_DEVICE_PROFILE.deviceids = JStorageLib.getCallCenterDeviceInfos();
					
					$('#totalTrackers').html(VTS_DEVICE_PROFILE.deviceids.length);
					APP_COMMON.loadForCallCenter(VTS_DEVICE_PROFILE.deviceids, function(data){

						//VTS_DEVICE_PROFILE.loadClusterDataOnMapForCallCenter(VTS_DEVICE_PROFILE.mapid);
						
					
					});					

					// 
					$('#btnToggleCluster').bind('click',function(){
						MAP_HELPER.toggleCluster(VTS_DEVICE_PROFILE.mapid, this);
					});
					$('#tracker-list .lnkTracker').bind('click',function(e){
						var deviceid = $(this).parent().attr('id');
						//VTS_DEVICE_PROFILE.openTrackerInfoBox(deviceid);
						//console.debug(deviceid);
						VTS_DEVICE_PROFILE.focusMarkerById(deviceid);
						e.preventDefault();
					});
					$('#tracker-list .tracker-btn').bind('click',function(e){
						var deviceid = $(this).parent().attr('id');
						VTS_DEVICE_PROFILE.openTrackerNewTab(deviceid);
						e.preventDefault();
					});

					// refresh data
					
					
					// bind tracker onclick open the live window
					
					APP_COMMON.bindResizeDiv(VTS_DEVICE_PROFILE.mapid,110);
					APP_COMMON.bindResizeDiv('#tracker-list',117);
					APP_COMMON.bindResizeDiv('#live-tracker-history',110);
						
					APP_COMMON.initPage('Tracking Summary');

					//VTS_DEVICE_PROFILE.initSensorUI();
					/*
					VTS_DEVICE_PROFILE.initGauges();
					VTS_DEVICE_PROFILE.initOdometer();

					*/
					// start timer for update data
					
					
				}
					
	};
	
	$(function(){	
		VTS_DEVICE_PROFILE.init();
    });



</script>
