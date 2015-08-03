<ul id="menu" class="unstyled accordion collapse in">
<!-- onclick="APP_HELPER.loadIframe('trackerTracks/singletracker','#ajax-content');"  -->
	<li class="menu-ajax"><a href="#/trackerTracks/tracker_live_view"
		>
		<i class="icon-map-marker icon-large"></i> Live-Tracking</a>
	</li>
	<li class="menu-ajax"><a href="#/histories/index">
		<i class="icon-time icon-large"></i> History</a>
	</li>
	<li class="menu-ajax"><a href="#/reports/index/<?php echo $user['id'];?>">
		<i class="icon-time icon-large"></i> Reports</a>
	</li>
 	<li class="accordion-group"><a data-parent="#menu" data-toggle="collapse" class="accordion-toggle"
		data-target="#geo-fences"> 
			<i class="icon-bullseye icon-large"></i> Geo-Fences </a>
		<ul class="collapse" id="geo-fences">
			<li class="menu-ajax"><a href="#/geofences/view">
				<i class="icon-random icon-large"></i> Create Geo-Fences</a>
			</li>
			<li class="menu-ajax"><a href="#/clientDeviceGeofences/view">
				<i class="icon-bullseye icon-large"></i> Assign Geo-Fenches</a>
			</li>	
		</ul>
	</li>
</ul>

