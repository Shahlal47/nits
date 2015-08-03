<div class="content">
	<!-- content-header -->
	<div class="content-header" style="height: 20px;padding:5px 20px 15px;">
		<ul class="content-header-action pull-right" style="height: 20px;">

			<li><a id="btn-live-view" class="btn" href="#"
				onclick="toggleCluster(this); return false;"
				data-toggle="buttons-checkbox"><i class="icon-th"></i>
			</a></li>
<!-- 
			<li><a class="btn" href="#"><i class="icofont-refresh"></i>
			</a></li>

			<li><a class="btn" href="#"><i class="icofont-fullscreen"></i>
			</a></li> -->
		</ul>
		<h2 style="line-height:20px;">
			<i class="icofont-map-marker"></i>Live Tracker View
		</h2>

	</div>
	<!-- /content-header -->

	<!-- content-body -->
	<div class="content-body" style="padding: 0 0 0 10px;">
		<!-- form -->
		<div class="row-fluid">
			<div class="span12">
				<div id="live_view_map" style="width: 100%; height: 560px;"></div>
			</div>
		</div>
	</div>
</div>

<?php echo $this->Html->script(
array(
                      'lib/BdccArrowedPolyline',
                      'lib/markerwithlabel',
                      'lib/gmap3.min',
                      'lib/jquery.timer.js'
                      ));
                      ?>
<script type="text/javascript">
	var map;        
	var VTS_DASHBOARD={
		device_data:null,
		map: null,
		prevLatLong:null,
		getTrackerInfo:function(deviceid){
			var tracker;
			$.each(this.device_data, function(index, device) {
				  if(device.deviceid==deviceid){
					tracker = device;
					return false;
				  }
			});
			return device;
		},
		getTrackerIcon:function(device){
			var tcol = "";
			if(device.ignitionStatus == "on" && device.vehicleSpeed>0){
				tcol = "grn";	
			}else if(device.ignitionStatus == "on" && device.vehicleSpeed==0){
				tcol = "org";	
			}else if(device.ignitionStatus == "off"){
				tcol = "red";	
			}			 
			return "img/tracker/64/"+device.trackerType+"-"+tcol+".png";
		},
		updateTrackInfoList:function(){
			// empty the list
			$.each(this.device_data, function(index, device) {
				// update icon, position and driver
				$("#li-"+device.deviceid+" .v-icon").attr("src",this.getTrackerIcon(device));
				$("#li-"+device.deviceid+" .v-position").html(device.vahiclePosition);
				$("#li-"+device.deviceid+" .v-driver").html(device.vahicleDriver);					  
			});
			
		},
		startLiveViewTimer:function(){
			$("#btn-live-view").addClass("btn-warning");
			$.timer('update_all_trackers').start();
		},
		toggleLiveViewTimer: function(v){
			var t = $(v).hasClass("active");
			if(t){
				this.stopLiveViewTimer();
			}else{
				this.startLiveViewTimer();
			}
		},
		showHistoryOnLiveView:function(){
		},
		stopLiveViewTimer:function(){
			$("#btn-live-view").removeClass("btn-warning");
			$.timer('update_all_trackers').stop();
		},
		setMapCenter:function(lat,lng){
			$('#live_view_map').gmap3('get').setCenter(new google.maps.LatLng(lat,lng));
		},
		updateLiveView:function(lat, lng){
			this.setMapCenter(lat,lng);
			if(this.prevLatLong==null){
				this.addMarkerOnLiveView(lat, lng);
			}else if(this.prevLatLong[0]==lat && this.prevLatLong[1]==lng){
				// only update marker info
				
			}else{
				this.drawLineArwLine1(lat, lng);
				this.addMarkerOnLiveView(lat, lng);
			}
			this.prevLatLong = [lat, lng];
		},			
		addMarkerOnLiveView:function(lat, lng, deviceid){
			
			$('#live_view_map').gmap3({
		          
		          marker:{
		        	latLng: [lat, lng],
		            options:{
		              //labelContent: "$425K",
		              labelAnchor: new google.maps.Point(-12, 20),
		              labelClass: "labels",
		              //labelStyle: {opacity: 0.75},
		              labelContent: deviceid,
					  //draggable:true,
					  icon: "img/tracker/marker-tag-blue.png"
		            }
		          }
		        });
	        
		},
		updateTrackerInfo:function(){
			$.ajax({
				  url: 'http://localhost/vts/trackerInfo/get_devices_info?tbldeviceid=d20130004',
				  
				  type: 'POST',
				  success: function(data, textStatus, jqXHR){	
					  var device_data = JSON.parse(data);	
					  //VTS_LIVE.setMapCenter(23.684774,90.351563); 
					  //console.debug(device_data[0].vehicleLat+device_data[0].vehicleLng+device_data[0].deviceid);
					  VTS_DASHBOARD.addMarkerOnLiveView(device_data[0].vehicleLat,device_data[0].vehicleLng,device_data[0].deviceid);
					  VTS_DASHBOARD.addMarkerOnLiveView(device_data[1].vehicleLat,device_data[1].vehicleLng,device_data[1].deviceid);
					  VTS_DASHBOARD.addMarkerOnLiveView(device_data[2].vehicleLat,device_data[2].vehicleLng,device_data[2].deviceid);
					  VTS_DASHBOARD.addMarkerOnLiveView(device_data[3].vehicleLat,device_data[3].vehicleLng,device_data[3].deviceid);
				  },
				  error: function(jqXHR, textStatus, errorThrown){
				  }
				});
		}
	};
	
	
	$(document).ready(function(){
		/*		
		$.timer('update_all_trackers', function() { 
			VTS_DASHBOARD.updateTrackerInfo();
		}, 10);
		$("#live_view_map").gmap3({
			defaults:{ 
	            classes:{
	              Marker:MarkerWithLabel
	            }
	          },
				map:{
		            options:{
			          canter: new google.maps.LatLng(23.684774,90.351563),    			              
		              zoom: 7
		            }
		          }
		});
		VTS_DASHBOARD.setMapCenter(23.684774,90.351563);
		map = $('#live_view_map').gmap3('get');
		*/
	});
</script>
<style>
.text-red {
	color: red !important;
}

#live_view_map img {
	max-width: none;
}

#live_view_map label {
	width: auto;
	display: inline;
}

.label-red {
       color: #fff;
       background-color: #d11001; /*#d33e3e, #75c200*/
       font-family: "Lucida Grande", "Arial", sans-serif;
       font-size: 11px;
       font-weight: bold;
       text-align: left;
            
       /*border: 2px solid black;*/
	   padding: 3px 3px 3px 0;
       white-space: nowrap;
	   border-radius: 0px 4px 4px 0px;
     }
      .label-ash {
       color: #fff;
       background-color: #a4b6c8; /*#d33e3e, #75c200*/
       font-family: "Lucida Grande", "Arial", sans-serif;
       font-size: 11px;
       font-weight: bold;
       text-align: left;
            
       /*border: 2px solid black;*/
	   padding: 3px 3px 3px 0;
       white-space: nowrap;
	   border-radius: 0px 4px 4px 0px;
     }
      .label-grn {
       color: #fff;
       background-color: #345b09; /*#d33e3e, #75c200*/
       font-family: "Lucida Grande", "Arial", sans-serif;
       font-size: 11px;
       font-weight: bold;
       text-align: left;
            
       /*border: 2px solid black;*/
	   padding: 3px 3px 3px 0;
       white-space: nowrap;
	   border-radius: 0px 4px 4px 0px;
     }
      .label-blu {
       color: #fff;
       background-color: #498af3; /*#d33e3e, #75c200*/
       font-family: "Lucida Grande", "Arial", sans-serif;
       font-size: 11px;
       font-weight: bold;
       text-align: left;
            
       /*border: 2px solid black;*/
	   padding: 3px 3px 3px 0;
       white-space: nowrap;
	   border-radius: 0px 4px 4px 0px;
     }
	 .label-org {
       color: #fff;
       background-color: #ff6600; /*#d33e3e, #75c200*/
       font-family: "Lucida Grande", "Arial", sans-serif;
       font-size: 11px;
       font-weight: bold;
       text-align: left;
            
       /*border: 2px solid black;*/
	   padding: 3px 3px 3px 0;
       white-space: nowrap;
	   border-radius: 0px 4px 4px 0px;
     }
</style>
