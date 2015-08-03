<div class="span12">
	<div class="row-fluid">
		<div class="span3">
			<div class="box dark">
				<header>
				<h5>Search By Place</h5>
				<div class="toolbar">
					<ul class="nav">
						<li><a href="#div-1" data-toggle="collapse"
							class="accordion-toggle minimize-box collapsed"> <i
								class="icon-plus"></i> </a>
						</li>
					</ul>
				</div>
				</header>
				<div id="div-1" class="accordion-body collapse body">
					<form>
						<input type="text" placeholder="Place to search..."> <select
							class="">
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
						</select>
						<button type="submit" class="btn btn-small btn-metis-4">search</button>
					</form>
				</div>
				<header>
				<h5>Search By Lat/Lng</h5>
				<div class="toolbar">
					<ul class="nav">
						<li><a href="#div-2" data-toggle="collapse"
							class="accordion-toggle minimize-box collapsed"> <i
								class="icon-plus"></i> </a>
						</li>
					</ul>
				</div>
				</header>
				<div id="div-2" class="accordion-body collapse body">
					<form>
						<input type="text" placeholder="Latitude"> <input type="text"
							placeholder="Longitude">
						<button type="submit" class="btn btn-small btn-metis-4">search</button>
					</form>
				</div>
				<header>
				<h5>Add/Update Geo-Locations</h5>
				<div class="toolbar">
					<ul class="nav">
						<li><a href="#div-3" data-toggle="collapse"
							class="accordion-toggle minimize-box"> <i class="icon-plus"></i>
						</a>
						</li>
					</ul>
				</div>
				</header>
				<div id="div-3" class="accordion-body collapse in body">
					<form id="frmGeoInfo">
						
						<select id="poitype" name="placetype" data-placeholder="Choose POI Type..."
							class="chzn-select span11">						
						</select> 
						<br/>
						<input id="fld_id" name="id" type="hidden">
						<input id="fld_zoomlevel" name="zoomlevel" type="hidden"> 
						<input id="fld_lat" name="lat" type="text" placeholder="Latitude"> 
						<input id="fld_lng" name="lng" type="text"
							placeholder="Longitude">
						<textarea id="fld_address" name="address" placeholder="address" class="" maxlength="140"></textarea>
						
						<textarea placeholder="Remarks" name="remarks" id="fld_remarks" class=""
							maxlength="140"></textarea>
							<input id="fld_img" name="img" type="text"
							placeholder="Image">
						<p>
											
							<button id="btn_delete" class="btn btn-metis-3">delete</button>
							<button id="btn_save" class="btn btn-metis-4">save</button>
						</p>
						<p>
							<button class="btn btn-block btn-metis-5" type="button">Show last
								200 record</button>
							<button class="btn btn-block btn-metis-5" type="button">Show
								total record</button>
						</p>
					</form>
				</div>
			</div>
		</div>
		<div class="span9">
			<div class="box">
				<header>
				<h5 id="geoeditor-map-title"></h5>
				</header>
				<div id="geoeditor-map" class="google-maps" style="height: 500px;"></div>
			</div>
		</div>

	</div>

</div>


<script type="text/javascript">
	var FN_Geoeditor = {
		mapid: 'geoeditor-map',
		map: null,
		zoomlevel: 14,
		markers: [],
		poitypes: [],
		pois: [], // lat, lng, address, placetype, zoomlevel, remarks, tags
		loadGeoeditorNearestData: function(lat,lng){
	        var url = "geoeditor/nearestdatafromdb?lat="+lat+"&lng="+lng;
	    	APP_HELPER.ajaxLoadCallback(url, FN_Geoeditor.drawPOIdata);
	    },
	    clearMarkers : function() {
			clearAllMarker(FN_Geoeditor.mapid);			
		},
		addPOIMarker : function(data) {
			addMarkersInMap(FN_Geoeditor.mapid,data);
		},
	    drawPOIdata: function(data){
	    	FN_Geoeditor.pois = JSON.parse(data);
			$.each(FN_Geoeditor.pois,function(index, value){
				FN_Geoeditor.addPOIMarker(value);
	    	});				
	    },
	    loadPOItypes: function(data){
	    	FN_Geoeditor.poitypes = JSON.parse(data);
	    	var poiselvals = '';
	    	$.each(FN_Geoeditor.poitypes,function(index, value){
	    	    poiselvals += '<option value="'+value.PoiType.id+'">'+value.PoiType.name+'</option>';
	    	});
	    	$('#poitype').html(poiselvals);
			$(".chzn-select").select2();
	        			    	
		},
		getPOItype:function(i){
			var marker = 'accident';
			$.each(FN_Geoeditor.poitypes,function(index, value){
	    	    if(value.PoiType.id==i){
					marker = value.PoiType.marker;
					return;
	    	    }
	    	});
	    	return marker;
		},
		addPOIMarker: function(data){
			var icon;
			if(data[4]==-1){
				icon = '<?php echo $this->webroot?>assets/mapicons/icons/accident.png';
			}else{					
				icon = '<?php echo $this->webroot?>assets/mapicons/icons/'+FN_Geoeditor.getPOItype(data[4])+'.png';
			}
			
			var info = getInfoBubbleDataGeo(data[3]);
			var dt = {
					latLng : [ data[1], data[2] ],
					data : info,
					id : data[0],
					options : {
						icon : icon
					}
				};
			addMarkerWithCallback(FN_Geoeditor.mapid, dt, this.onClickMarker);
		},
		showZoomLevel: function(){
	        var zoomLevel = FN_Geoeditor.map.getZoom();
			$('#geoeditor-map-title').html('Google Map (Zoom Level: '+zoomLevel+')');
			FN_Geoeditor.zoomlevel = zoomLevel;
			$('#fld_zoomlevel').val(zoomLevel);
		},
		onClickMarker: function(marker){
			var lat = marker.getPosition().lat().toFixed(9);
			var lng = marker.getPosition().lng().toFixed(9);
			var data = 	FN_Geoeditor.getLocalPOIdata(lat,lng);
			if(data==null){
				data = ['new', lat, lng, '', -1, FN_Geoeditor.zoomlevel, '', ''];
			}			
			FN_Geoeditor.populateForm(data);
			
		},
		populateForm: function(data){
			$('#fld_id').val(data[0]);
			$('#fld_lat').val(data[1]);
			$('#fld_lng').val(data[2]);
			$('#poitype').val(data[4]).trigger('liszt:updated');
			$('#fld_address').val(data[3]);
			$('#fld_remarks').val(data[6]);
			$('#fld_img').val(data[8]);				
		},
		emptyForm: function(data){
			$('#fld_id').val('');
			$('#fld_lat').val('');
			$('#fld_lng').val('');
			$('#poitype').val('');
			$('#fld_address').val('');
			$('#fld_remarks').val('');	
			$('#fld_img').val('');			
		},
		getLocalPOIdata: function(lat,lng){
			var dt = null;
			$.each(FN_Geoeditor.pois,function(index, value){
				if(value[1]==lat && value[2]==lng){
					dt = value;
					return;
				}
	    	});
	    	return dt;
		},
		getPOIid: function(lat,lng){
			var id = null;
			$.each(FN_Geoeditor.pois,function(index, value){
				if(value[1]==lat && value[2]==lng){
					id = value[0];
				}
	    	});
	    	return id;
		},
		changeMarkerIcon: function(s){
			
			var v = $(s).val();
			var id = $('#fld_id').val();
			var pt = FN_Geoeditor.getPOItype(v);
			var icon = '<?php echo $this->webroot?>assets/mapicons/icons/'+pt+'.png';				
			changeMarkerIcon(FN_Geoeditor.mapid, id, icon);
		},
		init:function(){
	        var url = "poiTypes/getjson";

	        APP_COMMON.bindResizeDiv('#'+FN_Geoeditor.mapid,110);
	        
	    	APP_HELPER.ajaxLoadCallback(url, FN_Geoeditor.loadPOItypes);
	    	
	    	FN_Geoeditor.map = MAP_HELPER.initMap('#'+FN_Geoeditor.mapid);
	    	
		    FN_Geoeditor.map.setZoom(14);
		    FN_Geoeditor.showZoomLevel();
		    google.maps.event.addListener(FN_Geoeditor.map, 'zoom_changed', function() {
		    	FN_Geoeditor.showZoomLevel();	    	
		    });
		    google.maps.event.addListener(FN_Geoeditor.map, 'click', function(e) {
		    	FN_Geoeditor.clearMarkers();
		    	FN_Geoeditor.loadGeoeditorNearestData(e.latLng.lat(), e.latLng.lng());
		    	
		    	var data = ['new', e.latLng.lat().toFixed(9), e.latLng.lng().toFixed(9), '', -1, FN_Geoeditor.zoomlevel, '', ''];
		    	FN_Geoeditor.addPOIMarker(data);
		    	// populate the form
		    	FN_Geoeditor.populateForm(data);
		    });

			$('#poitype').bind('change', function() {
				FN_Geoeditor.changeMarkerIcon(this);
				return false;
			});	
			$('#btn_delete').bind('click', function() {
				if($('#fld_id').val()=='')
					$('#fld_id').val('new');
				var result = confirm("Are sure you want to delete ?");
				if (result==false) {
					return false;
				}else{
					if($('#fld_id').val()=='new'){
						alert('Invalid record!!!');
						return false;
					}
					var data = $('#frmGeoInfo').serialize();
					var url = '/geoeditor/delete';
					APP_HELPER.ajaxSubmitDataCallback(url,data, function(data){				
						var lat = $('#fld_lat').val();				
						var lng = $('#fld_lng').val();
						FN_Geoeditor.emptyForm();
				    	FN_Geoeditor.clearMarkers();
				    	FN_Geoeditor.loadGeoeditorNearestData(lat, lng);					
					});
				}
				return false;
			});
			$('#btn_save').bind('click', function() {
				// get the data
				if($('#fld_id').val()=='')
					$('#fld_id').val('new');
				
				if($('#fld_lat').val()==''){
					alert('Latitude cannot be empty!!!');
					return false;
				}
				if($('#fld_lng').val()==''){
					alert('Longitude cannot be empty!!!');
					return false;
				}
				if($('#fld_address').val()==''){
					alert('Address cannot be empty!!!');
					return false;
				}
				if($('#poitype').val()==-1){
					alert('Please select a place type!!!');
					return false;
				}
				
				var data = $('#frmGeoInfo').serialize();
				var url = '/geoeditor/save';
				APP_HELPER.ajaxSubmitDataCallback(url,data, function(data){				
					var lat = $('#fld_lat').val();				
					var lng = $('#fld_lng').val();
			    	FN_Geoeditor.clearMarkers();
			    	FN_Geoeditor.loadGeoeditorNearestData(lat, lng);	
			    					
				});
				// save the data
				return false;
			});	
		}
	};
	
	$(function(){
		FN_Geoeditor.init();
    });

</script>
