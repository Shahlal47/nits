
<!-- BEGIN DUAL SELECT WITH FILTER-->
<div class="row-fluid">
	<div class="span12">
		<div class="box" style="margin-bottom: 0;">
			<header>
				<h5>
					<i class="icon-th-large"></i> Manage Geo-Fences for Devices
				</h5>
				<div class=" pull-right" style="margin: 5px">
					<button id="btnSave" class="btn btn-primary" type="button">
						<i class="icon-save"></i> Save
					</button>
				</div>

			</header>
			<div id="div-3" class="accordion-body collapse in body">
				<?php 
				echo $this->Session->flash(); ?>
				<div>
					<label> Select a Tracker Device </label> <select id="selDevices"
						data-form="select2" style="width: 300px"
						data-placeholder="Select Tracker Registration Number"
						title="Search By Vehicle Registration Number">
						<option value=""></option>
						<optgroup label="Personal Tracker">
						</optgroup>
						<optgroup label="Vahicle Tracker">
						</optgroup>
					</select>
				</div>
				<hr>
				<div class="row-fluid">
					<div style="width: 50%; float: left;">
						<div class="input-append">
							<input id="box1Filter" type="text" placeholder="Filter">
							<button id="box1Clear" class="btn btn-warning" type="button">x</button>
						</div>
						<div class="alert alert-block"
							style="margin-bottom: 2px; padding: 0; width: 80%;">
							<span id="box1Counter" class="countLabel"></span> <select
								id="box1Storage"></select>
						</div>
						<div>
							<select id="box1View" multiple="multiple"
								style="width: 80%; height: 100px; float: left" size="16">
							</select> <br />

							<div
								style="width: 8%; float: left; text-align: center; padding-top: 0%;">
								<div class="btn-group btn-group-vertical"
									style="white-space: normal;">
									<button id="to2" type="button" class="btn btn-primary"
										style="width: 40px;">
										<i class="icon-chevron-right"></i>
									</button>
									<button id="allTo2" type="button" class="btn btn-primary"
										style="width: 40px;">
										<i class="icon-forward"></i>
									</button>
								</div>
							</div>
						</div>



					</div>
					<!-- <div
						style="width: 10%; float: left; text-align: center; padding-top: 0%;">
						<div class="btn-group btn-group-vertical"
							style="white-space: normal;">
							<button id="to2" type="button" class="btn btn-primary"
								style="width: 40px;">
								<i class="icon-chevron-right"></i>
							</button>
							<button id="allTo2" type="button" class="btn btn-primary"
								style="width: 40px;">
								<i class="icon-forward"></i>
							</button>
							<button id="allTo1" type="button" class="btn btn-danger"
								style="width: 40px;">
								<i class="icon-backward"></i>
							</button>
							<button id="to1" type="button" class="btn btn-danger"
								style="width: 40px;">
								<i class=" icon-chevron-left icon-white"></i>
							</button>
						</div>
					</div>
					 -->
					<div style="width: 50%; float: left;">
						<div class="input-append" style="margin-left: 8%;">
							<input id="box2Filter" type="text" placeholder="Filter">
							<button id="box2Clear" class="btn btn-warning" type="button">x</button>
						</div>

						<div class="alert alert-block"
							style="margin-bottom: 2px; padding: 0; width: 80%; margin-left: 8%;">
							<span id="box2Counter" class="countLabel"></span> <select
								id="box2Storage">
							</select>
						</div>
						<div
							style="width: 8%; float: left; text-align: center; padding-top: 0%; margin-top: 20px;">
							<div class="btn-group btn-group-vertical"
								style="white-space: normal;">
								<button id="to1" type="button" class="btn btn-danger"
									style="width: 40px;">
									<i class=" icon-chevron-left icon-white"></i>
								</button>
								<button id="allTo1" type="button" class="btn btn-danger"
									style="width: 40px;">
									<i class="icon-backward"></i>
								</button>

							</div>
						</div>
						<div>
							<select id="box2View" multiple="multiple"
								style="width: 80%; height: 100px;" size="16">
							</select><br />
						</div>

					</div>
				</div>
				<hr>
				<div class="" style="margin-bottom: 10px">
					<button id="btnShow" class="btn btn-inverse" type="button">
						<i class="icon-screenshot"></i> Show Geo-fence
					</button>
				</div>
			</div>
		</div>
		<div id="geofence-map" class="gMap"
			style="height: 380px; border: 1px solid #666"></div>
	</div>

</div>


<script type="text/javascript">
var VTS_GEOFENCE = {
		map : null,
		selectedShape : null,
		// 
		loadTrackersInList : function() {
			var devices = APP_COMMON.getDeviceProfiles();
			for ( var i = 0; i < devices.length; i++) {
				var v = devices[i];
				if (v.DeviceType.name == "PT") {
					var option = '<option value="' + v.ClientDevice.deviceid
							+ '">' + v.ClientDevice.name + '</option>';
					$('#selDevices > optgroup[label="Personal Tracker"]').append(
							option);
				} else {
					var option = '<option value="' + v.ClientDevice.deviceid
							+ '">' + v.ClientDevice.name
							+ '</option>';
					$('#selDevices > optgroup[label="Vahicle Tracker"]').append(
							option);
				}
			}
			$('#selDevices').select2();
		},
		loadGeofences : function(){
			APP_HELPER.ajaxLoadCallback('geofences/get_geo_fences',function(data){

				VTS_GEOFENCE.populateGeoFenceList('#box1View',data);
				$("#box1Counter").text('Showing '+data.length+' of ' +data.length);
			});

		},
		populateGeoFenceList : function(sel,data){
			$(sel).html('');
			$.each(data,function(i){
				var opts = '<option value="'+data[i].Geofence.id+'">'+data[i].Geofence.name+'</option>';
				$(sel).append(opts);	
			});

		},
		loadDeviceGeofences : function(){

		},
		drawShape : function(data){
			if(data.Geofence.geo_shape=="POLYGON"){
				VTS_GEOFENCE.drawPolygon(data);
			}else if(data.Geofence.geo_shape=="CIRCLE"){
				VTS_GEOFENCE.drawCircle(data);
			}else if(data.Geofence.geo_shape=="RECTANGLE"){
				VTS_GEOFENCE.drawRectangle(data);
			}
		},
		drawPolygon : function(data){
	 		var pCoords = [];
	 		var points = JSON.parse( data.Geofence.geofence_points );
	 		$.each(points,function(i){
	 			pCoords.push(new google.maps.LatLng(points[i][0],points[i][1]));
		 	});

	 		VTS_GEOFENCE.selectedShape = new google.maps.Polygon({
            	 map: map,
                 paths: pCoords,
                 strokeColor: data.Geofence.color,
                 strokeOpacity: 0.8,
                 strokeWeight: 1,
                 fillColor: data.Geofence.color,
                 fillOpacity: 0.45,
                 draggable: false,
                 editable: false,
       		                     
                 id:data.Geofence.id,
                 name:data.Geofence.name,
                 geofence_type_id: data.Geofence.geofence_type_id
                 
            });
            google.maps.event.addListener(VTS_GEOFENCE.selectedShape, 'click', function() {
            	// show info box
            });
		},						
		drawCircle : function(data){
	 		var points = JSON.parse( data.Geofence.geofence_points );
			
	 		VTS_GEOFENCE.selectedShape = new google.maps.Circle({
	            map: map,
	            center: new google.maps.LatLng(points[0][0],points[0][1]),
	            fillColor: data.Geofence.color,
	            fillOpacity: 0.45,
	            strokeColor: data.Geofence.color,
	            strokeOpacity: 0.8,
	            strokeWeight: 1,
	            radius: points[1],
	            draggable: false,
	            editable: false,

	            id:data.Geofence.id,
                name:data.Geofence.name,
                geofence_type_id: data.Geofence.geofence_type_id
	  		            
	 		});
            google.maps.event.addListener(VTS_GEOFENCE.selectedShape, 'click', function() {
            	// show info box
            });	
		},						
		drawRectangle : function(data){
	 		var points = JSON.parse( data.Geofence.geofence_points );
			
	 		VTS_GEOFENCE.selectedShape = new google.maps.Rectangle({
			    strokeColor: data.Geofence.color,
			    strokeOpacity: 0.8,
			    strokeWeight: 1,
			    fillColor: data.Geofence.color,
			    fillOpacity: 0.45,
			    map: map,
		        draggable: false,
		        editable: false,
						    
			    bounds: new google.maps.LatLngBounds(
			      			new google.maps.LatLng(points[0][0],points[0][1]), //sw
			      			new google.maps.LatLng(points[1][0],points[1][1])  //ne
			      	   ), 

                id:data.Geofence.id,
                name:data.Geofence.name,
                geofence_type_id: data.Geofence.geofence_type_id
                				     
			}); 
            google.maps.event.addListener(VTS_GEOFENCE.selectedShape, 'click', function() {
            	// show info box
            });	
		},		
		clearSelection : function(){
	        if (VTS_GEOFENCE.selectedShape) {
	            VTS_GEOFENCE.selectedShape.setMap(null);
	          }
		},
		init : function(){
			VTS_GEOFENCE.loadTrackersInList();
			VTS_GEOFENCE.loadGeofences();

			$("#selDevices").on('change', function(e) {
				var id = $('#selDevices option:selected').val();
				APP_HELPER.ajaxSubmitDataCallback('clientDeviceGeofences/get_geo_fences/'+id,'',function(data){
					var b2 = $('#box2View option');
					$('#box1View').append(b2);
					$('#box2View').html('');
					if(data.length>0){
						//VTS_GEOFENCE.populateGeoFenceList('#box2View',data);
						$.each(data,function(i){
							var opt = $('#box1View option[value='+data[i].Geofence.id+']');	
							$('#box2View').append(opt);
						});
						$.each(data,function(i){
							var opt = $('#box1View option[value='+data[i].Geofence.id+']');	
							opt.remove();	
						});			
					}
				});
			});
			$("#btnSave").on('click', function(e) {
				var did = $('#selDevices option:selected').val();
				if(did==''){
					alert('Please select a device!!!'); return;
				}
				var deviceInfo = APP_COMMON.getDeviceProfileByDeviceid(did);
				did = deviceInfo.ClientDevice.id;
				var values = $.map($('#box2View option'), function(e) { return e.value; });
				values.join(',');
				if(values==''){
					alert('Please select at least one geo-fence!!!'); return;
				}
				var data = "did="+did+"&gids=["+values+"]";
					

				APP_HELPER.ajaxSubmitDataCallback('clientDeviceGeofences/save',data,function(data){
						APP_HELPER.ajaxRequestModelAction('clientDeviceGeofences/view');
				});
			});
			$("#box1View").on('click', function(e) {
				$("#box2View option").removeAttr('selected');	
			});
			$("#box2View").on('click', function(e) {
				$("#box1View option").removeAttr('selected');	
			});
			$("#btnShow").on('click', function(e) {
				var id = $('#box1View option:selected').val()?$('#box1View option:selected').val():$('#box2View option:selected').val();
				if(id !== undefined){
					APP_HELPER.ajaxSubmitDataCallback('geofences/get_geo_fence_info/'+id,'',function(data){
						VTS_GEOFENCE.clearSelection();
						VTS_GEOFENCE.drawShape(data);
					});
				}else{
					alert('Please select a geofence!!!'); return;
				}
			});				
		}
};
$(function() {
	APP_COMMON.initPage('Geo-Fence Manager');
	$.configureBoxes();
	var gfmap = MAP_HELPER.initMapFence("#geofence-map");
	VTS_GEOFENCE.init();
	
});
</script>
