<div class="span12">
	<div class="row-fluid">
		<div class="span12">
			<div class="box">
				<header>
				<h5 id="history-title">
					<i class="icon-time"></i> Tracker History
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
					</select> 
					<input id="fromDatetime" type="text"
						class="input-medium  form_date" placeholder="From Date-Time"
						data-placement="bottom" rel="tooltip"
						data-original-title="From Date-Time"> 
<!-- 					<input id="toDatetime" -->
<!-- 						type="text" class="input-medium" -->
<!-- 						placeholder="To Date-Time" data-placement="bottom" rel="tooltip" -->
<!-- 						data-original-title="To Date-Time"> -->
					<button id="btnShowHistory" class="btn" data-placement="bottom"
						rel="tooltip" data-original-title="Show">
						<i class="icon-search"></i>
					</button>
					<button id="btnShowHistoryAnimation" class="btn"
						data-placement="bottom" rel="tooltip"
						data-original-title="Animation">
						<i class="icon-play"></i>
					</button>
				</form>
				</header>
				<div id="history_map" class="gMap"></div>
			</div>
		</div>

	</div>

</div>

<script type="text/javascript">
	var VTS_HISTORY = {
		map : null,
		seldeviceid:"",
		poly7 : [],
		// 
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
		drawLineArwLine : function(lat, lng, plat, plng) {
			var pts7 = new Array();

			pts7.push(new google.maps.LatLng(plat, plng));
			pts7.push(new google.maps.LatLng(lat, lng));
			this.poly7.push(new BDCCArrowedPolyline(pts7, "#FF0000", 2, 1, null,
					30, 5, "#0000FF", 2, 1));
		},
		drawLineArwLines : function(data) {
			var platlng = new Array();
			for ( var i = 0; i < data.length; i++) {
				if (i > 0) {
					this.drawLineArwLine(data[i].latLng[0], data[i].latLng[1],
							platlng.latLng[0], platlng.latLng[1]);
				}
				platlng = data[i];
			}
		},
		addMarkers : function(data) {
			//console.debug(data);
			var centerLatLng = data[data.length - 1].latLng;
			addMarkersInMap("history_map",data);
			setMapCenterOfPoints("history_map",centerLatLng);		
			
		},
		updateHistoryData : function(data) {
			this.clearMarkers();
			var hsData = data.data;

			// this history data should be saved in the cache
			// later use in the animation
			
			prevLatLong = null;
			var dt = new Array();
			var icn = "";
			var dataCount = hsData.length;
			for ( var i = 0; i < dataCount; i++) {
				var v = hsData[i];
				var deviceInfo = getDeviceInfoById(this.seldeviceid);
				var color = getMarkerColor(v.vehicleSpeed, v.ignitionStatus);				
				var lblCnt = "";
				var lbl = "human";
				if (deviceInfo.DeviceType.name == "PT") {
					lblCnt = deviceInfo.ClientDevice.name;
				} else {
					lblCnt = deviceInfo.ClientDevice.name;
					lbl = "car";
				}
				var data = MAP_HELPER.getInfoBubbleData(v);
				dt.push({
					latLng : [ v.vehicleLat, v.vehicleLng ],
					data : data,
					options : {
						icon : APP_URL_ROOT + 'img/nits_marker/'+ color
						+ '_32.png'//APP_URL_ROOT+"img/tracker/marker-" + lbl + "-"+color+".png"
					}
				});
			}
			//lineDrawCleared = false;
			//this.addMarkers(dt);
			//this.poly7 = new Array();
			//this.drawLineArwLines(dt);
			
			var line=new google.maps.Polyline(
              {
                map:map,
                icons: [{
                          icon: {
                                  path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
                                  strokeColor:'#0000ff',
                                  fillColor:'#0000ff',
                                  fillOpacity:1
                                },
                          repeat:'100px',
                          path:[]
                       }]
                 });
			
			
			/*for ( var i = 0; i < dt.length; i++) {
				if (i > 0) {
					this.drawLineArwLine(data[i].latLng[0], data[i].latLng[1],
							platlng.latLng[0], platlng.latLng[1]);
				}
				platlng = data[i];
			}*/
			var item;
			$( dt ).each(function( index ) {
				item=dt[index];
				//console.debug(dt[index]);
				var path=line.getPath().getArray(),
                  latLng=new google.maps.LatLng(item.latLng[0],item.latLng[1]);
                  path.push(latLng);
                  line.setPath(path);
				//map.setCenter(latLng);
                //new google.maps.Marker({map:map,position:latLng});
				//putMarkerOnMap("history_map", dt[index]);
				var markerA = new google.maps.Marker({
				  position: latLng,
				  map: map,
				  icon: item.options.icon,
				  data: item.data
				});
				
				google.maps.event.addListener(markerA, 'click', function() {
					
								if (infoBubble.isOpen()) {
									infoBubble.close();
								}
								infoBubble.setContent(this.data);
								infoBubble.open(map, markerA);
				});
				/*$('#history_map').gmap3(
				{
					marker : {
						latLng: item.latLng,
						data: item.data,
						tag: item.id,
						id: item.id,
						options:item.options,
						events : {
							click : function(marker, event, context) {
								var mapp = $(this).gmap3("get");

								if (infoBubble.isOpen()) {
									infoBubble.close();
								}
								infoBubble.setContent(context.data);
								infoBubble.open(mapp, marker);
							}
						}					
					}
				});*/
			});
			
			//setMapCenterOfPoints("history_map", item);
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			// finish here : Masud last modified : 10/7/2014
		},
		updateTrackerInfo : function() {
			var did = $("#selDevices").select2("val");
			var sdt = $("#fromDatetime").val().split(" ");
			var edt = sdt;//$("#toDatetime").val().split(" ");
			if(!did) {
				alert('Please select a tracker!');
				return;
			}
			if(sdt=="") {
				alert('From Date is empty!');
				return;
			}
			if(edt=="") {
				alert('To Date is empty!');
				return;
			}
			this.seldeviceid = did;
			var url = 'histories/getHistoryByDate';
			var input = {did: did, ht:"specificDate",sd:sdt[0],st:sdt[1],ed:edt[0],et:edt[1]};
			$('#btnShowHistory').attr('disabled',true);
			APP_HELPER.ajaxSubmitDataCallback(url,$.param(input),function(data){
				$('#btnShowHistory').attr('disabled',false);
				if(data.length<=0){
					alert('No history record found!');
				}else{
					VTS_HISTORY.updateHistoryData(data);
					JStorageLib.setDeviceHistory(data);
					$('#btnShowHistoryAnimation').attr('disabled',false);
					
				}
			});	
						
		},
		clearMarkers : function() {
			$('#history_map').gmap3('clear', 'markers');
			for ( var i = 0; i < this.poly7.length; i++) {
				this.poly7[i].removeAll();
			}
			this.poly7 = null;
		},
		openAnimationTab : function (){
			var url = APP_COMMON.app_root + 'animations';
			var win = window.open(url);
			win.focus();
			return false;
		},
		init:function (){

			APP_COMMON.initPage('Tracker History');
			APP_COMMON.bindResizeDiv('#history_map',110);
			
			VTS_HISTORY.map = MAP_HELPER.initMap("#history_map");

			map = $('#history_map').gmap3('get');
			 
			VTS_HISTORY.loadTrackersInList();	
						
			$('#fromDatetime').datetimepicker('update', new Date());
			$('#toDatetime').datetimepicker();
			//$("#toDatetime").timerangepicker({pickDate:false});  

			$('#btnShowHistory').bind('click',function(event){
				VTS_HISTORY.updateTrackerInfo();
				event.preventDefault();
			});
			$('#btnShowHistoryAnimation').attr('disabled',true);
			$('#btnShowHistoryAnimation').bind('click',function(event){
				VTS_HISTORY.openAnimationTab();
				event.preventDefault();
			});
		}
	};

	function getDeviceInfoById(id) {
		var deviceProfile = "";
		var devices = APP_COMMON.getDeviceProfiles();
		$.each(devices, function(k, v) {
			if (v.ClientDevice.deviceid == id) {
				deviceProfile = v;
			}
		});
		return deviceProfile;
	}

	$(function(){	 
		VTS_HISTORY.init();
    });
</script>
