<?php

?>

<div id="modal-place-holder">
	<?php //echo $this->element('Dashboard/tracker_info');?>	
</div>

<div class="span12" style="margin: 0; padding: 0;">
	<div class="row-fluid">
		<div class="span12">
			<div class="box">
				<header>
					<!-- <h5><i class="icon-map-marker"></i> Tracking Summary</h5>
				<div class="" style="margin: 5px 0 0 20px; float: left">
					<div class="btn-group">					
						<a href="javascript:;" id="btnToggleCluster" data-toggle="buttons-checkbox"
							data-placement="bottom" data-original-title="Toggle Cluster"
							rel="tooltip" class="btn btn-metis-6"> <i class="icon-asterisk"></i>
						</a>
					</div>
				</div>
				<div class="pull-right" style="padding: 0 0px;width: 180px;">
					<h5 style="margin:5px 0;padding:0;">Total Trackers : <span style="font-size:1.5em; padding: 5px;" class="label btn-metis-6" id="totalTrackers">2</span></h5> 
				</div>-->
					<h5 id="history-title">
						<i class="icon-time"></i> Tracker Eye
					</h5>
					<form class="form-inline"
						style="margin: 0; padding: 5px 10px; float: left;">
						<select id="selDevices" data-form="select2" style="width: 200px"
							data-placeholder="Please Select A Tracker">
							<option value=""></option>
							<optgroup label="Personal Tracker">
							</optgroup>
							<optgroup label="Vahicle Tracker">
							</optgroup>
						</select> <input id="fromDatetime" type="text"
							class="input-medium  form_date" placeholder="From Date-Time"
							data-placement="bottom" rel="tooltip" value=""
							data-original-title="From Date-Time">
						<button id="btnShowHistory" class="btn" data-placement="bottom"
							rel="tooltip" data-original-title="Show">
							<i class="icon-search"></i>
						</button>
					</form>
				</header>
				<div id="live-tracking-map" class="gMap"
					style="width: 79%; margin: 0; padding-left: 0; float: left;"></div>


				<div class="body"
					style="height:800px;overflow-x:scroll ; overflow-y: scroll;padding: 0; float: left; width: 20%; background-color: white; margin-left: 10px; padding: 0;">
					<div id="live-tracker-info" class="tab-pane active">
						<p style="font-weight: bold;font-size: 1.1em;color:grey;">&nbsp; <i class="icon-picture"></i>&nbsp;&nbsp;<a href="#" id="tracker_eye_images">Tracker Images : <span id="image_count"></span></a></p>
						<hr>
						<ul style="margin:0px;width: 100%;background-color: white;list-style: none;" class="" id="trackereye-list">
							
						</ul>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>


<style>
#tracker-list {
	min-height: 300px;
	overflow-y: scroll;
	padding: 5px 0 0 5px;
}

.tracker {
	margin: 0;
}

.tracker tr {
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

#tracker-list tr {
	display: block;
	margin: 2px 0;
	padding: 0;
	float: left;
	width: 98%;
	height: 38px;
}

#tracker-list tr td {
	padding: 4px 10px;
}

.lnkTracker {
	color: #000;
	font-size: .8em;
	/*display: block;
	float: left;
	font-weight: bold;
	
	text-decoration: none;
	
	height: 38px;
	
	text-align: center;*/
}

.lnkTracker:hover {
	text-decoration: none;
}

.lnkTracker span {
	/*   height: 30px;
    text-align: center;
    vertical-align: sub;
    width: 90px;
    float: left;
    font-size: .9em;
    line-height: 1.3em;
    margin-top: 5px; */
	
}

.lnkTracker img {
	margin: 0;
	padding: 0;
	float: left;
	/* 	width: 32px; */
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
	box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px
		rgba(0, 0, 0, 0.05);
	color: #333333;
	cursor: pointer;
	display: inline-block;
	font-size: 14px;
	line-height: 17px;
	margin-bottom: 0;
	padding: 4px 6px;
	text-align: center;
	text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
	vertical-align: middle;
	height: 20px;
	width: 20px;
}

.tracker-btn {
	/*  border-radius: 0px 4px 4px 0px;
    float: right;
    margin: 2px;*/
	
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

	var VTS_TRACKING_EYE = {
			map : null,
			seldeviceid:"",
			poly7 : [],
			markerArrays :[],
			markerAddresses :[],
			markerImages :[],
			address :"",			
			line :[],

			
			clearMarkers : function() {
				$.each(VTS_TRACKING_EYE.markerArrays, function(index, val) {
				    val.setMap(null);
				});
				/*for (i=0; i<VTS_TRACKING_EYE.line.length; i++) 
				{                           
					VTS_TRACKING_EYE.line[i].setMap(null); 
				}*/
			},
			
			openAnimationTab : function (){
				var url = APP_COMMON.app_root + 'animations';
				var win = window.open(url);
				win.focus();
				return false;
			},
			loadTrackersInList : function() {
				var devices = APP_COMMON.getDeviceProfiles();
				for ( var i = 0; i < devices.length; i++) {
					var v = devices[i];
					if (v.DeviceType.name == "PT") {
						var option = '<option value="' + v.ClientDevice.deviceid
								+ '">' + v.ClientDevice.name + '</option>';
						$('#selDevices > optgroup[label="Personal Tracker"]').append(
								option);
					} else {
						var option = '<option value="' + v.ClientDevice.deviceid
								+ '">' + v.ClientDevice.name
								+ '</option>';
						$('#selDevices > optgroup[label="Vahicle Tracker"]').append(
								option);
					}
				}
				
				$('#selDevices').select2();

				if(devices.length > 0){
					$("#selDevices").select2('val', devices[0].ClientDevice.deviceid);
					}
			},
			
			createTrackerList : function(sDate){
				    VTS_TRACKING_EYE.clearMarkers();
					var did = $("#selDevices").select2("val");
					this.seldeviceid = did;
					$('#trackereye-list').html('');
					var str = '';
					VTS_TRACKING_EYE.markerAddresses = [];
					VTS_TRACKING_EYE.markerImages = [];
					$("#trackereye-list").hide();
					
					APP_HELPER.ajaxSubmitDataCallback('trackerEyes/getImageList',{'sdate':sDate,'deviceid':this.seldeviceid},function(data){
						if(data.length > 0){
						$("#image_count").text("( "+data.length+" )");
						var i = 0;
						$.each(data, function(index){
							 VTS_TRACKING_EYE.markerImages.push(data[index].image);
							 var time = data[index].time;
							 //alert(time);
							 var timeStr = "'"+time+"'";
							 str += '<li style="text-align:center;margin:10px;border:1px solid grey;" onclick="VTS_TRACKING_EYE.focusMarkerByLatLng('+data[index].lat+','+data[index].lng+', '+index+', '+timeStr+');" class="image-ul" id="image-ul-'+index+'">';
							 str += '<img width="500" height="500" src="'+data[index].image+'">';
							 str += '<br/>';
							 str += '<div style="background-color:#468847;text-align:center;margin:10px;color:white;font-weight:bold;"><span id="image_name_'+index+'"></span></div>';
							 str += '</li>';
							 i++;
							});
						
						$('#trackereye-list').append(str);
						
						}
						else{
							$("#image_count").text("(0)");
							$('#trackereye-list').html('<li style="text-align:center;margin:10px;border:1px solid grey;color:red;">No Image Found !!!</li>');
							}
						});
				},
			
			focusMarkerByLatLng:function(lat,lng,index, time){
				$(".image-ul").css("background-color","white"); 
				$("#image-ul-"+index).css("background-color","grey"); 

				var geocoder = new google.maps.Geocoder();
				geocoder.geocode({ 'latLng': new google.maps.LatLng(lat,lng) }, function(results, status){
					VTS_TRACKING_EYE.markerAddresses['image_name_'+index] = results[0].formatted_address;
					$("#image_name_"+index).html(results[0].formatted_address);
				});

				VTS_TRACKING_EYE.clearMarkers();
				latLng=new google.maps.LatLng(lat,lng);
				if (infoBubble.isOpen()) {
					infoBubble.close();
				}
				var marker = new google.maps.Marker({
	                position:latLng,
	                map: VTS_TRACKING_EYE.map,
	                  draggable:true,
	                  animation: google.maps.Animation.DROP,
	              icon: "http://maps.google.com/mapfiles/ms/micons/blue.png",
	            }); 
				VTS_TRACKING_EYE.markerArrays.push(marker);
				
				google.maps.event.addListener(marker, 'click', function() {
					
					if (infoBubble.isOpen()) {
						infoBubble.close();
					}
					var geocoder = new google.maps.Geocoder();
					geocoder.geocode({ 'latLng': new google.maps.LatLng(lat,lng) }, function(results, status){
						var contentString = '<div class="tracker-info-box" style="width: 400px;">'
							+ '<div style="font-size:.8em;width: 96%;height: 300px; float:left;padding: 10px; background-color:#D9EDF7;box-shadow:inset 0 0 5px #3A87AD;-moz-border-radius: 5px;border-radius: 5px;">'
							+ '<table ><tbody>'
							+ '<tr><td colspan="2"><img width="380" height="400" src="'+VTS_TRACKING_EYE.markerImages[index]+'"></td></tr>'
							+ '<tr><td style="width:50%;padding:5px;"><b>Time : </b></td><td>'
							+ time
							+ '</td></tr>'
							+ '</tbody>'
							+ '</table>'
							+ '</div>'
							+ '<div style="font-size:.9em;width: 400px; float:left;padding: 10px; background-color:#D9EDF7;box-shadow:inset 0 0 5px #3A87AD;-moz-border-radius: 5px;border-radius: 5px;">'
							+ results[0].formatted_address + '</div></div>';
			    		 var infoBubble = new google.maps.InfoWindow({
			              content: contentString,
			              maxWidth: 400
			        	  });
			        	  
			    		 infoBubble.open(VTS_TRACKING_EYE.map, marker);
					});
					
				});

				
				//google.maps.event.trigger(marker, 'click');
					
			},
			init: function(){

					VTS_TRACKING_EYE.loadTrackersInList();
					// initTrackerList
					var devices = APP_COMMON.getDeviceProfiles();

					APP_COMMON.initPage('Tracker History');
					APP_COMMON.bindResizeDiv('#live-tracking-map',110);
					
					VTS_TRACKING_EYE.map = MAP_HELPER.initMap("#live-tracking-map");

					map = $('#live-tracking-map').gmap3('get');
		
								
					$('#fromDatetime').datetimepicker('update', new Date());
					$('#toDatetime').datetimepicker();
					//$("#toDatetime").timerangepicker({pickDate:false});  

					$('#btnShowHistory').bind('click',function(event){
						var sdt = $("#fromDatetime").val().split(" ");
						VTS_TRACKING_EYE.createTrackerList(sdt[0]);
						event.preventDefault();
					});
					
					$('#tracker_eye_images').bind('click',function(event){
						$("#trackereye-list").show();

						$.each(VTS_TRACKING_EYE.markerAddresses, function(index, value) {
						    $("#image_name_"+index).html(value);
						});
						event.preventDefault();
					});
					$("#trackereye-list").hide();
				}
					
	};
	
	$(function(){		
		VTS_TRACKING_EYE.init();
    });



</script>
