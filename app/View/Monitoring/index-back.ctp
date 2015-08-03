<?php	$deviceInfo = $this->requestAction('deviceprofiles/get_all_devices_profile');?>
<!-- span content -->
<div class="span12">
	<!-- content -->
	<div class="content" style="margin-left: 0">
		<!-- content-header -->
		<div class="content-header">



			<ul class="content-header-action pull-right" id="tracker-list">
			<?php foreach($deviceInfo['DeviceProfiles'] as &$device){
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
				<li id="<?php echo $deviceid?>"><a href="javascript:void(0);"> <img
						width="42" height="42"
						src="img/tracker/64/<?php echo $vt."-".$clr?>.png"
						alt="<?php echo $vt."-".$clr?>" />
						<div class="action-text color-green">
						<?php echo $deviceid?>
						</div> </a>
				</li>
				<?php }?>
			</ul>
			
			<h2>
				<i class="icofont-th"></i> 
				 Monitor Trackers
<button class="btn btn-primary" type="submit">Add Map</button>
			</h2>
		</div>
		<!-- /content-header -->



		<!-- content-body -->
		<div class="content-body" style="padding: 10px;">
			<!-- grids -->

			<!-- span4-->
			<div class="row-fluid" id="column-1">
				<div class="span4 map-container" id="1">
                                    <div class="box corner-all">
                                        <div class="box-header grd-white">
                                            <div class="header-control">
                                                <img width="32" height="32" src="" alt=""/>                                            
											</div>
                                            <span id="1-title">Map</span>											
                                        </div>
                                        <div class="box-body">
                                             <p>Please drag n drop a tracker...</p>
                                        </div>
                                    </div>
				</div>
				<div class="span4 map-container" id="2"></div>
				<div class="span4 map-container" id="3"></div>
			</div>
			<!-- span4-->
			<div class="row-fluid " id="column-2">
				<div class="span4 map-container" id="4"></div>
				<div class="span4 map-container" id="5"></div>
				<div class="span4 map-container" id="6"></div>
			</div>
			<!-- span4-->

			<!--/grids-->
		</div>
		<!--/content-body -->
	</div>
	<!-- /content -->
</div>
<!-- /span content -->

<script type="text/javascript">
	var VTS_MONITOR_device_status = <?php echo json_encode($deviceInfo['DeviceStatus']);?>;
	var VTS_MONITOR_device_profiles = <?php echo json_encode($deviceInfo['DeviceProfiles']);?>;

            $(document).ready(function() {
                $("#tracker-list li").draggable({
                    //appendTo: "body",
                    helper: "clone"
                  });
                
                $( ".map-container" ).droppable({
                    drop: function( event, ui ) {
              	    var mrkr = ui.draggable.attr("id");
              		var id = $(this).attr("id");
              		$("#"+id+"-title").html("Map-"+mrkr);
              		initMap(id);
                    }
                  });
              	
              	
              	
              	
            });
            function initMap(id){
            	$('#'+id+'-map').gmap3('destroy').remove();
          		var mp = '<div id="'+id+'-map" class="gmap3" style="width: 100%; height: 220px; overflow: hidden;"></div>';
          		$("#"+id+" .box-body").html(mp);
            	$('#'+id+'-map').gmap3({
                    marker:{
                      address: "Haltern am See, Weseler Str. 151"
                    },
                    map:{
                      options:{
                        zoom: 14
                      }
                    }
                  });
    		}
		function createMapPortlets(sl){
			var v = $(sl).val();
			clearAllMapPortlets();
			for(var i=2;i<=v;i++){
				$("#"+i).html(getContentForPortal(i));
			}
		}
		
		function getContentForPortal(id){
			var contents = '<div class="box corner-all">'+
								'<div class="box-header grd-white">'+
									'<div class="header-control">'+
										'<img width="32" height="32" src="" alt="" />'+
									'</div>'+
									'<span id="'+id+'-title">Map</span>'+
								'</div>'+
								'<div class="box-body">'+
									'<p>Please drag n drop a tracker...</p>'+
								'</div>'+
							'</div>';			
			return contents;			
		}
		function clearAllMapPortlets(){
			$('#1-map').gmap3('destroy').remove();
			$("#1 .box-body").html('<p>Please drag n drop a tracker...</p>');
        				
			for(var i=2;i<=6;i++){
            	$('#'+i+'-map').gmap3('destroy').remove();				
				$("#"+i).html("");
			}
		}
		var numOfPortlets = 1;
     	function addPortlet(){
			numOfPortlets++;
			if(numOfPortlets==2){

			}						
			if(numOfPortlets==3){

			}						
			if(numOfPortlets==4){

			}						
			if(numOfPortlets==5){

			}						
			if(numOfPortlets==6){

			}						
        }
        </script>
