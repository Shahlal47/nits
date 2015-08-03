<div class="navbar navbar-static-top" style="border-top: 3px solid #0088CC;">
	<div class="navbar-inner" style="padding: 0px;">
		<div class="container-fluid" style="padding: 0px;">

			<a data-target=".nav-collapse" data-toggle="collapse"
				class="btn btn-navbar"> <span class="icon-bar"></span> <span
				class="icon-bar"></span> <span class="icon-bar"></span> </a> <a
				style="margin: 0 10px; padding: 0;" href="index.html" class="brand"><img
				alt="Nits Logo" src="/nits/assets/img/logo.png"> </a>
		</div>
	</div>
</div>
<?php	$deviceInfo = $this->requestAction('trackerTracks/get_all_devices_profile');?>
<!-- span content -->
<div class="span12">
	<!-- content -->
	<div class="content" style="margin: 0; overflow: hidden;">
		<!-- content-header -->
		<div class="content-header">
			<h2>
				<i class="icofont-th"></i> Monitor Trackers <select
					onchange="createMapPortlets(this);" style="width: 50px"
					id="selNumOfMaps">
					<option value="0" selected>0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
				</select>
				<div class="pull-right">
					Tracker-List
					<button class="btn btn-primary " type="button"
						onclick="showLeftTrackerList();" data-placement="left"
						rel="tooltip" data-original-title="Live">
						<i class="icon-th-list"></i>
					</button>

				</div>
			</h2>
			<div class="pull-right"></div>
		</div>
		<!-- /content-header -->



		<!-- content-body -->
		<div class="content-body span12"
			style="padding: 0; float: left; overflow: hidden;">
			<!-- grids -->

			<!-- span4-->
			<div id="maps-container">
				<!-- 
				<div class="span12 map-container" id="1">
					<div class="box corner-all">
						<div class="box-header grd-white">
							<div class="header-control">
								<img id="1-icon" width="32" height="32" src="" alt="" />
							</div>
							<span id="1-title">Map</span>
						</div>
						<div class="box-body">
							<p>Please drag n drop a tracker...</p>
						</div>
					</div>
				</div>
 -->

			</div>

			<div id="monitor-rackers-list" class="pull-right hide">
				<ul class="content-header-action pull-right" id="tracker-list">
				<?php foreach($deviceInfo['DeviceProfiles'] as &$device){
					//pr($device);
					$vt = "human";
					$deviceid = $device['ClientDevice']['deviceid'];
					$hname = "";
					$clr = "ash";
					if(isset($deviceInfo['DeviceStatus'][''.$deviceid])){
						if($deviceInfo['DeviceStatus'][''.$deviceid]['ignitionStatus']==0
						&& $deviceInfo['DeviceStatus'][''.$deviceid]['vehicleSpeed']==0)
						{$clr = "red";}
						else if($deviceInfo['DeviceStatus'][''.$deviceid]['ignitionStatus']==0
						&& $deviceInfo['DeviceStatus'][''.$deviceid]['vehicleSpeed']>0)
						{$clr = "org";}
						else if($deviceInfo['DeviceStatus'][''.$deviceid]['ignitionStatus']==1
						&& $deviceInfo['DeviceStatus'][''.$deviceid]['vehicleSpeed']==0)
						{$clr = "blu";}
						else if($deviceInfo['DeviceStatus'][''.$deviceid]['ignitionStatus']==1
						&& $deviceInfo['DeviceStatus'][''.$deviceid]['vehicleSpeed']>0)
						{$clr = "grn";}
					}
					if($device['DeviceType']['name']=="PT"){
						$hname = $device['ClientDevice']['name'];
					}else{
						if($device['ClientDevice']['vehicle_type_id']){
							$vt = $device['VehicleType']['name'];
						}
						$hname = $device['ClientDevice']['name'];
					}
					?>
					<li id="<?php echo $deviceid?>"><a href="javascript:void(0);"
						class="action-text color-green"> <img width="42" height="42"
							src="img/tracker/64/<?php echo $vt."-".$clr?>.png"
							alt="<?php echo $vt."-".$clr?>" /> <?php echo $hname?>
					
					</li>

					<?php }?>
				</ul>
			</div>

			<!--/grids-->
		</div>
		<!--/content-body -->


	</div>
	<!-- /content -->
</div>
<!-- /span content -->

<script type="text/javascript">
	var VTS_GROUP_device_status = <?php echo json_encode($deviceInfo['DeviceStatus']);?>;
	var VTS_GROUP_device_profiles = <?php echo json_encode($deviceInfo['DeviceProfiles']);?>;
	var timer_array = new Array();
	var timer_a = new Array();

	var prevLat = new Array();
	var prevLng = new Array();
	var prevMarker = new Array();
	
            $(document).ready(function() {
				$("#monitor-tracker-list").height($("body").height()-30);
                $("#selNumOfMaps").val("0");
                $("#tracker-list li").draggable({
                    //appendTo: "body",
                    helper: "clone"
                  });
                
                
            		$.timer('timer_1', function() { 
            			refreshMarkerData(1);
            		}, 100);
            		$.timer('timer_2', function() { 
            			refreshMarkerData(2);
            		}, 100);
            		$.timer('timer_3', function() { 
            			refreshMarkerData(3);
            		}, 100);
            		$.timer('timer_4', function() { 
            			refreshMarkerData(4);
            		}, 100);
            		$.timer('timer_5', function() { 
            			refreshMarkerData(5);
            		}, 100);
            		$.timer('timer_6', function() { 
            			refreshMarkerData(6);
            		}, 100);
            });
            function drawLineArwLine2(lat,lng, i){
    			var pts7 = new Array();
    			pts7.push (new google.maps.LatLng(prevLat[i], prevLng[i]));
    			pts7.push (new google.maps.LatLng(lat, lng));
    			var lineSymbol = {	path: google.maps.SymbolPath.FORWARD_OPEN_ARROW };
    			
    			var map = $('#'+i+'-map').gmap3('get');
    			
    			var line = new google.maps.Polyline({
                        path: pts7,
                        strokeColor: "#FF0000",
                        strokeOpacity: 1.0,
                        strokeWeight: 1,
                        icons: [{
                          icon: lineSymbol,
                          offset: '50%'
                        }],
                        map: map
                });
    		}
    		function getIndexOfTimerArray(deviceid){
    			for(var i=0;i<6;i++){
        			if(timer_array[i]==deviceid){
						return i;
            		}
    			}
        	}
            function refreshMarkerData(i){
				// load the ajax data 
			    // draw on the map and done
				$.ajax({
					  url: '/vts/livetrackerjson/'+timer_array[i],
					  
					  type: 'POST',
					  success: function(data, textStatus, jqXHR){	
						  var device_data = JSON.parse(data);
						  //console.debug(device_data);	
						  var device_record = null;
						  device_record = getDeviceStatusById(device_data.DeviceStatus.deviceid);
						  if(device_data.DeviceStatus.recordEventNumber != device_record.recordEventNumber)
							  {	
							  							  
							  	//updateTrackerInfo();
							  	var icon = getMarkerPinIcon(device_data.DeviceStatus.vehicleSpeed,device_data.DeviceStatus.ignitionStatus);
							  	var dt = {latLng:
									[device_data.DeviceStatus.vehicleLat,device_data.DeviceStatus.vehicleLng], 
									data:device_data.DeviceStatus.nearaddress,
									id: device_data.DeviceStatus.recordEventNumber
								};
								console.debug(device_data.DeviceStatus.recordEventNumber);
								console.debug(device_record.recordEventNumber);
							  	addMarker(dt, device_data.DeviceStatus.deviceid, device_record.recordEventNumber, icon);

							  	device_record.recordEventNumber = device_data.DeviceStatus.recordEventNumber;
							  	device_record.timeDiff = device_data.DeviceStatus.timeDiff;
							  	device_record.serverDateTime = device_data.DeviceStatus.serverDateTime;
							  	device_record.recordDate = device_data.DeviceStatus.recordDate;
							  	device_record.recordTime = device_data.DeviceStatus.recordTime;
							  	device_record.vehicleLat = device_data.DeviceStatus.vehicleLat;
							  	device_record.vehicleLng = device_data.DeviceStatus.vehicleLng;
							  	device_record.nearaddress = device_data.DeviceStatus.nearaddress;
							  	device_record.vehicleAltitude = device_data.DeviceStatus.vehicleAltitude;
							  	device_record.vehicleSpeed = device_data.DeviceStatus.vehicleSpeed;
							  	device_record.ignitionStatus = device_data.DeviceStatus.ignitionStatus;
							  	device_record.vehicleOdometer = device_data.DeviceStatus.vehicleOdometer;
							  	device_record.vehicleFuel = device_data.DeviceStatus.vehicleFuel;

							  	console.debug(device_record.recordEventNumber);
							  	//lastEventNumber = device_data.DeviceStatus.recordEventNumber; 
								//console.debug(device_record); 
						  } 							  
					  },
					  error: function(jqXHR, textStatus, errorThrown){
					  }
					});
			    
            }
            function initMonitoringMap(id){
            	var device_data = getDeviceStatusById(timer_array[id]);
            	//console.debug(device_data
            	$('#'+id+'-map').gmap3('destroy').remove();
          		var mp = '<div id="'+id+'-map" class="gglmap gmap3" style="width: 100%;  overflow: hidden;"></div>';

          		$("#"+id+" .box-body").html(mp);
          		
          		prevMarker[id] = "/vts/img/tracker/marker-" + lbl + "-"+color+".png";

				var v = device_data;
				
				var deviceInfo = getDeviceInfoById(v.deviceid);
				
				var color = getMarkerColor(v.vehicleSpeed, v.ignitionStatus);
				
				var lblCnt = "";
				var lbl = "human";
				if (deviceInfo.DeviceType.name == "PT") {
					lblCnt = deviceInfo.ClientDevice.person_name;
				} else {
					lblCnt = deviceInfo.ClientDevice.registration_number;
					lbl = "car";
				}
				var infodata = getInfoBubbleData(v);
				//var icon = "/vts/img/tracker/marker-" + lbl + "-"+color+".png";
				var data = {
					latLng : [ v.vehicleLat, v.vehicleLng ],
					data : infodata,
					id : v.recordEventNumber,
					 options:{
		            		optimized: false,
			            	icon: "/vts/img/tracker/live-"+lbl+"-pin.gif",
			              	draggable: false
			              	}
										
					};
				
			  	initMap2(id+'-map', data);
          			
          		prevLat[id]=data.latLng[0];
    			prevLng[id]=data.latLng[1];
  				//$('#'+id+'-map').gmap3('get').setCenter(new google.maps.LatLng(data.latLng[0],data.latLng[1]));
    			
    			var vehicleType = "human";
    			var mapTitle = "";
    			var device_profile = getDeviceInfoById(timer_array[id]);
    			if(device_profile.DeviceType.name=="VT"){
    				vehicleType = device_profile.VehicleType.name;
    				mapTitle = device_profile.ClientDevice.deviceid+" :: "+device_profile.ClientDevice.name;
    			}else{
    				mapTitle = device_profile.ClientDevice.deviceid+" :: "+device_profile.ClientDevice.name;
        		}
    			var icon = getVehicleIcon(vehicleType,device_data.vehicleSpeed,device_data.ignitionStatus);
    			$('#'+id+' img').attr('src',"img/tracker/64/"+icon);	
      			$('#'+id+'-icon').attr('src',"img/tracker/64/"+icon);	
      			$('#'+id+'-title').html(mapTitle);	
//      			console.debug(icon);           	
    		}
		function createMapPortlets(sl){
			var v = $(sl).val();
			clearAllMapPortlets();
			// select span
			var span = new Array();
			var hght = "FULL";
			switch(v){
				case "1": span = ["12","0"]; hght = "FULL";break;
				case "2": span = ["6","0"]; hght = "FULL";break;
				case "3": span = ["4","0"]; hght = "FULL";break;
				case "4": span = ["6","6"]; hght = "HALF";break;
				case "5": span = ["4","6"]; hght = "HALF";break;
				case "6": span = ["4","4"]; hght = "HALF";break;
			}
			//console.debug(span);
			for(var i=1;i<=3 && i<=v;i++){
				$("#maps-container").append(getContentForPortal(i,span[0],hght));
				// upper colum 
				
			}
			for(i=4;i<=v;i++){
				$("#maps-container").append(getContentForPortal(i,span[1],hght));
			}
			$( ".map-container" ).droppable({
                drop: function( event, ui ) {
          	    var mrkr = ui.draggable.attr("id");
          		var id = $(this).attr("id");
          		$("#"+id+"-title").html("Map-"+mrkr);
          		if($.timer("timer_"+id).status()=="running"){
					$.timer("timer_"+id).stop();
					//clearAllMarkers(id);
					$('#'+id+'-map').gmap3({action:'clear', name:'marker'});
				}
          		timer_array[id] = mrkr;
          		$.timer('timer_'+id).start();
          		initMonitoringMap(id);
                }
              });
			//APP_COMMON.bindResizeDiv('.FULL .gglmap',120);
		}
		
		function getContentForPortal(id, span, hght){
			var contents = '<div class="span'+span+' '+hght+' map-container" id="'+id+'">'+
							'<div class="box corner-all">'+
								'<div class="box-header grd-white">'+
									'<div class="header-control">'+
										'<img id="'+id+'-icon" width="32" height="32" src="" alt="" />'+
									'</div>'+
									'<span id="'+id+'-title">Map</span>'+
								'</div>'+
								'<div class="box-body">'+
									'<p>Please drag n drop a tracker...</p>'+
								'</div>'+
								'</div>'+
							'</div>';			
			return contents;			
		}
		function clearAllMapPortlets(){
			
			$('#1-map').gmap3('destroy').remove();
			$("#1 .box-body").html('<p>Please drag n drop a tracker...</p>');
			$('#1-icon').attr('src',"");	
  			$('#1-title').html("Map");			
			for(var i=2;i<=6;i++){
            	$('#'+i+'-map').gmap3('destroy').remove();				
				$("#"+i).html("");
			}
			$('#maps-container').html("");
			stopAllTimer();
		}

		function stopAllTimer(){
			for(var i=1;i<=6;i++){
				if($.timer("timer_"+i).status()=="running"){
					$.timer("timer_"+i).stop();
				}
				timer_array[i]="";
			}
		}     
		
						
		function addMarker(data, deviceid, lastEventNumber, icon){
			var i = getIndexOfTimerArray(deviceid);
			//var l = data.length-1;
			var centerLatLng = data.latLng;
			prevMarker[i] = icon;
			$('#'+i+'-map').gmap3({		          
		          marker:{
		        	  latLng: data.latLng,
		        	  data: data.data,
		        	  tag: data.id,
		        	  id: data.id,
		            options:{
		            		optimized: false,
			            	icon: "/vts/img/tracker/live-pin.gif",
			              	draggable: false,
			              	 zoom: 14
			              	},
		            events:{
		             
		              click: function(marker, event, context){
			                var map = $(this).gmap3("get"),
			                  infowindow = $(this).gmap3({get:{name:"infowindow"}});
			                if (infowindow){
			                  infowindow.open(map, marker);
			                  infowindow.setContent(context.data);
			                } else {
			                  $(this).gmap3({
			                    infowindow:{
			                      anchor:marker, 
			                      options:{content: context.data}
			                    }
			                  });
			                }
			              }
		            }
		          }
		        });	
			$('#'+i+'-map').gmap3('get').setCenter(new google.maps.LatLng(centerLatLng[0],centerLatLng[1]));
			// change premarker
			var marker = $('#'+i+'-map').gmap3({get:{name:"marker",tag:lastEventNumber}});
			if(marker)
				marker.setIcon(prevMarker[i]);
			drawLineArwLine2(centerLatLng[0],centerLatLng[1], i);
			prevLat[i]=centerLatLng[0];
			prevLng[i]=centerLatLng[1];
			
			var device_data = getDeviceStatusById(timer_array[i]);
			var vehicleType = "human";
			var device_profile = getDeviceInfoById(timer_array[i]);
			if(device_profile.DeviceType.name=="VT"){
				vehicleType = device_profile.VehicleType.name;
			}			
			var icon = getVehicleIcon(vehicleType,device_data.vehicleSpeed,device_data.ignitionStatus);
  			$('#'+i+'-icon').attr('src',icon);	
		}
		function updateTrackerInfo(){
			/*
			var device_data= this.device_data;
			var icon = getMarkerPinIcon(device_data.DeviceStatus.vehicleSpeed,device_data.DeviceStatus.ignitionStatus);
			var dt = {latLng:
					[device_data.DeviceStatus.vehicleLat,device_data.DeviceStatus.vehicleLng], 
					data:device_data.DeviceStatus.nearaddress,
					id: device_data.DeviceStatus.recordEventNumber
				};
			this.prevMarker = icon;
			this.addMarker(dt);
			if(this.prevLatLong)
				this.drawLineArwLine(dt);
			this.prevLatLong = [device_data.DeviceStatus.vehicleLat,device_data.DeviceStatus.vehicleLng];

			var ticon = getVehicleIcon(this.trackerType,
					device_data.DeviceStatus.vehicleSpeed,device_data.DeviceStatus.ignitionStatus);

			$("#tracker-header-info img[alt=tracker]").attr("src",ticon);
			
			// update the view tracker-odometer  knob-speed
			$("#tracker-odometer").html(device_data.DeviceStatus.vehicleOdometer+" Kms");
			$("#knob-fuel").val(device_data.DeviceStatus.vehicleFuel);
			$("#knob-speed").val(device_data.DeviceStatus.vehicleSpeed);
			if(device_data.DeviceStatus.ignitionStatus=="0"){
				$("#tracker-ignition").html('Ignition: <span class="badge badge-important">Off');
			}else{
				$("#tracker-ignition").html('Ignition: <span class="badge badge-success">On');
			}
			// refresh the msg box
			this.refreshMsgBox(device_data.DeviceStatus.nearaddress);
			// add record to list
			this.addToTrackerHistoryList(ticon, device_data);

			this.lastEventNumber = device_data.DeviceStatus.recordEventNumber;

			// 
			var mst = getMovingStatus(device_data.DeviceStatus.vehicleSpeed,device_data.DeviceStatus.ignitionStatus);
			$("#tracker-moving-status").html(mst);
			*/
		}

		function showLeftTrackerList(){
			if($("#monitor-tracker-list").hasClass("hide")){
				$("#monitor-tracker-list").removeClass("hide");
				$("#maps-container").css("margin-left",-230);
			}else{
				$("#monitor-tracker-list").addClass("hide");
				$("#maps-container").css("margin-left",0);
			}			
		}
        </script>
<style>
.text-red {
	color: red !important;
}

.gglmap img {
	max-width: none !important;
}

.gglmap label {
	width: auto !important;
	display: inline !important;
}

.box>.box-header {
	padding: 10px 5px;
}

#maps-container {
	width: 100%;
	float: left;
}

.map-container {
	float: left;
	margin: 5px 0 0 5px !important;
}

.FULL .gglmap {
	height: 480px;
}

.HALF .gglmap {
	height: 220px;
}

#monitor-tracker-list {
	background-color: #333;
	width: 220px;
	height: 440px;
	right: 0;
	overflow-y: scroll;
	padding: 5px;
}

#monitor-tracker-list ul {
	list-style: none;
	width: 200px;
	margin: 0;
	padding: 0;
}

#monitor-tracker-list ul li {
	display: block;
}

#monitor-tracker-list ul li a {
	line-height: 10px;
	font-size: .9em;
}
</style>
