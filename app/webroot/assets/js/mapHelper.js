var map;

/* ### MAP Menu Start ### */


/* ### MAP Menu End ### */

var MAP_HELPER = {
	zeroFill : function(number, width) {
		width -= number.toString().length;
		if (width > 0) {
			return new Array(width + (/\./.test(number) ? 2 : 1)).join('0')
					+ number;
		}
		return number + ""; // always return a string
	},
	getMarkerColor : function(speed, ignition) {
		var icn = "ash";
		if (ignition == "0" && speed == "0") {
			icn = "red";
		} else if (ignition == "1" && speed == "0") {
			icn = "org";

		} else if (ignition == "1" && speed != "0") {
			icn = "grn";
		} else if (ignition == "0" && speed != "0") {
			icn = "blu";
		}
		return icn;
	},
	getMarkerImg : function(type, speed, ignition) {
		var c = MAP_HELPER.getMarkerColor(speed, ignition);
//		var img = APP_COMMON.app_root + 'img/marker/small/' + type + '-' + c
//				+ '.png';
		var img = APP_COMMON.app_root + 'img/nits_marker/'+ c
		+ '_32.png';
		console.debug(img);
		return img;
	},
	getMarkerPinIcon : function(speed, ignition) {
		var c = MAP_HELPER.getMarkerColor(speed, ignition);
		var img = APP_COMMON.app_root + "img/marker/live/live-" + c + ".png";
		return img;
	},
	getLiveMarker : function(type) {
		var icn = "car";
		if (type == "PT") {
			icn = "human";
		}
		var img = APP_COMMON.app_root + "img/marker/live/live-" + icn
				+ "-pin.gif";
		return img;
	},
	getTrackerImg : function(size, type, speed, ignition) {
		var c = MAP_HELPER.getMarkerColor(speed, ignition);
//		var img = APP_COMMON.app_root + 'img/tracker/' + size + '/' + type
//				+ '-' + c + '.png';
		var img = APP_COMMON.app_root + 'img/nits_marker/'+ c
		+ '_32.png';
		return img;
	},
	setMapCenterOfPoints : function(dMap, centerLatLng) {
		$(dMap).gmap3('get').setCenter(
				new google.maps.LatLng(centerLatLng[0], centerLatLng[1]));
		$(dMap).gmap3('get').setZoom(15);
	},

	putMarkerOnMap : function(dMap, data) {
		$(dMap).gmap3({
			marker : {
				latLng : data.latLng,
				data : data.data,
				tag : data.id,
				id : data.id,
				options : data.options,
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
	},
	ReturnTimeDiff : function(_0x5d06x4e) {
		var _0x5d06xb0 = Math['floor'](_0x5d06x4e / (60 * 60 * 24));
		var _0x5d06xb1 = Math['floor']
				((_0x5d06x4e - (_0x5d06xb0 * 60 * 60 * 24)) / (60 * 60));
		var _0x5d06xb2 = Math['floor']((_0x5d06x4e
				- (_0x5d06xb0 * 60 * 60 * 24) - (_0x5d06xb1 * 60 * 60)) / 60);
		if (_0x5d06xb0 < 1) {
			if (_0x5d06xb1 < 1) {
				if (_0x5d06xb2 < 2) {
					_0x5d06x4e = '';
					return _0x5d06x4e;
				} else {
					_0x5d06x4e = _0x5d06xb2 + ' min';
					return _0x5d06x4e;
				}
				;
			} else {
				_0x5d06x4e = _0x5d06xb1 + ' hrs';
				_0x5d06x4e = _0x5d06x4e + ' ' + _0x5d06xb2 + ' min';
				return _0x5d06x4e;
			}
			;
		} else {
			_0x5d06x4e = _0x5d06xb0 + ' days';
			_0x5d06x4e = _0x5d06x4e + ' ' + _0x5d06xb1 + ' hrs';
			_0x5d06x4e = _0x5d06x4e + ' ' + _0x5d06xb2 + ' min';
			return _0x5d06x4e;
		}
		;
	},
	toggleCluster : function(dMap, btn) {
		var st = $(btn).hasClass("active");
		var clusterer = $(dMap).gmap3({
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

	},
	_clusterHack : function(dMap) {
		var clusterer = $(dMap).gmap3({
			get : {
				name : "clusterer"
			}
		});
		if (clusterer) {
			clusterer.disable();
			clusterer.enable();
		}
	},
	changeMarkerStatus : function(deviceStatus, marker) {

		var micon = getMarkerPinIcon(deviceStatus.vehicleSpeed,
				deviceStatus.ignitionStatus);
		marker.setIcon(micon);

		var latlng = new google.maps.LatLng(deviceStatus.vehicleLat,
				deviceStatus.vehicleLng);
		marker.setPosition(latlng);
		// change the contents of the info window
	},
	getInfoBubbleData : function(v) {
		// var deviceInfo = getDeviceInfoById(v.deviceid);
		icn = getTrackerLastCapturedImage(v.deviceid);
		var ig = "OFF";
		if (v.ignitionStatus == 1)
			ig = "ON";
		var info = '<div class="tracker-info-box">'
				+ '<div style="font-size:.9em;width: 90%;height: 54px; float:left;padding: 10px; background-color:#D9EDF7;box-shadow:inset 0 0 5px #3A87AD;-moz-border-radius: 5px;border-radius: 5px;">'
				+ '	<table>' + '		<tbody>'
				+ '			<tr><td><b>Ignition</b></td><td>'
				+ ig
				+ '</td></tr>'
				+ '			<tr><td><b>Datetime </b></td><td>'
				+ v.serverDateTime
				+ '</td></tr>'
				+ '			<tr><td><b>LatLng</b></td><td>'
				+ v.vehicleLat
				+ ' : '
				+ v.vehicleLng
				+ '</td></tr>'
				+ '			<tr><td><b>Speed</b></td><td>'
				+ v.vehicleSpeed
				+ ' km</td></tr>'
				+ '		</tbody>'
				+ '	</table>'
				+ '</div>'
				+ '<div style="font-size:.9em;width: 90%; float:left;padding: 10px; background-color:#D9EDF7;box-shadow:inset 0 0 5px #3A87AD;-moz-border-radius: 5px;border-radius: 5px;">'
				+ '<b>Location:</b><br/>' + v.nearaddress + '</div></div>';
		return info;
		/*+ '<div style="font-size:.9em;width: 90%; float:left;padding: 0px 10px 0px 10px; background-color:#D9EDF7;box-shadow:inset 0 0 5px #3A87AD;-moz-border-radius: 5px;border-radius: 5px;">'
		+ '	<a onclick="showImageOnModal(this);return false;" style="cursor:pointer;"><img style="-moz-border-radius: 5px;border-radius: 5px;" width="64" src="'
		+ icn
		+ '"></a>'
		+ '</div>'*/
	},
	/*
	 * + '<div style="font-size:.7em;width: 90%;height: 54px;
	 * float:left;padding: 10px; background-color:#D9EDF7;box-shadow:inset 0 0
	 * 5px #3A87AD;-moz-border-radius: 5px;border-radius: 5px;">'
	 */
	getInfoBubbleData2 : function(v) {
		// var deviceInfo = getDeviceInfoById(v.deviceid);
		var ig = "OFF";
		if (v.ignitionStatus == 1)
			ig = "ON";
		var info = '<div class="tracker-info-box">'
				+ '<div style="font-size:.8em;width: 90%;height: 54px; float:left;padding: 10px; background-color:#D9EDF7;box-shadow:inset 0 0 5px #3A87AD;-moz-border-radius: 5px;border-radius: 5px;">'
				+ '<table><tbody>'
				+ '<tr><td style="width:30%"><b>Status : </b></td><td>'
				+ ig
				+ '</td></tr>'
				+ '<tr><td><b>Time : </b></td><td>'
				+ v.serverDateTime
				+ '</td></tr>'
				+ '<tr><td><b>GPS :</b></td><td>'
				+ v.vehicleLat
				+ ' : '
				+ v.vehicleLng
				+ '</td></tr>'
				+ '<tr><td><b>Speed :</b></td><td>'
				+ v.vehicleSpeed
				+ ' km</td></tr>'
				+ '</tbody>'
				+ '</table>'
				+ '</div>'
				+ '<div style="font-size:.9em;width: 90%; float:left;padding: 10px; background-color:#D9EDF7;box-shadow:inset 0 0 5px #3A87AD;-moz-border-radius: 5px;border-radius: 5px;">'
				+ v.nearaddress + '</div></div>';
		return info;
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
							}
						},
						events : {
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
	},
	initMapFence : function(dMap, wdth, hght) {
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
							zoom : 10,
							mapTypeId : google.maps.MapTypeId.ROADMAP,
							mapTypeControlOptions : {
								mapTypeIds : [ google.maps.MapTypeId.ROADMAP,
										google.maps.MapTypeId.HYBRID,
										google.maps.MapTypeId.SATELLITE,
										google.maps.MapTypeId.TERRAIN,
										"Highways", "Roads" ]
							}
						},
						events : {
//							rightclick : function(map, event) {
//								//current = event;
//								//menu.open(current);
//							},
//							click : function() {
//								menu.close();
//							},
//							dragstart : function() {
//								menu.close();
//							},
//							zoom_changed : function() {
//								menu.close();
//							}
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
	},
	initMap2 : function(dMap, data) {

		$(dMap).gmap3({
			map : {
				options : {
					center : [ data.latLng[0], data.latLng[1] ],
					zoom : 15,
					mapTypeId : google.maps.MapTypeId.ROADMAP,
					mapTypeControlOptions : {
						mapTypeIds : []
					}
				}
			},
			marker : {
				latLng : data.latLng,
				data : data.data,
				tag : data.id,
				id : data.id,
				options : data.options,
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
		var vMap = $(dMap).gmap3('get');
		map = vMap;
		return vMap;
	},
	initClusterMap : function(dMap, dt) {

		$(dMap)
				.gmap3(
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
		var vMap = $(dMap).gmap3('get');
		map = vMap;
		return vMap;
	}

};

var infoBubble;
function getMarkerColor(speed, ignition) {
	var icn = "ash";
	if (ignition == "0" && speed == "0") {
		icn = "red";
	} else if (ignition == "1" && speed == "0") {
		icn = "org";
	} else if (ignition == "1" && speed != "0") {
		icn = "grn";
	} else if (ignition == "0" && speed != "0") {

		icn = "blu";
	}
	return icn;
}
function getMarkerPinIcon(speed, ignition) {
	var icn = "img/tracker/marker-tag-ash.png";
	if (ignition == "0" && speed == "0") {
		icn = "img/tracker/marker-tag-red.png";
	} else if (ignition == "1" && speed == "0") {
		icn = "img/tracker/marker-tag-org.png";
	} else if (ignition == "1" && speed != "0") {
		icn = "img/tracker/marker-tag-grn.png";
	} else if (ignition == "0" && speed != "0") {

		icn = "img/tracker/marker-tag-blu.png";
	}
	return icn;
}
/*function getVehicleIcon(vehicleType, speed, ignition) {
	var icn = "" + vehicleType + "-ash.png";
	if (ignition == "0" && speed == "0") {
		icn = "" + vehicleType + "-red.png";
	} else if (ignition == "1" && speed == "0") {
		icn = "" + vehicleType + "-org.png";
	} else if (ignition == "1" && speed != "0") {
		icn = "" + vehicleType + "-grn.png";
	} else if (ignition == "0" && speed != "0") {
		icn = "" + vehicleType + "-blu.png";
	}
	return icn;
}*/

function getVehicleIcon(vehicleType, speed, ignition) {
	var icn = "red_32.png";
	if (ignition == "0" && speed == "0") {
	} else if (ignition == "1" && speed == "0") {
		icn = "yellow_32.png";
	} else if (ignition == "1" && speed != "0") {
		icn = "green_32.png";
	}
	return icn;
}

function getMovingStatus(speed, ignition) {
	var icn = '<span class="badge">Unknown</span>';
	if (ignition == "0" && speed == "0") {
		icn = '<span class="badge badge-important">OFF</span>';
	} else if (ignition == "1" && speed == "0") {
		icn = '<span class="badge badge-info">IDLE</span>';
	} else if (ignition == "1" && speed != "0") {
		icn = '<span class="badge badge-success">ON</span>';
	} else if (ignition == "0" && speed != "0") {
		icn = '<span class="badge badge-warning">MM</span>';
	}
	return icn;
}
function getTrackerLastCapturedImage(deviceid) {
	var icn = "/vts/files/trackers/" + deviceid + "/1713.jpg";
	return icn;
}
function getInfoBubbleDataGeo(info) {
	var infos = '<div class="tracker-info-box" style="line-height: 12px;">'
			+ '<div style="font-size:.9em;width: 180px;height: 54px; float:left;padding: 10px; background-color:#D9EDF7;box-shadow:inset 0 0 5px #000000;-moz-border-radius: 5px;border-radius: 5px;">'
			+ info + '</div>' + '</div>';
	return infos;
}

function getInfoBubbleData2(v) {
	// var deviceInfo = getDeviceInfoById(v.deviceid);
	var ig = "OFF";
	if (v.ignitionStatus == 1)
		ig = "ON";
	var info = '<div class="tracker-info-box">'
			+ '<div style="font-size:.9em;width: 90%;height: 54px; float:left;padding: 10px; background-color:#D9EDF7;box-shadow:inset 0 0 5px #000000;-moz-border-radius: 5px;border-radius: 5px;">'
			+ '	<table>'
			+ '		<tbody>'
			+ '			<tr><td><b>Ignition</b></td><td>'
			+ ig
			+ '</td></tr>'
			+ '			<tr><td><b>Datetime </b></td><td>'
			+ v.serverDateTime
			+ '</td></tr>'
			+ '			<tr><td><b>LatLng</b></td><td>'
			+ v.vehicleLat
			+ ' : '
			+ v.vehicleLng
			+ '</td></tr>'
			+ '			<tr><td><b>Speed</b></td><td>'
			+ v.vehicleSpeed
			+ ' km</td></tr>'
			+ '		</tbody>'
			+ '	</table>'
			+ '</div>'
			+ '<div style="font-size:.9em;width: 90%; float:left;padding: 10px; background-color:#D9EDF7;box-shadow:inset 0 0 5px #000000;-moz-border-radius: 5px;border-radius: 5px;">'
			+ '<b>Location:</b><br/>' + v.nearaddress + '</div></div>';
	return info;
}
$(function() {
	infoBubble = new InfoBubble({
		maxWidth : 300,
		// backgroundColor : '#333',
		// padding : 5,
		arrowSize : 10,
		content : '',
	});
});

function changeMarkerStatus(deviceInfo, deviceStatus, marker) {

	var micon = getMarkerPinIcon(deviceStatus.vehicleSpeed,
			deviceStatus.ignitionStatus);
	marker.setIcon(micon);

	var latlng = new google.maps.LatLng(deviceStatus.vehicleLat,
			deviceStatus.vehicleLng);
	marker.setPosition(latlng);
	// change the contents of the info window
}

function changeMarkerIcon(dMap, id, icon) {
	var marker = getMarkerById(dMap, id);
	marker.setIcon(icon);
}

function getMarkerById(dMap, id) {

	var marker = $("#" + dMap).gmap3({
		get : {
			name : "marker",
			tag : id
		}
	});
	return marker;
}

function clearAllMarker(dMap) {

	$("#" + dMap).gmap3('clear', 'markers');
}

function getDeviceStatusById(id) {
	var deviceStatus;
	var devices_status = APP_COMMON.getDeviceStatus();
	$.each(devices_status, function(k, v) {
		if (k == id) {
			deviceStatus = v;
			return deviceStatus;
		}
	});
	return false;
}
function getDeviceInfoById(id) {
	var deviceProfile;
	var devices = APP_COMMON.getDeviceProfiles();
	$.each(devices, function(k, v) {
		if (v.ClientDevice.deviceid == id) {
			deviceProfile = v;
			return deviceProfile;
		}
	});
	return false;
}

function initMap2(dMap, data) {

	$('#' + dMap).gmap3({
		map : {
			options : {
				center : [ data.latLng[0], data.latLng[1] ],
				zoom : 15,
				mapTypeId : google.maps.MapTypeId.ROADMAP,
				mapTypeControlOptions : {
					mapTypeIds : []
				}
			}
		},
		marker : {
			latLng : data.latLng,
			data : data.data,
			tag : data.id,
			id : data.id,
			options : data.options,
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
}
function setMapCenterOfPoints(dMap, centerLatLng) {
	$('#' + dMap).gmap3('get').setCenter(
			new google.maps.LatLng(centerLatLng[0], centerLatLng[1]));
	$('#' + dMap).gmap3('get').setZoom(15);
}
function addMarkersInMap(dMap, data) {

	$('#' + dMap).gmap3({
		marker : {
			values : data,
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
		}
	});
}
function addMarkerWithCallback(dMap, data, callback) {

	$('#' + dMap).gmap3({
		marker : {
			latLng : data.latLng,
			data : data.data,
			tag : data.id,
			id : data.id,
			options : data.options,
			events : {
				click : function(marker, event, context) {
					var map = $(this).gmap3("get");

					if (infoBubble.isOpen()) {
						infoBubble.close();
					}
					infoBubble.setContent(context.data);
					infoBubble.open(map, marker);
					callback(marker);
				}
			}
		}
	});
}
function putMarkerOnMap(dMap, data) {
	$('#' + dMap).gmap3({
		marker : {
			latLng : data.latLng,
			data : data.data,
			tag : data.id,
			id : data.id,
			options : data.options,
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
}

function showImageOnModal(me) {
	var src = $("img", me).attr("src");
	$('#tracker-capture-shot').attr("src", src);
	$('#modal-tracker-capture-shot').modal();
}
function ReturnTimeDiff(_0x5d06x4e) {
	var _0x5d06xb0 = Math['floor'](_0x5d06x4e / (60 * 60 * 24));
	var _0x5d06xb1 = Math['floor']((_0x5d06x4e - (_0x5d06xb0 * 60 * 60 * 24))
			/ (60 * 60));
	var _0x5d06xb2 = Math['floor']
			((_0x5d06x4e - (_0x5d06xb0 * 60 * 60 * 24) - (_0x5d06xb1 * 60 * 60)) / 60);
	if (_0x5d06xb0 < 1) {
		if (_0x5d06xb1 < 1) {
			if (_0x5d06xb2 < 2) {
				_0x5d06x4e = '';
				return _0x5d06x4e;
			} else {
				_0x5d06x4e = _0x5d06xb2 + ' min';
				return _0x5d06x4e;
			}
			;
		} else {
			_0x5d06x4e = _0x5d06xb1 + ' hrs';
			_0x5d06x4e = _0x5d06x4e + ' ' + _0x5d06xb2 + ' min';
			return _0x5d06x4e;
		}
		;
	} else {
		_0x5d06x4e = _0x5d06xb0 + ' days';
		_0x5d06x4e = _0x5d06x4e + ' ' + _0x5d06xb1 + ' hrs';
		_0x5d06x4e = _0x5d06x4e + ' ' + _0x5d06xb2 + ' min';
		return _0x5d06x4e;
	}
	;
};

