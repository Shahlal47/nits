var APP_COMMON = {
	app_title : "",
	app_root : "",
	refresh_flg : false,
	setDocumentTitle : function(title) {
		if (title != "" ) {
			title = 'NTrack' + " - " + title;
			document.title = title;
		}
	},
	autoResizeDiv : function(div, btm) {
		var h = $(window).height();
		$(div).css('height', h - btm);
		$(div).css('min-height', h - btm);
	},
	bindResizeDiv : function(div, btm) {
		APP_COMMON.autoResizeDiv(div, btm);
		$(window).resize(function() {
			APP_COMMON.autoResizeDiv(div, btm);
		});
	},
	loadUserInfo : function() {
		// first check if exist in the cookies
		// if new user than reload

		// if the user is super, group, single user
		// than check if data exist if not reload

		// if new user than reload

		// if different user dont load
	},
	loadUserDeviceInfo : function(callback) {
		var url = 'trackerTracks/get_all_devices_profile_json';
		APP_HELPER.ajaxSubmitDataCallback(url, '', function(data) {
			JStorageLib.setUserDeviceInfos(data);
			APP_COMMON.refresh_flg = false;
			callback();
		});
	},
	loadUserDeviceUpdatesByDeviceids : function(deviceids, callback) {
		var url = 'trackerTracks/trackers_summary_updates';
		APP_HELPER.ajaxSubmitDataCallback(url, 'deviceids=' + deviceids,
				function(data) {

					JStorageLib.updateUserDeviceStatus(data);

					callback(data);
				});
	},
	loadUserDeviceStatus : function(callback) {
		var url = 'trackerTracks/get_all_devices_status_json';
		APP_HELPER.ajaxSubmitDataCallback(url, '', function(data) {
			JStorageLib.updateUserDeviceStatus(data);
			callback();
		});
	},
	loadUserDeviceStatusByDid : function(did, callback) {
		var url = 'trackerTracks/livetrackerjson/' + did;
		APP_HELPER.ajaxSubmitDataCallback(url, '', function(data) {
			JStorageLib.updateUserDeviceStatusByDid(data.DeviceStatus);
			callback();
		});
	},
	setUserinfo : function(data) {
		JStorageLib.setUserInfo(data);
	},
	getUserinfo : function() {
		var data = JStorageLib.getUserInfo();
		if (data) {
			return data;
		}
		return null;
	},
	getDeviceInfos : function() {
		var data = JStorageLib.getAllUserDeviceInfos();
		if (data) {
			return data;
		}
		return null;
	},
	getTrackerType : function(f) {
		var type = 'human';
		if (f.DeviceType.name == 'VT') {
			type = f.VehicleType.name;
		}
		return type;
	},
	getDeviceStatus : function() {
		var data = JStorageLib.getAllUserDeviceInfos();
		if (data) {
			return data.DeviceStatus;
		}
		return null;
	},
	getDeviceStatusByDeviceid : function(deviceid) {
		var data = JStorageLib.getAllUserDeviceInfos();

		data = data.DeviceStatus;
		var rdt;
		$.each(data, function(i) {

			if (data[i].deviceid == deviceid) {
				rdt = data[i];
				return;
			}
		});
		return rdt;
	},
	getDeviceProfiles : function() {
		var data = JStorageLib.getAllUserDeviceInfos();
		if (data) {
			return data.DeviceProfiles;
		}
		return null;
	},
	getDeviceProfileByDeviceid : function(deviceid) {
		var data = JStorageLib.getAllUserDeviceInfos();
		data = data.DeviceProfiles;
		console.debug(data);

		var rdt;
		$.each(data, function(i) {

			if (data[i].ClientDevice.deviceid == deviceid) {
				console.debug(data[i]);
				rdt = data[i];
			}
		});
		return rdt;
	},
	clearDeviceProfiles : function() {
		JStorageLib.clearUserDeviceInfos();
	},
	loadDashboard : function() {
		APP_HELPER.ajaxRequestModelAction('dashboard/dashboard');
	},
	stopLiveTrackingTimer : function() {
		if (typeof $.timer != 'undefined' && $.timer("live_tracking_timer")) {
			if ($.timer("live_tracking_timer").status() == "running") {
				$.timer("live_tracking_timer").stop();
			}
		}
	},
	initLayout : function(username) {
		APP_COMMON.stopLiveTrackingTimer();

		APP_COMMON.app_root = APP_URL_ROOT;
		APP_COMMON.app_title = document.title;

		var cusername = APP_COMMON.getUserinfo();
		if (cusername == null || cusername != username) {
			APP_COMMON.refresh_flg = true;
			APP_COMMON.setUserinfo(username);
		}

		APP_COMMON.bindResizeDiv('.iframe', 70);

		$('#left-menu a').bind(
				'click',
				function() {
					// APP_HELPER.selectMenu('#left-menu',$(this).attr('href').substring(1));
					APP_HELPER.ajaxRequestModelAction($(this).attr('href')
							.substring(2));
					return false;
				});
		$('.menu-ajax a').bind(
				'click',
				function() {
					// APP_HELPER.selectMenu('#left-menu',$(this).attr('href').substring(2));
					APP_HELPER.ajaxRequestModelAction($(this).attr('href')
							.substring(2));
					return false;
				});

		$("#frmAjaxUserLogin").bind("submit", function(event) {
			var data = $("#frmAjaxUserLogin").serialize();
			APP_HELPER.ajaxLogin(data);
			return false;
		});

		$('#lnkMonitor').bind('click', function() {
			APP_COMMON.openMonitor();
		});

	},
	initPage : function(title) {
		var cur_url = document.URL;
		if (cur_url != APP_COMMON.app_root) {
			document.URL = APP_COMMON.app_root;
		}
		APP_COMMON.stopLiveTrackingTimer();

		APP_COMMON.setDocumentTitle(title);

		$("[rel='tooltip']").tooltip();

		$(".form_datetime").datetimepicker({
			format : 'yyyy-mm-dd hh:ii',
			autoclose : true
		});
		$(".form_date").datetimepicker({
			format : 'yyyy-mm-dd',
			autoclose : true,
			minView : 2
		});
		$(".form_time").datetimepicker({
			format : 'hh:ii',
			autoclose : true,
			startView : 0,
			maxView : 0
		});

		$('.minimize-box').on(
				'click',
				function(e) {
					e.preventDefault();
					var $icon = $(this).children('i');
					if ($icon.hasClass('icon-chevron-down')) {
						$icon.removeClass('icon-chevron-down').addClass(
								'icon-chevron-up');
					} else if ($icon.hasClass('icon-chevron-up')) {
						$icon.removeClass('icon-chevron-up').addClass(
								'icon-chevron-down');
					}
				});
		$('.minimize-box').on('click', function(e) {
			e.preventDefault();
			var $icon = $(this).children('i');
			if ($icon.hasClass('icon-minus')) {
				$icon.removeClass('icon-minus').addClass('icon-plus');
			} else if ($icon.hasClass('icon-plus')) {
				$icon.removeClass('icon-plus').addClass('icon-minus');
			}
		});

		$('.close-box').click(function() {
			$(this).closest('.box').hide('slow');
		});
	},
	openMonitor : function() {
		var win = window.open(APP_URL_ROOT + "monitoring", '_blank');
		win.focus();
	},
	loadTrackersInList : function(id) {
		var devices = APP_COMMON.getDeviceProfiles();
		for ( var i = 0; i < devices.length; i++) {
			var v = devices[i];
			if (v.DeviceType.name == "PT") {
				var option = '<option value="' + v.ClientDevice.deviceid + '">'
						+ v.ClientDevice.name + '</option>';
				$(id + ' > optgroup[label="Personal Tracker"]').append(option);
			} else {
				var option = '<option value="' + v.ClientDevice.deviceid + '">'
						+ v.ClientDevice.name + '</option>';
				$(id + ' > optgroup[label="Vahicle Tracker"]').append(option);
			}
		}
		$(id).select2();
	}
};