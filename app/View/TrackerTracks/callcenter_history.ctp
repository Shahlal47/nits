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
						<!-- <select id="selDevices" data-form="select2" style="width: 200px"
							data-placeholder="Please Select A Tracker">
							<option value=""></option>
							<optgroup label="Personal Tracker">
							</optgroup>
							<optgroup label="Vahicle Tracker">
							</optgroup>
						</select>
						 -->
						 <button class="btn btn-success" >
							<span id="dvId"><?php echo $deviceId;?></span>
						</button>
						 <input id="fromDatetime" type="text"
							class="input-medium  form_date" placeholder="From Date-Time"
							data-placement="bottom" rel="tooltip"
							data-original-title="From Date-Time">
							
						 <select id="historyStartTime" type="text"
							class="input-medium"> 
							<option value="00:00 AM"> 00:00 AM</option>
							<option value="01:00 AM"> 01:00 AM</option>
							</select>
							
						 <select id="historyEndiTime" type="text"
							class="input-medium"> 
							<option value="00:00 AM"> 00:00 AM</option>
							<option value="01:00 AM"> 01:00 AM</option>
						 </select>
							
<!-- 							<input id="toDatetime" -->
<!-- 							type="text" class="input-medium  form_datetime" -->
<!-- 							placeholder="To Date-Time" data-placement="bottom" rel="tooltip" -->
<!-- 							data-original-title="To Date-Time"> -->
						<button id="btnShowHistory" class="btn" data-placement="bottom"
							rel="tooltip" data-original-title="Show">
							<i class="icon-search"></i>
						</button>
					</form>
				</header>
				<div id="callcenter_map" class="gMap"
					style="width: 99%; height: 875px;"></div>
				<div id="directions" style="background: white;"></div>
			</div>
		</div>

	</div>

</div>

<script type="text/javascript">

	var VTS_CALL_CENTER = {
		map : null,
		seldeviceid:"",
		poly7 : [],
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
			var centerLatLng = data[data.length - 1].latLng;
			addMarkersInMap("callcenter_map",data);
			setMapCenterOfPoints("callcenter_map",centerLatLng);		
		},
		updateHistoryData : function(data) {
			this.clearMarkers();
			var hsData = data.data;
			
			prevLatLong = null;
			var dt = new Array();
			var icn = "";
			var dataCount = hsData.length;
			for ( var i = 0; i < dataCount; i++) {
				var v = hsData[i];
				var deviceInfo = getDeviceInfoById(this.seldeviceid);
				var color = getMarkerColor(v.vehicleSpeed, v.ignitionStatus);				
				
				var data = MAP_HELPER.getInfoBubbleData(v);
				dt.push({
					latLng : [ v.vehicleLat, v.vehicleLng ],
					data : data,
					options : {
						icon : APP_URL_ROOT + 'img/nits_marker/'+ color
						+ '_32.png'
					}
				});
			}
			
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
			var item;
			var latLng;
			$( dt ).each(function( index ) {
				item=dt[index];
				var path=line.getPath().getArray(),
                latLng=new google.maps.LatLng(item.latLng[0],item.latLng[1]);
                path.push(latLng);
                line.setPath(path);
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
			});
			
			map.setCenter(latLng);
			
		},
		updateTrackerInfo : function() {
			var did = $("#dvId").text().trim();//$("#selDevices").select2("val");
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
			var data = {did: did, ht:"specificDate",sd:sdt[0],st:sdt[1],ed:edt[0],et:edt[1]};
			$('#btnShowHistory').attr('disabled',true);
			APP_HELPER.ajaxSubmitDataCallback(url,$.param(data),function(data){
				$('#btnShowHistory').attr('disabled',false);
				if(data.length<=0){
					alert('No history record found!');
				}else{
					VTS_CALL_CENTER.updateHistoryData(data);
					$('#btnShowHistoryAnimation').attr('disabled',false);
					
				}
			});	
						
		},
		clearMarkers : function() {
			$('#callcenter_map').gmap3('clear', 'markers');
			if(this.poly7 != null && this.poly7.length > 0){
				for ( var i = 0; i < this.poly7.length; i++) {
					this.poly7[i].removeAll();
				}
				this.poly7 = null;
			}
		},
		openAnimationTab : function (){
			var url = APP_COMMON.app_root + 'animations';
			var win = window.open(url);
			win.focus();
			return false;
		},
		focusMarkerById:function(id){		
			var marker = $('#callcenter_map').gmap3({get:{name:"marker",tag:id.toString()}});
			if(marker)					
				google.maps.event.trigger(marker,'click');
		},

		hideMarkerById:function(id){		
			var marker = $('#callcenter_map').gmap3({get:{name:"marker",tag:0}});
			if (infoBubble.isOpen()) {
				infoBubble.close();
			}
		},
		init:function (){

			APP_COMMON.initPage('Tracker History');
			APP_COMMON.bindResizeDiv('#callcenter_map', 0);
			
			//VTS_CALL_CENTER.map = MAP_HELPER.initMap("#callcenter_map", "99%", "875");
			VTS_CALL_CENTER.map = VTS_CALL_CENTER.initMap("#callcenter_map", "99%", "875");

			map = $('#callcenter_map').gmap3('get');
			$('#fromDatetime').datetimepicker('update', new Date());
			$('#toDatetime').datetimepicker('update', new Date());

			$('#btnShowHistory').bind('click',function(event){
				VTS_CALL_CENTER.hideMarkerById();
				$('#callcenter_map').gmap3('clear', 'markers');
				VTS_CALL_CENTER.updateTrackerInfo();
				event.preventDefault();
			});
		},

		initMap : function(dMap, wdth, hght) {
			$(dMap).width(wdth).height(hght).gmap3(
					"autofit",
					{
						defaults : {
							classes : {
								Marker : MarkerWithLabel
							}
						},
						map : {
							options : {
								center : [ 23.789720, 90.376460 ],
								zoom : 7,
								mapTypeId : google.maps.MapTypeId.ROADMAP,
								mapTypeControlOptions : {
									mapTypeIds : [ google.maps.MapTypeId.ROADMAP,
											google.maps.MapTypeId.HYBRID,
											google.maps.MapTypeId.SATELLITE,
											google.maps.MapTypeId.TERRAIN,
											"Highways", "Roads" ]
								},
								//disableDoubleClickZoom: true
							},
							
						},
						directionsrenderer : {
							divId : "directions",
							options : {
								preserveViewport : true,
								markerOptions : {
									visible : false
								}
							}
						},
						styledmaptype : {
							id : "Highways",
							options : {
								name : "Highways"
							},
							styles : [ {
								featureType : "road.highway",
								elementType : "geometry",
								stylers : [ {
									hue : "#ff0022"
								}, {
									saturation : 60
								}, {
									lightness : -20
								} ]
							} ]
						}
					}, {
						styledmaptype : {
							id : "Roads",
							options : {
								name : "Roads"
							},
							styles : [ {
								featureType : "road.highway",
								elementType : "geometry",
								stylers : [ {
									hue : "#ff0022"
								}, {
									saturation : 60
								}, {
									lightness : -20
								} ]
							}, {
								featureType : "road.arterial",
								elementType : "all",
								stylers : [ {
									hue : "#2200ff"
								}, {
									lightness : -40
								}, {
									visibility : "simplified"
								}, {
									saturation : 30
								} ]
							}, {
								featureType : "road.local",
								elementType : "all",
								stylers : [ {
									hue : "#f6ff00"
								}, {
									saturation : 50
								}, {
									gamma : 0.7
								}, {
									visibility : "simplified"
								} ]
							} ]
						}
					});
			var vMap = $(dMap).gmap3('get');
			map = vMap;
			return vMap;
		}

		
	};

	$(function(){	 
		VTS_CALL_CENTER.init();
    });


   
    
</script>
