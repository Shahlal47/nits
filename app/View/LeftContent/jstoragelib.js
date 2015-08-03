var JStorageLib = {
		setCookie : function (scname, data){
		    var newOptions = {
		        expiresAt: new Date(2015, 1, 1),
		        secure: true
		    };
		    $.jStorage.set(scname,data, newOptions);
		},
		getCookie : function (scname){
		    return $.jStorage.get(scname);
		},

		removeCookie : function (scname){
		    var cookieData = $.jStorage.get(scname);
		    if(cookieData != null){
		        $.jStorage.flush();
		        $.jStorage.deleteKey(scname);
		    }
		},

		viewCookie : function (scname){
		    var data= getCookie(scname);
		    console.debug(data);
		},

		// set user info 
		setUserInfo : function (data){
			JStorageLib.setCookie("UserInfo", data);
		},
		// get user info
		getUserInfo : function (){
			return JStorageLib.getCookie("UserInfo");
		},
		// clear user info
		clearUserInfo : function (){
			JStorageLib.removeCookie("UserInfo");
		},

		// set user device infos
		setUserDeviceInfos : function (data){
			JStorageLib.setCookie("UserDevices", data);
		},
		// get user device all infos
		getAllUserDeviceInfos : function (){
			return JStorageLib.getCookie("UserDevices");
		},
		// clear user device infos
		clearUserDeviceInfos : function (){
			JStorageLib.removeCookie("UserDevices");
		},
		updateUserDeviceStatus: function (data){
		    var userDevices = JStorageLib.getCookie("UserDevices");
        	userDevices.DeviceStatus = data; 
        	JStorageLib.setUserDeviceInfos(userDevices);
		},
		updateUserDeviceStatusByDid: function (data){
			
		    var userDevices = JStorageLib.getCookie("UserDevices");
		    var userDeviceStatus = userDevices.DeviceStatus;
		    //console.debug(userDeviceStatus.length);
		    var flg = false;
		    $.each(userDeviceStatus,function(i){
		    	if(userDeviceStatus[i].deviceid == data.deviceid){
		        	//console.debug('rec: '+data);
		        	userDeviceStatus[i] = data;
		        	userDevices.DeviceStatus = userDeviceStatus; 
		        	JStorageLib.setUserDeviceInfos(userDevices);
		        	flg = true;
		            return;
		        }
			});
		    if(!flg){		    	
		    	//alert("Invalid Data!");
		    }
		},
		clearDeviceHistory : function (){
			JStorageLib.removeCookie("DeviceHistory");
		},

		// set user device infos
		setDeviceHistory : function (data){
			JStorageLib.clearDeviceHistory();
			JStorageLib.setCookie("DeviceHistory", data);
		},
		// get user device all infos
		getDeviceHistory : function (){
			return JStorageLib.getCookie("DeviceHistory");
		}
};
