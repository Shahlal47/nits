<?php	//$deviceInfo = $this->requestAction('deviceprofiles/get_all_devices_profile');
//pr($deviceInfo['DeviceStatus']);
foreach($deviceInfo['DeviceProfiles'] as &$device){
	//$vr =  $device['Deviceprofile']['registration_number'];
	$vt = "human";
	$deviceid = $device['Deviceprofile']['deviceid'];
	$hname = "";
	$clr = "ash";
	if(isset($deviceInfo['DeviceStatus'][''.$deviceid])){
		if($deviceInfo['DeviceStatus'][''.$deviceid]['ignitionStatus']==0
		&& $deviceInfo['DeviceStatus'][''.$deviceid]['vehicleSpeed']==0)
		{$clr = "red";}
		else if($deviceInfo['DeviceStatus'][''.$deviceid]['ignitionStatus']==0
		&& $deviceInfo['DeviceStatus'][''.$deviceid]['vehicleSpeed']>0)
		{$clr = "org";}
		else if($deviceInfo['DeviceStatus'][''.$deviceid]['ignitionStatus']==1
		&& $deviceInfo['DeviceStatus'][''.$deviceid]['vehicleSpeed']==0)
		{$clr = "blu";}
		else if($deviceInfo['DeviceStatus'][''.$deviceid]['ignitionStatus']==1
		&& $deviceInfo['DeviceStatus'][''.$deviceid]['vehicleSpeed']>0)
		{$clr = "grn";}
	}
	if($device['Deviceprofile']['device_type']=="PT"){
		$hname = $device['Deviceprofile']['person_name'];
	}else{
		if($device['Deviceprofile']['vehicle_type_id']){
			$vt = $device['VehicleType']['name'];
		}
		$hname = $device['Deviceprofile']['registration_number'];
	}
	?>

<li class="contact-alt " id="li-d08007090"><a href="#" class="ll"
	style="width: 175px; float: left;"
	onclick="focusMarkerById('<?php echo $deviceid?>');return false;">
		<div class="contact-item">
			<div class="pull-left">
				<img class="contact-item-object v-icon"
					id="img-<?php echo $deviceid?>" style="width: 50px; height: 50px;"
					src="<?php echo $this->webroot;?>img/tracker/64/<?php echo $vt."-".$clr?>.png">
			</div>
			<div class="contact-item-body">

				<p class="contact-item-heading bold v-registrationno"
					style="white-space: normal !important; line-height: 11px; font-size: 1opx;">

					<?php echo $hname?>
					
				</p>

				<div class="btn-group btn-group pull-right" style="margin-top: 8px;">
					<button class="btn shw" type="button" style="padding: 0 2px;"
						onclick="openTrackerNewTab('<?php echo $deviceid?>');return false;"
						data-placement="left" rel="tooltip" data-original-title="Live">
						<i class="icon-share"></i>
					</button>
					<button class="btn shw" type="button" style="padding: 0 2px;"
						onclick="openTrackerInfoBox('<?php echo $deviceid?>');return false;"
						data-placement="left" rel="tooltip" data-original-title="Details">
						<i class="icon-th-large"></i>
					</button>
				</div>
			</div>
		</div> </a> <!-- 
	<div class="btn-group btn-group-vertical" style="margin-top: 8px;margin-left: 0;">
		<button class="btn shw" type="button" style="padding: 0 2px;"
			onclick="focusMarkerById('<?php echo $deviceid?>');return false;" data-placement="left" rel="tooltip"
			data-original-title="Focus the Marker">
			<i class="icon-screenshot"></i>
		</button>
		<button class="btn shw" type="button" style="padding: 0 2px;"
			data-placement="left" rel="tooltip"
			data-original-title="Alerts">
			<i class="icon-bullhorn"></i>
		</button>
	</div>
	 -->
</li>
					<?php }?>
