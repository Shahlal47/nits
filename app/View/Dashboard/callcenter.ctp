<div class="span12">
	<div class="row-fluid">
		<div class="span12">
			<div class="box">
				<!-- <header>
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
						</select> <input id="fromDatetime" type="text"
							class="input-medium  form_datetime" placeholder="From Date-Time"
							data-placement="bottom" rel="tooltip"
							data-original-title="From Date-Time"> <input id="toDatetime"
							type="text" class="input-medium  form_datetime"
							placeholder="To Date-Time" data-placement="bottom" rel="tooltip"
							data-original-title="To Date-Time">
						<button id="btnShowHistory" class="btn" data-placement="bottom"
							rel="tooltip" data-original-title="Show">
							<i class="icon-search"></i>
						</button>
					</form>
				</header>
				 -->
				<div id="callcenter_map" class="gMap"
					style="width: 99%; height: 875px;"></div>
				<div id="directions" style="background: white;"></div>
			</div>
		</div>

	</div>

</div>
<style>
<!--
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
    padding: 4px 6px;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
    vertical-align: middle;
    height: 20px;
    width: 20px;
}
-->
</style>
<script type="text/javascript">
/* Map Starts */

function Gmap3Menu($div) {
var that = this, items = [], ts = null, namespace = "gmap3-menu";

// create an item using a new closure
function create(item) {
	var $item = $("<div class='item " + item.cl + "'>" + item.label
			+ "</div>");
	$item.click(function() {
		if (typeof item.fnc === "function") {
			item.fnc.apply($(this), []);
		}
	});
	// manage mouse over coloration
	$item.hover(function() {
		$(this).addClass("hover");
	}, function() {
		$(this).removeClass("hover");
	});
	return $item;
}
;

function clearTs() {
	if (ts) {
		clearTimeout(ts);
		ts = null;
	}
}
;

function initTs(t) {
	ts = setTimeout(function() {
		that.close();
	}, t);
}
;

this.add = function(label, cl, fnc) {
	items.push({
		label : label,
		fnc : fnc,
		cl : cl
	});
};

// close previous and open a new menu
this.open = function(event) {
	this.close();
	var offset = {
		x : 0,
		y : 0
	}, $menu = $("<div id='" + namespace
			+ "' style='background-color:#FFF;' class='menumapclass'></div>");
	// add items in menu
	$.each(items, function(i, item) {
		$menu.append(create(item));
	});
	// manage auto-close menu on mouse hover / out
	$menu.hover(function() {
		clearTs();
	}, function() {
		initTs(3000);
	});

	// change the offset to get the menu visible (#menu width & height must
	// be defined in CSS to use this simple code)
	if (event.pixel.y + $menu.height() > $div.height()) {
		offset.y = -$menu.height();
	}
	if (event.pixel.x + $menu.width() > $div.width()) {
		offset.x = -$menu.width();
	}
	// use menu as overlay
	$("#callcenter_map").gmap3({
		overlay : {
			latLng : event.latLng,
			options : {
				content : $menu,
				offset : offset
			},
			tag : namespace
		}
	});

	// start auto-close
	initTs(5000);
};

// close the menu
this.close = function() {
	clearTs();
	$(".menumapclass").hide();
	
};
}

var menu = new Gmap3Menu($("#callcenter_map")), current, // current click
														// event (used to
//save as start / end position)
m1, // marker "from"
m2; // marker "to"

//update marker
function updateMarker(marker, isM1) {
if (isM1) {
	m1 = marker;
} else {
	m2 = marker;
}
updateDirections();
}

//add marker and manage which one it is (A, B)
function addMarker(isM1) {
// clear previous marker if set
var clear = {
	name : "marker"
};
if (isM1 && m1) {
	clear.tag = "from";
	$("#callcenter_map").gmap3({
		clear : clear
	});
} else if (!isM1 && m2) {
	clear.tag = "to";
	$("#callcenter_map").gmap3({
		clear : clear
	});
}
// add marker and store it
$("#callcenter_map").gmap3(
		{
			marker : {
				latLng : current.latLng,
				options : {
					draggable : true,
					icon : new google.maps.MarkerImage(
							"http://maps.gstatic.com/mapfiles/icon_green"
									+ (isM1 ? "A" : "B") + ".png")
				},
				tag : (isM1 ? "from" : "to"),
				events : {
					dragend : function(marker) {
						updateMarker(marker, isM1);
					}
				},
				callback : function(marker) {
					updateMarker(marker, isM1);
				}
			}
		});
}

//function called to update direction is m1 and m2 are set
function updateDirections() {
if (!(m1 && m2)) {
	return;
}
$("#callcenter_map").gmap3({
	getroute : {
		options : {
			origin : m1.getPosition(),
			destination : m2.getPosition(),
			travelMode : google.maps.DirectionsTravelMode.DRIVING,
		},
		callback : function(results) {
			if (!results)
				return;
			$("#callcenter_map").gmap3({
				get : "directionrenderer"
			}).setDirections(results);
		}
	}
});
}


//MENU : ITEM 2
menu.add("Direction from here", "itemA separator", function() {
menu.close();
addMarker(true);
});

//MENU : ITEM 1
menu.add("Direction to here", "itemB", function() {
menu.close();
addMarker(false);
});

//MENU : ITEM 3
menu.add("Zoom in", "zoomIn", function() {
var map = $("#callcenter_map").gmap3("get");
map.setZoom(map.getZoom() + 1);
menu.close();
});

//MENU : ITEM 4
menu.add("Zoom out", "zoomOut", function() {
var map = $("#callcenter_map").gmap3("get");
map.setZoom(map.getZoom() - 1);
menu.close();
});

//MENU : ITEM 5
menu.add("Center here", "centerHere", function() {
$("#callcenter_map").gmap3("get").setCenter(current.latLng);
menu.close();
});

/* Map Ends */

	var VTS_CALL_CENTER = {
		map : null,
		seldeviceid:"",
		poly7 : [],
		rightClick : 0,
		// 
		loadTrackersInList : function(devices) {
			//var devices = APP_COMMON.getDeviceProfiles();
			$('#selDevices > optgroup[label="Personal Tracker"]').empty();
			$('#selDevices > optgroup[label="Vahicle Tracker"]').empty();
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
					/*$('#selDevices > optgroup[label="Vahicle Tracker"]').append(
							option);*/
				}
			}
			$('#selDevices').select2();
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
			var centerLatLng = data[data.length - 1].latLng;
			addMarkersInMap("callcenter_map",data);
			setMapCenterOfPoints("callcenter_map",centerLatLng);
			VTS_CALL_CENTER.rightClick = 0;		
		},
		updateHistoryData : function(data) {
			this.clearMarkers();
			var hsData = data.data;

			// this history data should be saved in the cache
			// later use in the animation
			
			prevLatLong = null;
			var dt = new Array();
			var icn = "";
			for ( var i = 0; i < hsData.length; i++) {
				var v = hsData[i];
				var color = getMarkerColor(v.vehicleSpeed, v.ignitionStatus);
				
				var data = MAP_HELPER.getInfoBubbleData2(v);
				dt.push({
					latLng : [ v.vehicleLat, v.vehicleLng ],
					data : data,
					options : {
						icon : APP_URL_ROOT+"img/marker/small/"+VTS_LEFT.selected_device_type + "-"+color+".png"
					}
				});
			}
			lineDrawCleared = false;
			this.addMarkers(dt);
			this.poly7 = new Array();
			this.drawLineArwLines(dt);
		},
		updateTrackerInfo : function() {
			var did = $("#selDevices").select2("val");
			var sdt = $("#fromDatetime").val().split(" ");
			var edt = $("#toDatetime").val().split(" ");
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
								disableDoubleClickZoom: true
							},
							events : {
								rightclick : function(map, event) {
									/*VTS_CALL_CENTER.rightClick = VTS_CALL_CENTER.rightClick + 1;
									if(VTS_CALL_CENTER.rightClick == 1){
										VTS_CALL_CENTER.clearMarkers();
										if (infoBubble.isOpen()) {
											infoBubble.close();
										}
										}*/
									current = event;
									menu.open(current);
								},
								click : function() {
									menu.close();
								},
								dragstart : function() {
									menu.close();
								},
								zoom_changed : function() {
									menu.close();
								}
							}
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
