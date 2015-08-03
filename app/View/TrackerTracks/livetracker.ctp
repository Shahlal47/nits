<?php if($role!="single"){?>
<div class="navbar navbar-static-top" style="border-top: 3px solid #0088CC;">
	<div class="navbar-inner" style="padding: 0px;">
		<div class="container-fluid" style="padding: 0px;">
			<a data-target=".nav-collapse" data-toggle="collapse"
				class="btn btn-navbar"> <span class="icon-bar"></span> <span
				class="icon-bar"></span> <span class="icon-bar"></span> </a> <a
				style="margin: 0 10px; padding: 0;" href="index.html" class="brand"><img
				alt="Nits Logo" src="/nits/assets/img/logo.png"> </a>
		</div>
	</div>
</div>
<?php }?>
<div class="span12" style="margin:0;background-color:#fff">
<div class="span10" id="contact-form" style="padding: 0; margin: 0">
<?php echo $this->element('Dashboard/single_tracker');?>
</div>
<!-- span side-right -->
<div class="span2" style="margin-left: 10px">
	<!-- side-right -->
	
	<div class="sidebar-right">
		<!--sidebar-right-header-->
		<div class="sidebar-right-header">
			<table id="device-info">
				<tbody>
					<tr>
						<td colspan="2"><span class="badge badge-info"><?php if($deviceInfo['DeviceType']['name']=="PT") echo 'Personal Tracker'; else echo 'Vehicle Tracker';?>
						</span></td>
					</tr>
					<tr>
						<td>Ignition:</td>
						<td id="tracker-ignition"><?php 
						if(isset($deviceInfo['DeviceStatus']) && !empty($deviceInfo['DeviceStatus'])){
							if($deviceInfo['DeviceStatus']['ignitionStatus']=="0")
							echo '<span class="badge badge-important">Off';
							else echo '<span class="badge badge-success">On';
						}else{
							echo '<span class="badge badge-important">Off';
						}
						?></span></td>
					</tr>
					<tr>
						<td></td>
						<td id="tracker-moving-status"></td>
					</tr>
				</tbody>
			</table>
			<p class="bold"></p>
		</div>
		<!--/sidebar-right-header-->

		<!-- sidebar-right-content -->
		<div class="sidebar-right-content">
			<div class="tab-content">

				<!--contact-->
				<div class="tab-pane fade active in" id="contact">
					<div class="side-contact">
						<div class="row" style="margin-left: 0px;">
							<h4>Odometer</h4>
							<div id="live-odometer" class="counter1"></div>
							Km
							<h4>Fuel</h4>
							<div id="live-gauge-fuel" class="jgauge"></div>
							<h4>Speed</h4>
							<div id="live-gauge-speed" class="jgauge"></div>

						</div>
					</div>
				</div>
				<!--/contact-->

			</div>
		</div>
		<!-- /sidebar-right-content -->
	</div>
	<!-- /sidebar-right --> 
	<!-- /side-right -->
</div>
</div>
<!-- /span side-right -->
<script>
	
    
    </script>
<style>
.knobd {
	overflow: hidden;
}

.stat-label {
	margin-top: -100px;
}

.side-contact ul.contact-list {
	height: 550px;
	max-height: 550px;
	overflow-y: auto;
	overflow-x: hidden;
}

.side-contact ul.contact-list .contact-alt {
	height: 60px;
}

.side-contact ul.contact-list .contact-alt a {
	height: 52px;
	max-height: 52px;
}

#device-info {
	list-style: none;
	margin: 5px 0 0 5px;
	padding: 0;
}

#device-info li {
	margin: 5px 0 0 0;
}

.sidebar-right>.sidebar-right-header {
	padding: 0;
	height: 80px;
	max-height: 80px;
}

div.jgauge p.label {
	background-color: transparent;
}

.counter1 {
	width: 150px;
	height: 31px;
	border: 1px solid #fff;
	overflow: hidden;
	position: relative;
	background-color: #000;
}

.counter1 img {
	border: 1px solid #eee;
}

.jgauge {
	margin: 0 0 10px 10px !important;
}
.alert_info{
	border-color:#666;
}
</style>
<script>

</script>
