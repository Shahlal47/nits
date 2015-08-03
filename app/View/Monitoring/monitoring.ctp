<div class="span12">
	<div class="body in" id="maps-container">
<!-- 
		<div class="span12  map-container" id="1">
			<div class="box dark">
				<header>
				<h5>
					<img id="1-icon" width="32" height="32" src="" alt="" />
				</h5>
				<span id="1-title">Map</span> </header>
				<div class="body">
					<p>Please drag n drop a tracker...</p>
				</div>
			</div>
		</div>
 -->
	</div>
</div>

<script type="text/javascript">
	var VTS_MONITOR = {
			timer_array : new Array(),
			timer_a : new Array(),

			prevLat : new Array(),
			prevLng : new Array(),
			prevMarker : new Array(),
			last_record : new Array(),

			refreshInterval : 10,
			drawLineArwLine2 : function (lat,lng, i){
    			var pts7 = new Array();
    			pts7.push (new google.maps.LatLng(VTS_MONITOR.prevLat[i], VTS_MONITOR.prevLng[i]));
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
    		},
			
			init : function(){
				APP_COMMON.app_root = APP_URL_ROOT;
				$("#selNumOfMaps").bind('change',function(){
					VTS_MONITOR.createMapPortlets(this);
				});				
            	$("#selNumOfMaps").val("0");
            	
        		$.timer('timer_1', function() { 
        			VTS_MONITOR.refreshMarkerData(1);
        		}, VTS_MONITOR.refreshInterval);
        		$.timer('timer_2', function() { 
        			VTS_MONITOR.refreshMarkerData(2);
        		}, VTS_MONITOR.refreshInterval);
        		$.timer('timer_3', function() { 
        			VTS_MONITOR.refreshMarkerData(3);
        		}, VTS_MONITOR.refreshInterval);
        		$.timer('timer_4', function() { 
        			VTS_MONITOR.refreshMarkerData(4);
        		}, VTS_MONITOR.refreshInterval);
        		$.timer('timer_5', function() { 
        			VTS_MONITOR.refreshMarkerData(5);
        		}, VTS_MONITOR.refreshInterval);
        		$.timer('timer_6', function() { 
        			VTS_MONITOR.refreshMarkerData(6);
        		}, VTS_MONITOR.refreshInterval);
        		
			},
			getIndexOfTimerArray : function (deviceid){
    			for(var i=0;i<6;i++){
        			if(VTS_MONITOR.timer_array[i]==deviceid){
						return i;
            		}
    			}
        	},
        	getLastRecord : function (deviceid){
    			for(var i=0;i<6;i++){
        			if(VTS_MONITOR.last_record[i] && VTS_MONITOR.last_record[i].deviceid==deviceid){
						return VTS_MONITOR.last_record[i];
            		}
    			}
    			return null;
        	},
        	refreshMarkerData : function (id){
        		console.debug(id, VTS_MONITOR.timer_array[id]);
    			APP_COMMON.loadUserDeviceStatusByDid(VTS_MONITOR.timer_array[id],function(){

    				var device_record = APP_COMMON.getDeviceStatusByDeviceid(VTS_MONITOR.timer_array[id]);
    				
    				var lastrecord = VTS_MONITOR.getLastRecord(VTS_MONITOR.timer_array[id]);

    				if(lastrecord==null){
						lastrecord = device_record;
						VTS_MONITOR.last_record[id] = device_record;
    				}
    				
				  	if(lastrecord && lastrecord.recordEventNumber != device_record.recordEventNumber){						  							  

						VTS_MONITOR.changePreviousMarker(id, lastrecord);
					  	
					  	VTS_MONITOR.addMarker(device_record);
					  	
					  	VTS_MONITOR.last_record[id] = device_record;
				  	} 	
        		});
    		},
    		changePreviousMarker : function(id, lastrecord){
			  	var p_icon = MAP_HELPER.getMarkerPinIcon(lastrecord.vehicleSpeed,lastrecord.ignitionStatus);
				var marker = $('#'+id+'-map').gmap3({get:{name:"marker",tag:lastrecord.recordEventNumber}});
				if(marker)
					marker.setIcon(p_icon);					
        	},
        	addMarker : function (device_record){
            	
    			var id = VTS_MONITOR.getIndexOfTimerArray(device_record.deviceid);

    			var device_profile = APP_COMMON.getDeviceProfileByDeviceid(VTS_MONITOR.timer_array[id]);
    			
    			var icon = MAP_HELPER.getLiveMarker(device_profile.DeviceType.name);

				
				var infodata = MAP_HELPER.getInfoBubbleData(device_record);
				
    			$('#'+id+'-map').gmap3({		          
    		          marker:{
    		        	  latLng: [device_record.vehicleLat,device_record.vehicleLng],
    		        	  data: infodata,
    		        	  tag: device_record.recordEventNumber,
    		        	  id: device_record.recordEventNumber,
    		            options:{
    		            		optimized: false,
    			            	icon: icon,
    			              	draggable: false,
    			              	 zoom: 14
    			              	},
    		            events:{
    		             
    		              click: function(marker, event, context){
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
		        
    			var centerLatLng = [device_record.vehicleLat,device_record.vehicleLng];
    			
    			$('#'+id+'-map').gmap3('get').setCenter(new google.maps.LatLng(centerLatLng[0],centerLatLng[1]));

    			VTS_MONITOR.drawLineArwLine2(centerLatLng[0],centerLatLng[1], id);

    			VTS_MONITOR.prevLat[id]=centerLatLng[0];
    			VTS_MONITOR.prevLng[id]=centerLatLng[1];
    			
    			VTS_MONITOR.changeTrackerImg(id, device_record);
    		},
    		changeTrackerImg : function(id, data){
    			var device_profile = APP_COMMON.getDeviceProfileByDeviceid(data.deviceid);
    			var vehicleType = "human";
    			if(device_profile.DeviceType.name=="VT"){
    				vehicleType = device_profile.VehicleType.name;
    			}			
    			var icon = MAP_HELPER.getTrackerImg("small",vehicleType,data.vehicleSpeed,data.ignitionStatus);
      			$('#'+id+'-icon').attr('src',icon);
      			$('#'+data.deviceid+' img').attr('src',icon);
        	},
        	initMonitoringMap : function (id){

    			var device_profile = APP_COMMON.getDeviceProfileByDeviceid(VTS_MONITOR.timer_array[id]);
            	
            	var v = APP_COMMON.getDeviceStatusByDeviceid(VTS_MONITOR.timer_array[id]);

            	$('#'+id+'-map').gmap3('destroy').remove();
            	// generate map div
          		var mp = '<div id="'+id+'-map" class="gglmap gmap3" style="width: 100%;  overflow: hidden;"></div>';
				// add to map boday
          		$("#"+id+" .body").html(mp);
          		
				var infodata = MAP_HELPER.getInfoBubbleData(v);
				var color = getMarkerColor(v.vehicleSpeed, v.ignitionStatus);
				
    			var icon = APP_URL_ROOT + 'img/nits_marker/'+ color+ '_32.png';//MAP_HELPER.getLiveMarker(device_profile.DeviceType.name);
				
				var data = {
					latLng : [ v.vehicleLat, v.vehicleLng ],
					data : infodata,
					id : v.recordEventNumber,
					 options:{
		            		optimized: false,
			            	icon: icon,
			              	draggable: false
			              	}										
					};
				
			  	MAP_HELPER.initMap2('#'+id+'-map', data);

  				$('#'+id+'-map').gmap3('get').setCenter(new google.maps.LatLng(v.vehicleLat, v.vehicleLng));    			
          			
			  	VTS_MONITOR.prevLat[id]=v.vehicleLat;
			  	VTS_MONITOR.prevLng[id]= v.vehicleLng;
    			
    			VTS_MONITOR.setMapTitle(id,device_profile.ClientDevice.name);
      				
      			VTS_MONITOR.changeTrackerImg(id, v);
    		},
    		
    		setMapTitle : function(id,title){
      			$('#'+id+'-title').html(title);
        	},
        	
    		createMapPortlets : function (sl){
				var v = $(sl).val();
				VTS_MONITOR.clearAllMapPortlets();
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
					$("#maps-container").append(VTS_MONITOR.getContentForPortal(i,span[0],hght));
					// upper colum 
					
				}
				for(i=4;i<=v;i++){
					$("#maps-container").append(VTS_MONITOR.getContentForPortal(i,span[1],hght));
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
	          		VTS_MONITOR.timer_array[id] = mrkr;
	          		
	          		$.timer('timer_'+id).start();
	          		VTS_MONITOR.initMonitoringMap(id);
	          		
	                }
	              });
				//console.debug(VTS_MONITOR.timer_array);
				APP_COMMON.bindResizeDiv('.FULL .gglmap',120);
			},
			getContentForPortal : function (id, span, hght){
				var contents = '<div class="span'+span+' '+hght+' map-container" id="'+id+'">'+
							'<div class="box dark">'+
								'<header>'+
									'<h5>'+
										'<img id="'+id+'-icon" width="" height="" src="" alt="" />'+
										'&nbsp;&nbsp;<span id="'+id+'-title" class="badge badge-important">Map</span>'+
									'</h5>'+									
								'</header>'+
								'<div class="body">'+
									'<p>Please drag n drop a tracker...</p>'+
								'</div>'+
								'</div>'+
							'</div>';			
			return contents;			
		},

		clearAllMapPortlets : function (){
			
			$('#1-map').gmap3('destroy').remove();
			$("#1 .box-body").html('<p>Please drag n drop a tracker...</p>');
			$('#1-icon').attr('src',"");	
  			$('#1-title').html("Map");			
			for(var i=2;i<=6;i++){
            	$('#'+i+'-map').gmap3('destroy').remove();				
				$("#"+i).html("");
			}
			$('#maps-container').html("");
			VTS_MONITOR.stopAllTimer();
		},

		stopAllTimer : function (){
			for(var i=1;i<=6;i++){
				if($.timer("timer_"+i).status()=="running"){
					$.timer("timer_"+i).stop();
				}
				VTS_MONITOR.timer_array[i]="";
			}
		}
	};
	
    $(document).ready(function() {
    	APP_COMMON.initPage('Monitoring');
    	VTS_MONITOR.init();
    	
    });

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
	width: 99%;
	float: left;
}

.map-container {
	z-index: 1;
	margin: 0 5px!important;
}
.map-container > .box > .body{
	padding: 0!important;
}

.FULL .gglmap {
	height: 570px;
}

.HALF .gglmap {
	height: 260px;
}
.box header h5{
	margin: 0 0 0 5px;
}

</style>
