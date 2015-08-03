<?php	//$deviceInfo = $this->requestAction('deviceprofiles/get_all_devices_profile');?>
<div class="span10" id="contact-form">
	<div id="modal-place-holder">
	<?php //echo $this->element('Dashboard/tracker_info');?>
	</div>

	<?php echo $this->element('Dashboard/single_tracker');?>

</div>
<!-- span side-right -->
<div class="span2">
	<!-- side-right -->
	<aside class="side-right"> <!-- sidebar-right -->
	<div class="sidebar-right">
		<!--sidebar-right-header-->
		<div class="sidebar-right-header">
			<ul id="device-info">
				<li class="bold"><span class="badge badge-info">Personal Trakcer</span>
				</li>
				<li class="bold">Ignition: <span class="badge badge-important">off</span>
				
				</li>
			</ul>
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
							
							<p>
								087878.60 Kms<br /> 087878.60 Miles
							</p>
							<input class="knob" data-readOnly="true" data-angleOffset="-125"
								data-width="150" data-angleArc="250" data-fgColor="#66EE66"
								value="35">

							<div class="stat-label grd-green color-white">Fuel</div>
							<p></p>
							<input class="knob" data-readOnly="true" data-angleOffset="-125"
								data-width="150" data-angleArc="250" data-fgColor="#AC193D"
								value="35">
							<div class="stat-label grd-red color-white">Speed</div>
						</div>

						<!--contact-list, we set this max-height:380px, you can set this if you want-->
						<ul class="contact-list" id="d-tracker-list">
						<?php //echo $this->element('Dashboard/tracker_list',array('deviceInfo' => $deviceInfo));?>

						</ul>
						<!--/contact-list-->
					</div>
				</div>
				<!--/contact-->

			</div>
		</div>
		<!-- /sidebar-right-content -->
	</div>
	<!-- /sidebar-right --> </aside>
	<!-- /side-right -->
</div>

<!-- /span side-right -->
						<?php echo $this->Html->script(
						array(
                      'lib/knob/jquery.knob.js'
                      ));
                      ?>
<script>
    $(document).ready(function(){
    	/*
    	//$('#myTab a:last').tab('show');
    	$('#myTab a').click(function (e) {
		    e.preventDefault();
			    $(this).tab('show');
		    });
    	//$("input[data-chart=knob]").knob();
    	$(".knob").knob();
    	$('#d-tracker-list a.ll').click(function (e) {
		    e.preventDefault();
		    	if($(this).parent().hasClass('active')){
		    		// remove marker of device from the map	
		    		$(this).parent().removeClass('active');
		    	}
		    	else{
				    $(this).parent().addClass('active');
				    // add marker of device from the map
		    	}
		    	
		    });
    	$('#drp-dwn').dropdown();
    	$('.shw').tooltip();
    	*/
    	$(".knob").knob();
	});
	function closeModal(){
		$("#modal-place-holder").hide();
	}
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
</style>
<script>

</script>
