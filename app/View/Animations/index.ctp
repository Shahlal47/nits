<script type="text/javascript">
	var hisData = [];

	function loadHistoryDataForAnimation(){
		return hisData;
	}
	$(function() {
		var hdt = JStorageLib.getDeviceHistory();	
		$.each(hdt.data,function(i){
			var t = { "latLng":[ hdt.data[i].vehicleLat,hdt.data[i].vehicleLng], "data": "["+hdt.data[i].serverDateTime+"]["+hdt.data[i].distance+"] "+hdt.data[i].nearaddress,"speed": hdt.data[i].vehicleSpeed};
			hisData.push(t);
		});
	});
</script>
<div class="span12">
	<div class="box">

		<div class="span12 in body" id="div-1">

			<div class="pull-left" style="width: 20%;">
				<h4>Animation Paths:</h4>
				<div id="route-details"
					style="width: 100%; height: 460px; overflow-y: scroll;"></div>
			</div>
			<table class="pull-left" style="width: 80%;">
				<tr>
					<td style="width: 200px" valign="top"></td>
					<td style="width: 67%" valign="top">
						<div id="earth" style="border: 1px solid #000; height: 600px;">
					
					</td>
					<td style="width: 33%" valign="top">
						<div id="map" style="border: 1px solid #000; height: 600px;"></div>
					</td>
				</tr>
			</table>

		</div>

	</div>
</div>
<style>
#route-details {
	height: 400px;
	position: relative;
	overflow: auto;
	font-size: .8em;
}

#route-details ol {
	margin: 0;
	padding: 0;
}

.dir-step {
	list-style: decimal inside;
	position: relative;
	font-size: small;
	padding-right: 50px !important;
}

.dir-step .note {
	position: absolute;
	top: 0;
	right: 0;
	padding: 6px 3px;
}

.dir-step,#dir-start,#dir-end {
	margin: 0;
	padding: 6px 3px;
	cursor: pointer;
}

#dir-start,#dir-end {
	background-color: #888;
	color: #fff;
}

#dir-start,.dir-step {
	border-bottom: 1px solid #888;
}

.dir-step.sel {
	background-color: #00f;
	color: #fff;
}
</style>

