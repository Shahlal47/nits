<div class="media user-media hidden-phone"
	style="background-image: linear-gradient(to bottom, #FFFFFF, #F2F2F2); text-align: center">
	<img src="<?php echo $this->webroot;?>files/logo/<?php echo $logo?>"
		width="96" />
	<div class="clear"></div>
	<br /> <a class="btn btn-inverse btn-mini" href="javascript:;"
		onclick="APP_HELPER.loadIframe('clientInfos/logo/<?php echo $user['client_info_id']?>','#ajax-content');">
		Change Logo</a>
</div>
<ul id="menu" class="unstyled accordion collapse in">
	<li class="menu-ajax"><a href="#/trackerTracks/trackers_summary"> <i
			class="icon-map-marker icon-large"></i> Tracking Summary
	</a>
	</li>
	<li class="menu-ajax"><a href="#/histories/index"> <i
			class="icon-time icon-large"></i> History
	</a>
	</li>
	<li><a href="javascript:;" id="lnkMonitor"> <i
			class="icon-desktop icon-large"></i> Monitor
	</a>
	</li>
	<li class="menu-ajax"><a
		href="#/reports/index/<?php echo $user['id'];?>"> <i
			class="icon-time icon-large"></i> Reports
	</a>
	</li>

	<li class="accordion-group"><a data-parent="#menu"
		data-toggle="collapse" class="accordion-toggle"
		data-target="#geo-fences"> <i class="icon-bullseye icon-large"></i>
			Geo-Fences
	</a>
		<ul class="collapse" id="geo-fences">
			<li class="menu-ajax"><a href="#/geofences/view"> <i
					class="icon-random icon-large"></i> Create Geo-Fences
			</a>
			</li>
			<li class="menu-ajax"><a href="#/clientDeviceGeofences/view"> <i
					class="icon-bullseye icon-large"></i> Assign Geo-Fenches
			</a>
			</li>
		</ul>
	</li>

</ul>
