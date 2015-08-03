<div style="margin: 0;">
	<div class="box dark">
		<header>
			<h5>Search by User ID</h5>
		</header>
		<div id="div-1" class=" body">
			<div class="input-append">
				<input placeholder="Search by User ID" style="width: 200px" id="searchByUserId" type="text" list="userList">
				<datalist id="userList">
					<?php 
					foreach($userList as $userid=>$username){?>
						<option id="<?php echo $userid?>" value="<?php echo $username?>">
						<?php 
					}
					?>
				</datalist>
					
				<button id="btnSearch" class="btn" type="button"
					title="Search by User Id">
					<i class="icon-search"></i>
				</button>
			</div>
			<div id="usrDiv" style="display:none;background-color: #468866;width:240px;padding:5px;color: white;">User : <span id="userName"></span></div>
		</div>
	</div>
	<div class="box dark">
		<header>
			<h5>Search By Tracker ID</h5>
		</header>
		<div id="div-1" class=" body">
			<div class="input-append">
				<input placeholder="Search by Tracker ID" style="width: 200px"
					id="searchTrackerText" type="text">
				<button id="btnTrackerSearch" class="btn" type="button"
					title="Search by Tracker ID">
					<i class="icon-search"></i>
				</button>
			</div>
		</div>
	</div>
	<div class="box dark">
		<div id="div-1" class=" body">
			<input id="selectedId" value="" type="hidden">
			<input id="userId" value="" type="hidden">
			<header>
				<h5>
					Device List<span id="device_count"> (Total Devices : 0 ) </span>
				</h5>
				<div class="toolbar" >
					<ul class="nav" >
						<li><a id="reportId" style="padding: 4px;" href="javascript:;"> <i
								class="icon-book icon-inverse" title="Reports"></i>
						</a></li>
					</ul>
				</div>
			</header>
			<div style="height: 200px ;">
				<ul class="tracker" id="trackers" style="height:190px; !important; overflow:auto;"  >
				</ul>
				<table style="width:100%" class="tracker" id="tracker-list">
							
						</table>	
			</div>
			<div style="background-color: #FFF;">
				<header>
					<h5>Device Profile</h5>
				</header>
				<ul class="nav nav-tabs" id="myTab">
					<li class="active" style=""><a href="#tacker_detail_id">Tracker
							Details</a></li>
					<li style=""><a href="#tracker_status_id">Tracker Status</a>
					</li>
				</ul>
				<div class="tab-content" id="dp_tab_content">
					<div class="tab-pane active" id="tacker_detail_id">
						<table style="width: 265px; !important; overflow:auto;">
							<tbody>
								<tr>
									<td><b>Registration Number:</b></td>
									<td id="lickr-inf-reg"></td>
								</tr>
								<tr>
									<td><b>Subscription Date:</b></td>
									<td id="lickr-inf-sddt"></td>
								</tr>
								<tr>
									<td><b>Expiry Date:</b></td>
									<td id="lickr-inf-exdt"></td>
								</tr>
								<tr>
									<td><b>Type:</b></td>
									<td id="lickr-inf-dtpe"></td>
								</tr>
								<tr>
									<td><b>Description:</b></td>
									<td id="lickr-inf-desc"></td>
								</tr>
								<tr>
									<td><b>Unit SIM:</b></td>
									<td id="lickr-inf-cell"></td>
								</tr>
								<tr>
									<td><b>Speed Limit:</b></td>
									<td id="lickr-inf-lmt"></td>
								</tr>
								<tr>
									<td><b>IMEI Number:</b></td>
									<td id="lickr-inf-imei"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="tab-pane" id="tracker_status_id">

						<table style="width: 265px;">
							<tbody>
								<tr>
									<td><b>Status:</b></td>
									<td id="dv-stat-status"></td>
								</tr>
								<tr>
									<td><b>Speed:</b></td>
									<td id="dv-stat-speed"></td>
								</tr>
								<tr>
									<td><b>Lattitude:</b></td>
									<td id="dv-stat-lat"></td>
								</tr>
								<tr>
									<td><b>Longitude:</b></td>
									<td id="dv-stat-lng"></td>
								</tr>
								<tr>
									<td><b>Near Address:</b></td>
									<td id="dv-stat-addr"></td>
								</tr>
								<tr>
									<td><b>Fuel:</b></td>
									<td id="dv-stat-fuel"></td>
								</tr>
								<tr>
									<td><b>Odometer:</b></td>
									<td id="dv-stat-odo"></td>
								</tr>
								<tr>
									<td><b>Tracker Time:</b></td>
									<td id="dv-stat-dvtime"></td>
								</tr>
								<tr>
									<td><b>Server Record Time:</b></td>
									<td id="dv-stat-svtime"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div style="background-color: #FFF;">
				<header>
					<h5>Client Profile</h5>
				</header>
				<ul class="nav nav-tabs" id="myTab">
					<li class="active" style=""><a href="#user_profile_id">Client Info</a>
					</li>
					<li style=""><a href="#client_contact_id">Contact Info</a>
					</li>
				</ul>
				<div class="tab-content" id="dp_tab_content">
					<div class="tab-pane active" id="user_profile_id">
						<table style="width: 265px;">
							<tbody>
								<tr>
									<td><b>Name :</b></td>
									<td id="client-inf-name"></td>
								</tr>
								<tr>
									<td><b>Buyer No:</b></td>
									<td id="client-inf-buyer"></td>
								</tr>
								<tr>
									<td><b>Address:</b></td>
									<td id="client-inf-addr"></td>
								</tr>
								<tr>
									<td><b>Email:</b></td>
									<td id="client-inf-email"></td>
								</tr>
								<tr>
									<td><b>Type:</b></td>
									<td id="client-inf-type"></td>
								</tr>
								<tr>
									<td><b>Supervisor:</b></td>
									<td id="client-inf-spvsr"></td>
								</tr>
								<tr>
									<td><b>Company:</b></td>
									<td id="client-inf-cmpny"></td>
								</tr>
								<tr>
									<td><b>Web:</b></td>
									<td id="client-inf-web"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="tab-pane" id="client_contact_id">
						<table style="width: 265px;">
							<tbody>
								<tr>
									<td><b>Name :</b></td>
									<td id="cntct-inf-name"></td>
								</tr>
								<tr>
									<td><b>Phone:</b></td>
									<td id="cntct-inf-phn"></td>
								</tr>
								<tr>
									<td><b>Mobile:</b></td>
									<td id="cntct-inf-mobile"></td>
								</tr>
								<tr>
									<td><b>Mobile:</b></td>
									<td id="cntct-inf-hm"></td>
								</tr>
								<tr>
									<td><b>Mobile:</b></td>
									<td id="cntct-inf-ofc"></td>
								</tr>
								<tr>
									<td><b>Email:</b></td>
									<td id="cntct-inf-email"></td>
								</tr>
								<tr>
									<td><b>Fax:</b></td>
									<td id="cntct-inf-fax"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>


	</div>
</div>


<style>
.spn1 {
	float: left;
	margin-top: 3px;
}

.spn2 {
	padding: 5px;
	vertical-align: middle;
}

#trackers {
	/*min-height: 300px;*/
	overflow-y: scroll;
	overflow-x: scroll;
	padding: 5px 0 0 5px;
}

.tracker {
	margin: 0;
}

.div header {
	margin: 0;
}

.tracker li {
	background: none repeat scroll 0 0 #EEEEEE;
	border-radius: 3px 3px 3px 3px;
	box-shadow: 0 0 0 1px #F8F8F8 inset, 0 0 0 1px #CCCCCC;
	display: inline-block;
	line-height: 18px;
	margin: 0 0 0 -3px;
	padding: 5px;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.6);
	width: 265px;
}

.mapTracker {
	width: 20px;
}

.tracker li a {
	color: #000;
	text-decoration: none;
	font-size: .8em;
	padding: 5px;
	vertical-align: middle;
}

.tab-pane table tbody tr td {
	border: 1px solid #DDDDDD;
	width: 120px;
	font-size: .8em;
	overflow: hidden;
	white-space: nowrap;
	padding: 2px;
	border-radius: 2px 2px 2px 2px;
	font-size: .8em;
}

.box header h5 {
	margin: 5px 0 5px 15px;
}

#dp_tab_content {
	padding: 5px;
}
</style>
<script type="text/javascript">
var VTS_LEFT={
	deviceids: new Array(),
	device_profiles:null,
	selected_device_id : null,
	selected_device_type : "PT",
	selected_device_name : "",
	searchType : "",
	
		
	drawTracker:function (f){
		$("#searchTrackerText").val();
		var c = 'ash';
		if(f.ClientDevice.active){
			c = 'grn';
		}else{
			c = 'red';
		}
		
		var v = '';
		var icn = 'human';
		if(f.DeviceType.name=='VT')
		{
			icn = f.VehicleType.name;
		}	

		v += '<li class="menu-ajax"><a title = "Show tracker History" href="<?php echo $this->webroot;?>trackerTracks/callcenterHistory/'+f.ClientDevice.deviceid+'/'+icn+'" target="_blank" class="tracker-btn" id="'+f.ClientDevice.deviceid+'"><i class="icon-external-link"></i></a><a class="lnkTracker" href="javascript:;" id="'+f.ClientDevice.deviceid+'">';
		if(f.DeviceType.name=='VT')
		{
			v += '<span class="sn1"><i class="icon-road"></i>';
		}
		else
		{
			v += '<span class="spn1"><i class="icon-user"></i>';
		}
		//v += '</span><span class="spn2"><strong>'+f.ClientDevice.name+' ('+f.DeviceType.name+')</strong></span></a></li>';
		v += 'N</span><span class="spn2"><strong>'+f.ClientDevice.name+'</strong></span></a>('+f.ClientDevice.deviceid+') </li>';

		$('#trackers').append(v);
		VTS_LEFT.deviceids.push('"'+f.ClientDevice.deviceid+'"');
	},

	displayProfile:function ()
	{
		VTS_CALL_CENTER.clearMarkers();
		if (infoBubble.isOpen()) {
			infoBubble.close();
		}
		var dp_index = 0;
		var id = '';
		var did = $(this).attr('id');
		$("#selDevices").select2('val', did);
		$.each(device_profiles, function(i){
			id = device_profiles[i].ClientDevice.deviceid;
			if(id == did)
			{
				dp_index = i;
			}
		}); 
		
		APP_HELPER.ajaxSubmitDataCallback('trackerTracks/get_selected_device_profile_json/'+did,'',function(data)
		{
			var device_info = data['DeviceProfiles']['DeviceProfiles'][0];
			var device_client_info = data['DeviceProfiles']['ClientProfile'][0];
			VTS_LEFT.initDeviceInfo(device_info, device_client_info);
			
			VTS_LEFT.selected_device_name = device_info.ClientDevice.name;
			//
			APP_HELPER.ajaxSubmitDataCallback('trackerTracks/livetrackerjson/'+did,'',function(v)
			{
				if(v.vehicleLat == "0.0" || v.vehicleLng == "0.0")
					return;
			
				if($('#callcenter_map').length == 0){
					APP_HELPER.ajaxSubmitDataCallback('dashboard/dashboard','',function(view)
						{
						$("#ajax-content").html(view);
						v = v.DeviceStatus;
						VTS_LEFT.initCurrentStatus(v);
						var lbl = "human";
						if (device_profiles[dp_index].DeviceType.name == "VT")
						{
							lbl = device_profiles[dp_index].VehicleType.name;
						}
						VTS_LEFT.selected_device_type = lbl;
						var icon = MAP_HELPER.getMarkerImg(lbl,v.vehicleSpeed, v.ignitionStatus);

						var data = MAP_HELPER.getInfoBubbleData2(v);
						var dt = {
							latLng : [ v.vehicleLat, v.vehicleLng ],
							data : data,
							id : v.deviceid,
							tag : v.deviceid,
							options : {
								draggable : false,
								icon : icon
							}
						};
						
						MAP_HELPER.putMarkerOnMap('#callcenter_map', dt);
						VTS_CALL_CENTER.focusMarkerById(v.deviceid);
						});
				}
				else{
					v = v.DeviceStatus;
					VTS_LEFT.initCurrentStatus(v);
					var lbl = "human";
					if (device_profiles[dp_index].DeviceType.name == "VT")
					{
						lbl = device_profiles[dp_index].VehicleType.name;
					}
					VTS_LEFT.selected_device_type = lbl;
					var icon = MAP_HELPER.getMarkerImg(lbl,v.vehicleSpeed, v.ignitionStatus);

					var data = MAP_HELPER.getInfoBubbleData2(v);

					var dt = {
						latLng : [ v.vehicleLat, v.vehicleLng ],
						data : data,
						id : v.deviceid,
						tag : v.deviceid,
						options : {
							draggable : false,
							icon : icon
						}
					};
					
					MAP_HELPER.putMarkerOnMap('#callcenter_map', dt);
					VTS_CALL_CENTER.focusMarkerById(v.deviceid);
					}
			});		
		});
	},

	deviceTrackerLoadDetail:function(){
		VTS_CALL_CENTER.clearMarkers();
		if (infoBubble.isOpen()) {
			infoBubble.close();
		}
		var dp_index = 0;		
		did = device_profiles[0].ClientDevice.deviceid;
		$("#selDevices").select2('val', did);
		
		APP_HELPER.ajaxSubmitDataCallback('trackerTracks/get_selected_device_profile_json/'+did,'',function(data)
		{
			var device_info = data['DeviceProfiles']['DeviceProfiles'][0];
			var device_client_info = data['DeviceProfiles']['ClientProfile'][0];
			VTS_LEFT.initDeviceInfo(device_info, device_client_info);
			
			VTS_LEFT.selected_device_name = device_info.ClientDevice.name;
			//
			APP_HELPER.ajaxSubmitDataCallback('trackerTracks/livetrackerjson/'+did,'',function(v)
			{	
				if(v.vehicleLat == "0.0" || v.vehicleLng == "0.0")
					return;
			
				if($('#callcenter_map').length == 0){
					APP_HELPER.ajaxSubmitDataCallback('dashboard/dashboard','',function(view)
						{
						$("#ajax-content").html(view);
						v = v.DeviceStatus;
						VTS_LEFT.initCurrentStatus(v);
						var lbl = "human";
						if (device_profiles[dp_index].DeviceType.name == "VT")
						{
							lbl = device_profiles[dp_index].VehicleType.name;
						}
						VTS_LEFT.selected_device_type = lbl;
						var icon = MAP_HELPER.getMarkerImg(lbl,v.vehicleSpeed, v.ignitionStatus);

						var data = MAP_HELPER.getInfoBubbleData2(v);
						var dt = {
							latLng : [ v.vehicleLat, v.vehicleLng ],
							data : data,
							id : v.deviceid,
							tag : v.deviceid,
							options : {
								draggable : false,
								icon : icon
							}
						};
						
						MAP_HELPER.putMarkerOnMap('#callcenter_map', dt);
						VTS_CALL_CENTER.focusMarkerById(v.deviceid);
						});
				}
				else{
					v = v.DeviceStatus;
					VTS_LEFT.initCurrentStatus(v);
					var lbl = "human";
					if (device_profiles[dp_index].DeviceType.name == "VT")
					{
						lbl = device_profiles[dp_index].VehicleType.name;
					}
					VTS_LEFT.selected_device_type = lbl;
					var icon = MAP_HELPER.getMarkerImg(lbl,v.vehicleSpeed, v.ignitionStatus);

					var data = MAP_HELPER.getInfoBubbleData2(v);
					var dt = {
						latLng : [ v.vehicleLat, v.vehicleLng ],
						data : data,
						id : v.deviceid,
						tag : v.deviceid,
						options : {
							draggable : false,
							icon : icon
						}
					};
					
					MAP_HELPER.putMarkerOnMap('#callcenter_map', dt);
					VTS_CALL_CENTER.focusMarkerById(v.deviceid);
					}
			});		
		});
	},

	deviceProfileTrackerId : function()
	{
		$("#searchByUserId").val('');
		VTS_LEFT.clearDeviceInfo();
		VTS_LEFT.clearCurrentStatus();
		var trackerId = $("#searchTrackerText").val();
		if(trackerId.length == 0){
			return;
			}
		APP_HELPER.ajaxSubmitDataCallback('clientDevices/getDeviceIdByTrackerId/'+trackerId,'',function(v)
		{
			VTS_LEFT.deviceids = [];	
			var url = 'clientDevices/getDeviceInfo/'+v;			
			APP_HELPER.ajaxSubmitDataCallback(url,'',function(data){
				$('#trackers').empty();
				$.each(data,function(i){
					VTS_LEFT.drawTracker(data[i]);
				});	
				$("#device_count").html(" (Total Devices : " +data.length+" ) ");
				//
				if($('#callcenter_map').length == 1){
					VTS_CALL_CENTER.hideMarkerById();
					$('#callcenter_map').gmap3('clear', 'markers');
					device_profiles = data;
					VTS_CALL_CENTER.loadTrackersInList(data);

					$('.lnkTracker').bind('click',VTS_LEFT.displayProfile);
				}
				else{
					APP_HELPER.ajaxSubmitDataCallback('dashboard/dashboard','',function(view)
					{
							$("#ajax-content").html(view);
							device_profiles = data;
							VTS_CALL_CENTER.loadTrackersInList(data);

							$('.lnkTracker').bind('click',VTS_LEFT.displayProfile);
					});
				}
				VTS_LEFT.deviceTrackerLoadDetail();
			});
		});
		
	},
	
	
	bindTrackers:function ()
	{
		var did = $(this).attr('id');
		APP_HELPER.loadIframe('trackerTracks/singletracker/'+did,'#ajax-content');
	},
	
	displayResult:function (item, val, text) 
	{
	    $('#selectedId').val(val);
	    APP_HELPER.ajaxSubmitDataCallback('trackerTracks/getUserByDeviceOrContact/', {'data':val}, function(user){
			if(user.id.length > 0){
	    	 $('#userId').val(user.id);
	    	 $('#userName').text(user.name);
	    	 $('#usrDiv').show();
	    	 $('#reportId').attr('onclick', "APP_HELPER.ajaxRequestModelAction('reports/index/"+$("#userId").val()+"')");
			}
			else{
				$('#userId').val('');
		    	 $('#userName').text('');
		    	 $('#usrDiv').hide();
				}
		});   
	},

	initDeviceInfo:function(dvInfo, dvClientInfo){

	    $('#lnkTrackerId').html(dvInfo.ClientDevice.name);
		$('#lickr-inf-dtpe').html(dvInfo.DeviceType.name);
		$('#lickr-inf-sddt').html(dvInfo.ClientDeviceSubscription.subscribe_date);
		$('#lickr-inf-exdt').html(dvInfo.ClientDeviceSubscription.expire_date);
		$('#lickr-inf-desc').html(dvInfo.DeviceInfo.name);
		$('#lickr-inf-imei').html(dvInfo.ClientDevice.imei); 
		$('#lickr-inf-cell').html(dvInfo.ClientDevice.mob_no);
		$('#lickr-inf-reg').html(dvInfo.ClientDevice.name);
		$('#lickr-inf-lmt').html(dvInfo.ClientDevice.speed_limit);

		
		$('#client-inf-name').html(dvClientInfo.ClientInfo.name);
		$('#client-inf-buyer').html(dvClientInfo.ClientInfo.buyerno);
		$('#client-inf-addr').html(dvClientInfo.ClientInfo.address);
		$('#client-inf-email').html(dvClientInfo.User.email);
		$('#client-inf-type').html(dvClientInfo.ClientType.name);
		
		if(dvClientInfo.ClientType.name == "GROUP")
		{
			$('#client-inf-spvsr').html(dvClientInfo.ClientInfo.name);
			$('#client-inf-cmpny-type').html(dvClientInfo.CompanyType.name);
			$('#client-inf-cmpny').html(dvClientInfo.ClientInfo.name);
			$('#client-inf-web').html(dvClientInfo.ClientInfo.website);
		}
		else
		{
			$('#client-inf-cmpny-type').html("N/A");
			$('#client-inf-spvsr').html("N/A");
			$('#client-inf-cmpny').html("N/A");
			$('#client-inf-web').html("N/A");
			
		}

		$('#cntct-inf-name').html(dvClientInfo.ClientContact.name);
		$('#cntct-inf-phn').html(dvClientInfo.ClientContact.phone);
		$('#cntct-inf-mobile').html(dvClientInfo.ClientContact.mobile);
		$('#cntct-inf-hm').html(dvClientInfo.ClientContact.mobile_home);
		$('#cntct-inf-ofc').html(dvClientInfo.ClientContact.mobile_office);
		$('#cntct-inf-email').html(dvClientInfo.ClientContact.email);
		$('#cntct-inf-fax').html(dvClientInfo.ClientContact.fax);
		
	},

	clearDeviceInfo:function(){

	    $('#lnkTrackerId').html("");
		$('#lickr-inf-dtpe').html("");
		$('#lickr-inf-sddt').html("");
		$('#lickr-inf-exdt').html("");
		$('#lickr-inf-desc').html("");
		$('#lickr-inf-imei').html(""); 
		$('#lickr-inf-cell').html("");
		$('#lickr-inf-reg').html("");
		$('#lickr-inf-lmt').html("");

		
		$('#client-inf-name').html("");
		$('#client-inf-buyer').html("");
		$('#client-inf-addr').html("");
		$('#client-inf-email').html("");
		$('#client-inf-type').html("");

		$('#client-inf-cmpny-type').html("");
		$('#client-inf-spvsr').html("");
		$('#client-inf-cmpny').html("");
		$('#client-inf-web').html("");

		$('#cntct-inf-name').html("");
		$('#cntct-inf-phn').html("");
		$('#cntct-inf-mobile').html("");
		$('#cntct-inf-hm').html("");
		$('#cntct-inf-email').html("");
		$('#cntct-inf-fax').html("");
		
	},

	initCurrentStatus:function(dvStatus){
		//
		if(dvStatus.ignitionStatus == false){
			$('#dv-stat-status').html("OFF");}
		else{
			$('#dv-stat-status').html("ON");
			}
		
		$('#dv-stat-speed').html(dvStatus.vehicleSpeed + " km");
		$('#dv-stat-lat').html(dvStatus.vehicleLat);
		$('#dv-stat-lng').html(dvStatus.vehicleLng);
		$('#dv-stat-addr').html(dvStatus.nearaddress);
		$('#dv-stat-fuel').html(dvStatus.vehicleFuel);
		$('#dv-stat-odo').html(dvStatus.vehicleOdometer);
		$('#dv-stat-dvtime').html(dvStatus.recordDate +"  "+ dvStatus.recordTime);
		$('#dv-stat-svtime').html(dvStatus.serverDateTime);
		
	},

	clearCurrentStatus:function(){
		//
		$('#dv-stat-status').html("");
		$('#dv-stat-speed').html("");
		$('#dv-stat-lat').html("");
		$('#dv-stat-lng').html("");
		$('#dv-stat-addr').html("");
		$('#dv-stat-fuel').html("");
		$('#dv-stat-odo').html("");
		$('#dv-stat-dvtime').html("");
		$('#dv-stat-svtime').html("");
		
	},

	init:function(){
		
		//APP_COMMON.bindResizeDiv('#trackers',250);
		
		$('#btnTrackerSearch').bind('click',function(){
			VTS_LEFT.deviceProfileTrackerId();
		});
		
		$('#btnSearch').bind('click',function(){

			VTS_LEFT.clearDeviceInfo();
			VTS_LEFT.clearCurrentStatus();

			//
			//
		  	var x = $('#searchByUserId').val();  
		  	var z = $('#userList');  
		  	var val = $(z).find('option[value="' + x + '"]');  
		  	var t = val.attr('id');
		  	//var t = $('#selectedId').val();
			
			if(t==""){
				return;
			}
			//var f = t.split("#");
			//var url = ""; 
			//$('#trackers').html('');
			//if(f[0]=="Contact"){
			//	searchType = f[0];
			//	url = 'clientContactDevices/getDeviceidInfos/'+f[1];	
			//}else if(f[0]=="Device"){
			//	searchType = f[0];
			//	url = 'clientDevices/getDeviceInfo/'+f[1];	
			//}else if(f[0]=="User"){
			//	searchType = f[0];
			url = 'clientDevices/getDeviceInfoByUserId/'+t; //f[1];
			//}
			VTS_LEFT.deviceids = [];				
			APP_HELPER.ajaxSubmitDataCallback(url,'',function(data){
				$('#trackers').empty();
				$.each(data,function(i){
					VTS_LEFT.drawTracker(data[i]);
				});	
				$("#device_count").html(" (Total Devices : " + data.length+" ) ");
				//
				if($('#callcenter_map').length == 1){
					VTS_CALL_CENTER.hideMarkerById();
					$('#callcenter_map').gmap3('clear', 'markers');
					device_profiles = data;
					//$('#selDevices').empty();
					VTS_CALL_CENTER.loadTrackersInList(data);

					$('.lnkTracker').bind('click',VTS_LEFT.displayProfile);
				}
				else{
					APP_HELPER.ajaxSubmitDataCallback('dashboard/dashboard','',function(view)
					{
							$("#ajax-content").html(view);
							device_profiles = data;
							VTS_CALL_CENTER.loadTrackersInList(data);

							$('.lnkTracker').bind('click',VTS_LEFT.displayProfile);
					});
				}
				if(data.length == 1){
					VTS_LEFT.deviceTrackerLoadDetail();
					}
			});
		});
		
// 		$('#searchByUserId').typeahead({
// 	        ajax: { url: APP_URL_ROOT+'trackerTracks/search', triggerLength: 1 },
// 			display: 'name',
// 	        val: 'id',        
// 	        itemSelected: VTS_LEFT.displayResult
// 	    });

	    $('#left').css('width','300px');
	    $('#content').css('margin-left','300px');
	}
};	


$(function(){
	VTS_LEFT.init();
	$('#myTab a').click(function (e) {
		  e.preventDefault();
		  $(this).tab('show');
		});
});

</script>
