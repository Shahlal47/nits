<div style="margin: 0;">
	<div class="box dark">
		<input id="selectedId" value="" type="hidden">
		<header>
			<h5>Trackers</h5>
		</header>
		<div id="div-1" class=" body">
			<h6 style="margin: 5px 0">
				Number of Monitors <select style="width: 50px; margin: 0;"
					id="selNumOfMaps">
					<option value="0" selected></option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
				</select>
			</h6>
			<table class="tracker" id="tracker-list">

			</table>
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
}
#tracker-list tr td {
	padding: 4px 6px;
}

.lnkTracker {
	display: block;
	float: left;
	font-weight: bold;
	color: #000;
	text-decoration: none;
	font-size: .8em;
	/*height: 38px;*?
	width: 200px;
	/*text-align: center;*/
}

.lnkTracker:hover {
	text-decoration: none;
}

.lnkTracker span {
	height: 30px;
	text-align: center;
	vertical-align: sub;
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
	padding: 4px 12px;
	text-align: center;
	text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
	vertical-align: middle;
	height: 24px;
	width:24px;
}

.tracker-btn {
	border-radius: 0px 4px 4px 0px;
	float: right;
	margin: 2px;
}
</style>

<script type="text/javascript">
var VTS_MONITOR={

	init:function(){
		
		APP_COMMON.bindResizeDiv('#tracker-list',120);

		
		// load trackers from the cache
		var devices = APP_COMMON.getDeviceProfiles();
		var options = '<option value=""></option>';
		$.each(devices,function(i){			
			VTS_MONITOR.drawTracker(devices[i]);
			options += '<option value="'+(i+1)+'">'+(i+1)+'</option>';
		});

		$("#selNumOfMaps").empty();
		$("#selNumOfMaps").append(options);
		
		
		$("#tracker-list tr td div").draggable({
            helper: "clone"
          });		
	},
	drawTracker:function (f){
		var type = APP_COMMON.getTrackerType(f);
			
		var ds = APP_COMMON.getDeviceStatusByDeviceid(f.ClientDevice.deviceid);
		
		var img = MAP_HELPER.getTrackerImg('small',type,ds.vehicleSpeed,ds.ignitionStatus);

		/*var v = '';
		
		v += '<li id="'+f.ClientDevice.deviceid+'"><a class="lnkTracker" href="javascript:;" >';
		v += '<span class="spn1"><img class="tracker-btn" alt="" src="'+img+'">';
		v += '</span><span class="spn2"><strong>'+f.ClientDevice.name+'</strong></span></a></li>';
		*/

		var tr = '<tr>' +
		'<td style="width:10%;"><img alt="" src="'+img+'" class="tracker-btn"></td>'+
		'<td style="width:80%;"><div id="'+f.ClientDevice.deviceid+'"><a href="javascript:;" class="lnkTracker"><span><b>'+f.ClientDevice.name+ '<br>' + f.ClientDevice.deviceid + '</b></span></a></div></td>'+
		'</tr>';
		
		$('#tracker-list').append(tr);
	}
};



$(function(){
	VTS_MONITOR.init();
});
</script>
