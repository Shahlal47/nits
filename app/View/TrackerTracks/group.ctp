<div class="span10" id="contact-form">
	<div id="modal-place-holder">
	<?php echo $this->element('Dashboard/tracker_info');?>
	</div>
	<div class="content" style="margin-top: 0">
	<!-- content-header -->
	<div class="content-header" style="height: 20px;padding:5px 20px 15px;">
		<ul class="content-header-action pull-right" style="height: 20px;">

			<li><a id="btn-live-view" class="btn" href="#"
				onclick="toggleCluster('group_cluster_map',this); return false;"
				data-toggle="buttons-checkbox"><i class="icon-th"></i>
			</a></li>
<!-- 
			<li><a class="btn" href="#"><i class="icofont-refresh"></i>
			</a></li>

			<li><a class="btn" href="#"><i class="icofont-fullscreen"></i>
			</a></li> -->
		</ul>
		<h2 style="line-height:20px;">
			<i class="icofont-map-marker"></i>Live Tracker View
		</h2>

	</div>
	<!-- /content-header -->

	<!-- content-body -->
	<div class="content-body" style="padding: 0 0 0 10px;">
		<!-- form -->
		<div class="row-fluid">
			<div class="span12">
				<div id="group_cluster_map" class="gMap" style="width: 100%; height: 560px;"></div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="span2">
	<aside class="side-right">
	<div class="sidebar-right">
		<!--sidebar-right-header-->
		<div class="sidebar-right-header">
			<div class="sr-header-right">
				<h2>
					<span class="label label-info" id="numberOfDevices"
						style="font-size: 2em; padding: 10px;"> </span>
				</h2>
			</div>
			<div class="sr-header-left">
				<p class="bold" style="text-align: right;">Total Trackers</p>
			</div>
		</div>
		<div class="sidebar-right-content">
			<div class="tab-content">
				<div class="tab-pane fade active in" id="contact">
					<div class="side-contact">
						<ul class="contact-list" id="d-tracker-list">
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>



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

.cluster {
	color: #FFFFFF;
	text-align: center;
	font-family: 'Arial, Helvetica';
	font-size: 11px;
	font-weight: bold;
}

.cluster-1 {
	background-image: url(<?php echo $this->webroot;?>img/tracker/m1.png);
	line-height: 53px;
	width: 53px;
	height: 52px;
}

.cluster-2 {
	background-image: url(<?php echo $this->webroot;?>img/tracker/m2.png);
	line-height: 53px;
	width: 56px;
	height: 55px;
}

.cluster-3 {
	background-image: url(<?php echo $this->webroot;?>img/tracker/m3.png);
	line-height: 66px;
	width: 66px;
	height: 65px;
}

.label-number-plate {
	color: #000;
	background-color: #fff; /*#498af3; #d33e3e, #75c200*/
	font-family: "Lucida Grande", "Arial", sans-serif;
	font-size: 11px;
	font-weight: bold;
	text-align: left;
	border: 1px solid black;
	padding: 2px 5px;
	white-space: nowrap;
	border-radius: 5px;
	box-shadow: inset 0 0 2px #000000;
}
.side-right{
	margin-top:0!important;
}
</style>
<?php echo $this->Html->script(array('dashboard/group'));?>
