var VTS_GROUP_Obometer;
var VTS_GROUP_Gauge_Speed;
var VTS_GROUP_Gauge_Fule;

$(document).ready(function() {

	// $('#myTab a:last').tab('show');
	$('#myTab a').click(function(e) {
		e.preventDefault();
		$(this).tab('show');
	});
	// $("input[data-chart=knob]").knob();
	//$(".knob").knob();
	$('#d-tracker-list a.ll').click(function(e) {
		e.preventDefault();
		if ($(this).parent().hasClass('active')) {
			// remove marker of device from the map
			$(this).parent().removeClass('active');
		} else {
			$(this).parent().addClass('active');
			// add marker of device from the map
		}

	});
	$('#drp-dwn').dropdown();
	$('.shw').tooltip();

	$("#numberOfDevices").html(VTS_GROUP_device_profiles.length);
	addTrackersInList();

	loadClusterDataOnMap("group_cluster_map");
	
	initSensorUI();
	//createLiveTrackerTimers();
});
function initSensorUI(){
	VTS_GROUP_Gauge_Fule = new jGauge(); // Create a new jGauge.
	VTS_GROUP_Gauge_Fule.id = 'live-gauge-fuel'; // Link the new jGauge to the placeholder DIV.
	//demoGauge1.label.suffix = 'B'; // Make the value label bytes.
	//demoGauge1.autoPrefix = autoPrefix.binary; // Use binary prefixing (i.e. 1k = 1024).
	//demoGauge1.ticks.count = 5;
	//demoGauge1.ticks.end = 8;

	VTS_GROUP_Gauge_Speed = new jGauge(); // Create a new jGauge.
	VTS_GROUP_Gauge_Speed.id = 'live-gauge-speed'; // Link the new jGauge to the placeholder DIV.
	VTS_GROUP_Gauge_Speed.autoPrefix = autoPrefix.si; // Use SI prefixing (i.e. 1k = 1000).
	VTS_GROUP_Gauge_Speed.imagePath = VTS_URL_ROOT+'img/jgauge_face_taco.png';
	VTS_GROUP_Gauge_Speed.segmentStart = -225;
	VTS_GROUP_Gauge_Speed.segmentEnd = 45;
	VTS_GROUP_Gauge_Speed.width = 170;
	VTS_GROUP_Gauge_Speed.height = 170;
	VTS_GROUP_Gauge_Speed.needle.imagePath = VTS_URL_ROOT+'img/jgauge_needle_taco.png';
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
                    
	VTS_GROUP_Gauge_Fule.init();
	VTS_GROUP_Gauge_Speed.init();
	
	VTS_GROUP_Obometer = $('#live-odometer').jOdometer({spaceNumbers: 2, increment: 1, counterStart:'000000000000', numbersImage: '/vts/img/jodometer-numbers.png', spaceNumbers: 1, offsetRight:-1});
	var vl = zeroFill( 0, 10 );
	VTS_GROUP_Obometer.goToNumber(vl);
	
}
function loadClusterDataOnMap(dMap) {
	var dt = new Array();
	$.each(VTS_GROUP_device_status, function(k, v) {
		// console.debug(v.vehicleLat+" "+v.vehicleLng+" "+v.nearaddress);

		// var icn = getMarkerPinIcon(v.vehicleSpeed,v.ignitionStatus);

		// labelStyle: {opacity: 0.75},
		var color = getMarkerColor(v.vehicleSpeed, v.ignitionStatus);
		var deviceInfo = getDeviceInfoById(v.deviceid);
		var lblCnt = "";
		var lbl = "human";
		if (deviceInfo.DeviceType.name == "PT") {
			lblCnt = deviceInfo.ClientDevice.name;
		} else {
			lblCnt = deviceInfo.ClientDevice.name;
			lbl = "car";
		}
		var l = lblCnt.length * 15 / 4;
		// console.debug(l);
		var data = getInfoBubbleData(v);
		dt.push({
			latLng : [ v.vehicleLat, v.vehicleLng ],
			data : data,
			id : k,
			tag : k,
			options : {
				labelAnchor : new google.maps.Point(l, 10),
				labelClass : "label-number-plate",
				labelContent : lblCnt,
				draggable : false,
				icon : VTS_URL_ROOT+"img/tracker/marker-" + lbl + "-" + color + ".png"
			}
		});
	});

	// init the map and create a cluster with some markers
	$('#' + dMap)
			.gmap3(
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
									mapTypeIds : [
											google.maps.MapTypeId.ROADMAP,
											google.maps.MapTypeId.HYBRID,
											google.maps.MapTypeId.SATELLITE,
											google.maps.MapTypeId.TERRAIN,
											"Highways", "Roads" ]
								}
							}
						},
						marker : {
							values : dt,
							cluster : {
								radius : 100,
								0 : {
									content : '<div class="cluster cluster-1">CLUSTER_COUNT</div>',
									width : 53,
									height : 52
								},
								5 : {
									content : '<div class="cluster cluster-2">CLUSTER_COUNT</div>',
									width : 56,
									height : 55
								},
								10 : {
									content : '<div class="cluster cluster-3">CLUSTER_COUNT</div>',
									width : 66,
									height : 65
								}
							},
							options : {
								draggable : false
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
}

function createNewMarkerAddInCluster(dMap, deviceInfo, deviceStatus, clusterer) {
	var id = deviceInfo.ClientDevice.deviceid;
	clusterer.clearById(id);
	$('#' + dMap).gmap3({
		marker : {
			latLng : [ deviceStatus.vehicleLat, deviceStatus.vehicleLng ],
			data : deviceStatus.nearaddress,
			tag : id,
			id : id,
			options : {
				draggable : true,
				labelAnchor : new google.maps.Point(-6, 33),
				labelClass : "labels",
				labelContent : id,
				draggable : false,
				//					icon: icn
				icon : VTS_URL_ROOT+"img/tracker/marker-tag-blue.png"
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
	var mrkr = $("#" + dMap).gmap3({
		get : {
			name : "marker",
			tag : "20130002"
		}
	});
	//console.debug(mrkr);
	clusterer.add(mrkr);
}

function toggleCluster(dMap, btn) {
	var st = $(btn).hasClass("active");
	var clusterer = $('#' + dMap).gmap3({
		get : {
			name : "clusterer"
		}
	});
	if (clusterer) {
		if (st) {
			clusterer.enable();
			if (infoBubble.isOpen()) {
				infoBubble.close();
			}			
		} else {
			clusterer.disable();
		}
	}

}
function createLiveTrackerTimers() {
	var dMap = "group_cluster_map";
	//$.each(VTS_GROUP_device_status, function(k, v) {
	//});
	$.timer("VTS_GROUP_TRACKERS", function() {
		updateAllTrackersInfo(dMap);
	}, 10);
	$.timer('VTS_GROUP_TRACKERS').start();
}
function updateAllTrackersInfo(dMap) {
	$.ajax({
		url : VTS_URL_ROOT+'deviceprofiles/get_all_devices_current_info',

		type : 'POST',
		success : function(data, textStatus, jqXHR) {
			var newAllDeviceStatus = JSON.parse(data);
			
			changeAllDeviceStatus(dMap, newAllDeviceStatus);
		},
		error : function(jqXHR, textStatus, errorThrown) {
		}
	});
}
function changeAllDeviceStatus(dMap, newAllDeviceStatus){
	// loop
	//changeDeviceStatus(dMap, newDeviceStatus);
	
	$.each(newAllDeviceStatus, function(k, v) {
		var t = getDeviceStatusById(k);
		console.debug(v);
		if(t.recordEventNumber != v.recordEventNumber)
		{
			t.timeDiff = v.timeDiff;
			t.recordEventNumber = v.recordEventNumber;
			t.serverDateTime = v.serverDateTime;
			t.recordDate = v.recordDate;
			t.recordTime = v.recordTime;
			t.vehicleLat = v.vehicleLat;
			t.vehicleLng = v.vehicleLng;
			t.nearaddress = v.nearaddress;
			t.vehicleAltitude = v.vehicleAltitude;			
			t.vehicleSpeed = v.vehicleSpeed;
			t.ignitionStatus = v.ignitionStatus;
			t.vehicleOdometer = v.vehicleOdometer;
			t.vehicleFuel = v.vehicleFuel;
			
			// change the marker pos
			changeDeviceStatus(dMap, newDeviceStatus);
			// if the modal is open and tracker is on the view change the visual as well
			
		}
	});
}
function changeDeviceStatus(dMap, newDeviceStatus) {
	//var deviceStatus = getDeviceStatusById(id);
	deviceStatus = newDeviceStatus;
	var deviceInfo = getDeviceInfoById(deviceStatus.deviceid);
	var id = deviceStatus.deviceid;
	var lblCnt = "";
	var lbl = "human";
	if (deviceInfo.DeviceType.name == "PT") {
		//lblCnt = deviceInfo.ClientDevice.name;
	} else {
		//lblCnt = deviceInfo.ClientDevice.name;
		lbl = "car";
	}
	var ticon = getVehicleIcon(deviceInfo.VehicleType.name,
			deviceStatus.vehicleSpeed, deviceStatus.ignitionStatus);
	$("#img-" + id).attr("src", VTS_URL_ROOT+"img/tracker/64/"+ticon);

	changeMarkerInCluster(dMap, deviceStatus);
}


function makeTrakcerButton(v) {
	var ds = getDeviceStatusById(v.ClientDevice.deviceid);
	// console.debug(v);
	// var di = getDeviceInfoById(v.deviceid);
	var lbl = "human";
	var icon = "";
	if (v.DeviceType.name == "PT") {
		lblCnt = v.ClientDevice.name;
	} else {
		lblCnt = v.ClientDevice.name;
		lbl = v.VehicleType.name;
	}
	icon = getVehicleIcon(lbl, ds.vehicleSpeed, ds.ignitionStatus);

	var ss = '<li class="contact-alt " id="li-'
			+ v.ClientDevice.deviceid
			+ '"><a href="#" class="ll"'
			+ ' style="width: 175px; float: left;"'
			+ ' onclick="focusMarkerById(\''
			+ v.ClientDevice.deviceid
			+ '\');return false;">'
			+ ' <div class="contact-item">'
			+ ' <div class="pull-left">'
			+ ' <img class="contact-item-object v-icon"'
			+ ' id="img-'
			+ v.ClientDevice.deviceid
			+ '" style="width: 50px; height: 50px;"'
			+ ' src="'+VTS_URL_ROOT+'img/tracker/64/'
			+ icon
			+ '">'
			+ ' </div>'
			+ ' <div class="contact-item-body">'
			+ ' <p class="contact-item-heading bold v-registrationno"'
			+ ' style="white-space: normal !important; line-height: 11px; font-size: 1opx;">'
			+ lblCnt
			+ ' </p>'
			+ ' <div class="btn-group btn-group" style="margin-top: 8px;">'
			+ ' <button class="btn shw" type="button" style="padding: 0 2px;"'
			+ ' onclick="openTrackerNewTab(\''
			+ v.ClientDevice.deviceid
			+ '\');return false;"'
			+ ' data-placement="left" rel="tooltip" data-original-title="Live">'
			+ ' <i class="icon-share"></i>'
			+ ' </button>'
			+ ' <button class="btn shw" type="button" style="padding: 0 2px;"'
			+ ' onclick="openTrackerInfoBox(\''
			+ v.ClientDevice.deviceid
			+ '\');return false;"'
			+ ' data-placement="left" rel="tooltip" data-original-title="Details">'
			+ ' <i class="icon-th-large"></i>' + ' </button>' + ' </div>'
			+ ' </div>' + ' </div> </a>' + ' </li>';
	return ss;
}
function addTrackersInList() {

	for ( var i = 0; i < VTS_GROUP_device_profiles.length; i++) {
		var ss = makeTrakcerButton(VTS_GROUP_device_profiles[i]);
		$("#d-tracker-list").append(ss);
	}

}
function focusMarkerById(id) {
	var clusterer = $('#group_cluster_map').gmap3({
		get : {
			name : "clusterer"
		}
	});
	if (clusterer) {
		clusterer.disable();
		var marker = clusterer.getById(id);
		if (marker)
			google.maps.event.trigger(marker, 'click');
		$("#btn-live-view").addClass("active");
	}
}
function closeTrackerInfoBox() {
	$("#tracker-info-modal").hide();
}
function openTrackerInfoBox(id) {
	// get device info

	// get device status
	var ds = getDeviceStatusById(id);
	var di = getDeviceInfoById(id);
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
	var vl = zeroFill( ds.vehicleOdometer, 10 );
	VTS_GROUP_Obometer.goToNumber(vl);
	
	VTS_GROUP_Gauge_Fule.setValue(ds.vehicleFuel);
	VTS_GROUP_Gauge_Speed.setValue(ds.vehicleSpeed);
	
	//$("#tracker-info-speed").val(ds.vehicleSpeed);
	//$("#tracker-info-fuel").val(ds.vehicleFuel);
	//$("#tracker-info-odometer").html(ds.vehicleOdometer + " Km");

	$("#tracker-info-icon").attr("src", $("#img-" + id).attr("src"));
	$("#tracker-info-modal").show();
}
function openTrackerNewTab(id) {
	var win = window.open('livetracker/' + id, '_blank');
	win.focus();
	return false;
}