var map;

var VTS_HISTORY = {
	map : null,
	seldeviceid:"",
	poly7 : [],
	loadTrackersInList : function() {
		//console.debug(VTS_GROUP_device_profiles);
		for ( var i = 0; i < VTS_GROUP_device_profiles.length; i++) {
			var v = VTS_GROUP_device_profiles[i];
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
		//var l = data.length-1;
		var centerLatLng = data[data.length - 1].latLng;
		//console.debug(data);
		addMarkersInMap("history_map",data);
		setMapCenterOfPoints("history_map",centerLatLng);		
	},
	updateHistoryData : function(data) {
		this.clearMarkers();
		var hsData = data.data;
		prevLatLong = null;
		var dt = new Array();
		var icn = "";
		for ( var i = 0; i < hsData.length; i++) {
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
			var data = getInfoBubbleData(v);
			dt.push({
				latLng : [ v.vehicleLat, v.vehicleLng ],
				data : data,
				//id : this.seldeviceid,
				//tag : this.seldeviceid,
				options : {
					icon : VTS_URL_ROOT+"img/tracker/marker-" + lbl + "-"+color+".png"
				}
			});
		}
		lineDrawCleared = false;
		this.addMarkers(dt);
		this.poly7 = new Array();
		//this.drawLineArwLines(dt);
		this.closeFilterHistoryModal();
	},
	updateTrackerInfo : function() {
		var did = $("#selDevices").select2("val");
		this.seldeviceid = did;
		var sdt = $("#fromDate").val();
		var edt = $("#fromDate").val();
		var st = $("#fromTime").val();
		var et = $("#toTime").val();
		$.ajax({
					url : '/nits/histories/getHistoryByDate?deviceid=' + did
							+ '&historyType=specificDate&startDate=' + sdt
							+ '&endDate=' + edt + '&startTime=' + st
							+ '&endTime=' + et,

					success : function(data, textStatus, jqXHR) {
						var historyData = JSON.parse(data);
						VTS_HISTORY.updateHistoryData(historyData);
					},
					error : function(jqXHR, textStatus, errorThrown) {
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
	showFilterByDateBox : function() {
		// show the modal box
		var t = $("#selDevices").select2("val");
		if (t == "") {
			alert(t);
		} else {
			$("#filter-tracker-id").html(t);
			$("#filter-history-modal").show();
		}

	},
	closeFilterHistoryModal : function() {
		$("#filter-history-modal").hide();
	}
};
function openAnimationModal(){
	$('#modal-animation').modal();
	// load the data
	DS_init();
	DS_goDirections();
}
function openAnimationTab(){
	var did = $("#selDevices").select2("val");
	//this.seldeviceid = did;
	var sdt = $("#fromDate").val();
	var edt = $("#fromDate").val();
	var st = $("#fromTime").val();
	var et = $("#toTime").val();
	var url = '/nits/animations'
	//							+'?deviceid=' + did
		//						+ '&historyType=specificDate&startDate=' + sdt
			//					+ '&endDate=' + edt + '&startTime=' + st
				//				+ '&endTime=' + et
		;
	var win = window.open(url);
	win.focus();
	return false;
}

$(document).ready(
		function() {
			$("[rel='tooltip']").tooltip();
			/*
			// datepicker
			$('[data-form=datepicker]').datepicker({
				autoclose : true
			});
			$('#fromTime').timepicker({minuteStep: 1,                
                showSeconds: true,
                showMeridian: false});
			$('#toTime').timepicker({minuteStep: 1,                
                showSeconds: true,
                showMeridian: false});
			
			$('#toggle-btn1').click(function(e) {
				e.stopPropagation();
				$('#fromTime').timepicker('toggle');
			});
			$('#toggle-btn2').click(function(e) {
				e.stopPropagation();
				$('#toTime').timepicker('toggle');
			});
			$('#toggle-btn11').click(function (e) {
			  //e.stopPropagation();
			    $('#inputDate1').datepicker('show');
			  });
			$('#toggle-btn12').click(function (e) {
			  //e.stopPropagation();
			    $('#inputDate2').datepicker('show');
			  });
			 */

			VTS_HISTORY.loadTrackersInList();
			initMap("history_map");
//			$('#history_map').gmap3('get').setCenter(
//					new google.maps.LatLng(23.684774, 90.351563));
			map = $('#history_map').gmap3('get');
			//VTS_HISTORY.updateTrackerInfo();

		}
);