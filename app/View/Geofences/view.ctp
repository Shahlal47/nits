<div class="span12">
	<div class="row-fluid">
		<div class="span12">
			<div class="box">
				<header>
					<h5 id="geoeditor-map-title">
						<i class="icon-bullseye"></i> Geo-Fence
					</h5>
					<form id="frmGeofences" class="form-inline"
						style="margin: 0; padding: 5px 10px; float: left;">
						<input id="id" name="id" type="hidden"> <input
							id="geofence_points" name="geofence_points" type="hidden"> <input
							id="geo_shape" name="geo_shape" type="hidden"> <input id="name"
							name="name" type="text" class="input" placeholder="Fence Name"
							data-placement="bottom" data-original-title="Fence Name"
							rel="tooltip">

						<?php echo $this->Form->input('geofence_type_id', array('label'=>false,'div'=>false, 'placeholder'=>"Fence Type", 'data-placement'=>"bottom", 'data-original-title'=>"Fence Type",  'rel'=>"tooltip",  'class'=>'input-large','options'=>$geofenceTypes,'empty'=>'--Select Fence Type--'));?>
						<select id="fence_color" name="color">
							<option value="#1E90FF">Blue</option>
							<option value="#FF1493">Pink</option>
							<option value="#32CD32">Green</option>
							<option value="#FF8C00">Orange</option>
							<option value="#4B0082">Purple</option>
						</select>
						<div class="btn-group">
							<a id="btnSave" data-placement="bottom"
								data-original-title="Save" href="#" rel="tooltip"
								class="btn btn-primary "> <i class="icon-save"></i>
							</a>
						</div>
						<div class="btn-group">
							<a id="btnClear" data-placement="bottom"
								data-original-title="Clear" rel="tooltip" class="btn">
								Clear </a>
						</div>
						<div class="btn-group">
							<a id="btnClearAll" data-placement="bottom"
								data-original-title="Clear All" rel="tooltip"
								class="btn"> Clear All </a>
						</div>
						<div class="btn-group">
							<a id="btnDelete" data-placement="bottom"
								data-original-title="Delete" href="#" rel="tooltip"
								class="btn btn-danger"> <i class="icon-remove"></i>
							</a>
						</div>
					</form>

				</header>
				<div id="div-geofence-list"
					style="padding: 10px; float: left; width: 25%; background-color: #fff; margin: 0; padding: 0;">
					<select id="fence_list" multiple="multiple"
						style="height: 100%; width: 100%; float: left; border-radius: 0;"
						size="16">
					</select>
				</div>
				<div id="geofence-map" class="gMap"
					style="width: 75%; margin: 0; padding-left: 0; float: left;"></div>
			</div>
		</div>

	</div>

</div>
<style type="text/css">
#map,html,body {
	padding: 0;
	margin: 0;
	height: 100%;
}

.color-button {
	width: 14px;
	height: 14px;
	font-size: 0;
	margin: 2px;
	float: left;
	cursor: pointer;
}

.simplecolorpicker.icon {
	border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) #B3B3B3;
	border-image: none;
	border-radius: 4px 4px 4px 4px;
	border-style: solid;
	border-width: 1px;
	box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px
		rgba(0, 0, 0, 0.05);
	color: #333333;
	cursor: pointer;
	display: inline-block;
	font-size: 14px;
	line-height: 20px;
	margin-bottom: 0;
	padding: 4px 12px;
	text-align: center;
	text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
	vertical-align: middle;
}
</style>
<script type="text/javascript">
      var drawingManager;
      var selectedShape;
      var colors = [];
      var selectedColor;
      var drawedShapes = [];

      function clearAllSelection(){
          clearSelection();
		  $.each(drawedShapes,function(i){
			  	if(drawedShapes[i]){
			  		drawedShapes[i].setMap(null);
			  	}
			  	delete drawedShapes[i];
		  });
		  VTS_GEOFENCE_MAN.resetForm();
      }
      function clearSelection() {
        if (selectedShape) {
          selectedShape.setEditable(false);
          selectedShape = null;
        }
      }

      function setSelection(shape) {
       // clearSelection();
        selectedShape = shape;
        shape.setEditable(true);
        selectColor(shape.get('fillColor') || shape.get('strokeColor'));
      }

      function deleteSelectedShape() {
        if (selectedShape) {        	
          selectedShape.setMap(null);
          delete selectedShape;
          selectedShape = null;
        }
      }

      function selectColor(color) {
        selectedColor = color;
        $('#fence_color').simplecolorpicker('selectColor', color);
        
        /*
        var polylineOptions = drawingManager.get('polylineOptions');
        polylineOptions.strokeColor = color;
        drawingManager.set('polylineOptions', polylineOptions);
		*/
        var rectangleOptions = drawingManager.get('rectangleOptions');
        rectangleOptions.fillColor = color;
        drawingManager.set('rectangleOptions', rectangleOptions);

        var circleOptions = drawingManager.get('circleOptions');
        circleOptions.fillColor = color;
        drawingManager.set('circleOptions', circleOptions);

        var polygonOptions = drawingManager.get('polygonOptions');
        polygonOptions.fillColor = color;
        drawingManager.set('polygonOptions', polygonOptions);
      }

      function setSelectedShapeColor(color) {
        if (selectedShape) {
          if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE) {
            selectedShape.set('strokeColor', color);
          } else {
            selectedShape.set('fillColor', color);
          }
        }
      }

       function buildColorPalette() {
         	var options = $('#fence_color option');
         	$.each(options,function(){
				var s = $(this).val();
				colors.push(s);
             });
         	selectColor(colors[0]);
       }

      function initialize() {
        map = new google.maps.Map(document.getElementById('geofence-map'), {
          zoom: 10,
          center: new google.maps.LatLng(23.789720, 90.376460),
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          disableDefaultUI: true,
          zoomControl: true
        });

        var polyOptions = {
          strokeWeight: 1,
          fillOpacity: 0.45,
          draggable: true,
          editable: true
        };
        // Creates a drawing manager attached to the map that allows the user to draw
        // markers, lines, and shapes.
        drawingManager = new google.maps.drawing.DrawingManager({
          //drawingMode: google.maps.drawing.OverlayType.POLYGON,
          drawingControl: true,
          drawingControlOptions: {
              position: google.maps.ControlPosition.TOP_CENTER,
              drawingModes: [
                //google.maps.drawing.OverlayType.MARKER,
                google.maps.drawing.OverlayType.CIRCLE,
                google.maps.drawing.OverlayType.POLYGON,
                //google.maps.drawing.OverlayType.POLYLINE,
                google.maps.drawing.OverlayType.RECTANGLE
              ]
            },
          /*
          markerOptions: {
            draggable: true
          },
          polylineOptions: {
            editable: true
          },*/
          rectangleOptions: polyOptions,
          circleOptions: polyOptions,
          polygonOptions: polyOptions,
          map: map
        });

        google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
            if (e.type != google.maps.drawing.OverlayType.MARKER) {
            // Switch back to non-drawing mode after drawing a shape.
            drawingManager.setDrawingMode(null);

            // Add an event listener that selects the newly-drawn shape when the user
            // mouses down on it.
            $.each(drawedShapes,function(i){
			  	if(drawedShapes[i]){
			  		drawedShapes[i].setMap(null);
			  	}
			  	delete drawedShapes[i];
		  });
            var newShape = e.overlay;
            newShape.type = e.type;
            google.maps.event.addListener(newShape, 'click', function() {
              setSelection(newShape);
            });
            setSelection(newShape);
            drawedShapes.push(newShape);
          }
        });
       
	  
        // Clear the current selection when the drawing mode is changed, or when the
        // map is clicked.
       // google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
       // google.maps.event.addListener(map, 'click', clearSelection);
        //google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);
        
      }
      
    
	var VTS_GEOFENCE_MAN = {
			mapid: 'geofence-map',
			map: null,
			zoomlevel: 14,

			getFormFields : function(){
				var prms = '';
				var id = $('#id').val();

				prms += 'id='+id;
				var geofence_type_id = $('#geofence_type_id').val();
				if(geofence_type_id==''){
					alert('Please input Geo-fence Type'); return '';
				}

				prms += '&geofence_type_id='+geofence_type_id;
				if(selectedShape==null){
					alert('Please draw a geo-fence'); return '';
				}
				var geofence_points = VTS_GEOFENCE_MAN.getShapePoints();

				prms += '&geofence_points='+geofence_points;
				var geo_shape = VTS_GEOFENCE_MAN.getShapeType();

				prms += '&geo_shape='+geo_shape;
				var name = $('#name').val();
				if(name==''){
					alert('Please input Geo-fence Name'); return '';
				}

				prms += '&name='+name;
				var color = $('#fence_color').val();

				prms += '&color='+color;

				//console.debug(prms);
				return prms;
			},
			getShapePoints : function(){
				var shape = VTS_GEOFENCE_MAN.getShapeType();
				var points;
				if(shape=="POLYGON"){
					points = VTS_GEOFENCE_MAN.getPolygonPoints();
				}else if(shape=="CIRCLE"){
					points = VTS_GEOFENCE_MAN.getCirclePoints();
				}else if(shape=="RECTANGLE"){
					points = VTS_GEOFENCE_MAN.getRectanglePoints();
				}
				return JSON.stringify( points );
			},
			getPolygonPoints : function(){
				var pnts = new Array();
				var t = selectedShape.getPaths().getArray();
				 $.each(t,function(i){
				     var tt = t[i].getArray();
				 	$.each(tt,function(i){
				     	//console.debug("("+tt[i].lat()+","+tt[i].lng()+"),");
				     	var latlng = [tt[i].lat(),tt[i].lng()];
				     	pnts.push(latlng);
				     });
				 });				
				return pnts;
			},
			getCirclePoints : function(){
				//console.debug(selectedShape.getCenter()+"  " + selectedShape.getRadius());
				var center = [selectedShape.getCenter().lat(),selectedShape.getCenter().lng()];
				var pnts = [center,selectedShape.getRadius()];
				return pnts;
			},
			getRectanglePoints : function(){
				//console.debug("sw: " + selectedShape.getBounds().getSouthWest() + " , ne:" + selectedShape.getBounds().getNorthEast());
				var sw = [selectedShape.getBounds().getSouthWest().lat(),selectedShape.getBounds().getSouthWest().lng()];
				var ne = [selectedShape.getBounds().getNorthEast().lat(),selectedShape.getBounds().getNorthEast().lng()];
				var pnts = [sw,ne];
				return pnts;
			},
			getShapeType : function(){
				if(typeof selectedShape.getPaths !== 'undefined'){
					return "POLYGON";
	            }else if(typeof selectedShape.getRadius !== 'undefined'){
	            	return "CIRCLE";
	            }else if(typeof selectedShape.getBounds !== 'undefined'){
	            	return "RECTANGLE";
	            }
			},
			loadGeoFences : function(){
				APP_HELPER.ajaxLoadCallback('geofences/get_geo_fences',function(data){

					VTS_GEOFENCE_MAN.populateGeoFenceList(data);

					VTS_GEOFENCE_MAN.resetForm();

					$('#name').fastLiveFilter('#fence_list');
				});
			},
			populateGeoFenceList : function(data){
				
				$('#fence_list').html('');
				$.each(data,function(i){
					var opts = '<option value="'+data[i].Geofence.id+'">'+data[i].Geofence.name+'</option>';
					$('#fence_list').append(opts);	
				});
				
			},
			resetForm : function(){
				$('#id').val('');
				$('#geofence_type_id').val('');
				$('#name').val('');
				$('#geofence_points').val('');				
				$('#geofence_shape').val('');
				$('#color').val('');
			},
			setFormFields : function(data){
				$('#id').val(data.Geofence.id);
				$('#geofence_type_id').val(data.Geofence.geofence_type_id);
				$('#name').val(data.Geofence.name);
				$('#geofence_points').val(data.Geofence.geofence_points);				
				$('#geo_shape').val(data.Geofence.geofence_shape);
				$('#fence_color').simplecolorpicker('selectColor', data.Geofence.color);
				// draw the shape on the map
				
			},
			setFormFields2 : function(id, name, geofence_type_id){
				$('#id').val(id);
				$('#geofence_type_id').val(geofence_type_id);
				$('#name').val(name);				
			},
			drawShape : function(data){
				if(data.Geofence.geo_shape=="POLYGON"){
					VTS_GEOFENCE_MAN.drawPolygon(data);
				}else if(data.Geofence.geo_shape=="CIRCLE"){
					VTS_GEOFENCE_MAN.drawCircle(data);
				}else if(data.Geofence.geo_shape=="RECTANGLE"){
					VTS_GEOFENCE_MAN.drawRectangle(data);
				}
			},
			drawPolygon : function(data){
		 		var pCoords = [];
		 		var points = JSON.parse( data.Geofence.geofence_points );
		 		$.each(points,function(i){
		 			pCoords.push(new google.maps.LatLng(points[i][0],points[i][1]));
			 	});

                var newShape = new google.maps.Polygon({
                	 map: map,
                     paths: pCoords,
                     strokeColor: data.Geofence.color,
                     strokeOpacity: 0.8,
                     strokeWeight: 1,
                     fillColor: data.Geofence.color,
                     fillOpacity: 0.45,
                     draggable: true,
                     editable: false,
           		                     
                     id:data.Geofence.id,
                     name:data.Geofence.name,
                     geofence_type_id: data.Geofence.geofence_type_id
                     
                });
                google.maps.event.addListener(newShape, 'click', function() {
                	VTS_GEOFENCE_MAN.setFormFields2(this.id, this.name, this.geofence_type_id);
   	                setSelection(newShape);
   	            });
                setSelection(newShape);
                drawedShapes.push(newShape);
			},						
			drawCircle : function(data){
		 		var points = JSON.parse( data.Geofence.geofence_points );
				
		        var newShape = new google.maps.Circle({
		            map: map,
		            center: new google.maps.LatLng(points[0][0],points[0][1]),
		            fillColor: data.Geofence.color,
		            fillOpacity: 0.45,
		            strokeColor: data.Geofence.color,
		            strokeOpacity: 0.8,
		            strokeWeight: 1,
		            radius: points[1],
		            draggable: true,
		            editable: false,

		            id:data.Geofence.id,
                    name:data.Geofence.name,
                    geofence_type_id: data.Geofence.geofence_type_id
		  		            
		 		});
	            google.maps.event.addListener(newShape, 'click', function() {
	            	VTS_GEOFENCE_MAN.setFormFields2(this.id, this.name, this.geofence_type_id);
	                setSelection(newShape);
	            });	
	            setSelection(newShape);	   
	            drawedShapes.push(newShape);     
			},						
			drawRectangle : function(data){
		 		var points = JSON.parse( data.Geofence.geofence_points );
				
				var newShape = new google.maps.Rectangle({
				    strokeColor: data.Geofence.color,
				    strokeOpacity: 0.8,
				    strokeWeight: 1,
				    fillColor: data.Geofence.color,
				    fillOpacity: 0.45,
				    map: map,
			        draggable: true,
			        editable: false,
							    
				    bounds: new google.maps.LatLngBounds(
				      			new google.maps.LatLng(points[0][0],points[0][1]), //sw
				      			new google.maps.LatLng(points[1][0],points[1][1])  //ne
				      	   ), 

	                id:data.Geofence.id,
	                name:data.Geofence.name,
	                geofence_type_id: data.Geofence.geofence_type_id
	                				     
				}); 
	            google.maps.event.addListener(newShape, 'click', function() {
	            	VTS_GEOFENCE_MAN.setFormFields2(this.id, this.name, this.geofence_type_id);
	                setSelection(newShape);
	            });	
	            setSelection(newShape);	  
	            drawedShapes.push(newShape);      
			}						
	};
	
	$(function(){
		APP_COMMON.bindResizeDiv('#geofence-map',110);
		APP_COMMON.bindResizeDiv('#div-geofence-list',110);
		initialize();
		$('#fence_color').simplecolorpicker({picker: true});
		APP_COMMON.initPage('Geo-Fence Editor');

		// set color selection
		buildColorPalette();
		$('#fence_color').simplecolorpicker('selectColor', colors[0]);
		// get color on selection
		$('#fence_color').on('change', function() {
		    //console.debug($(this).val());
		    selectColor($(this).val());
		    setSelectedShapeColor($(this).val());
		});

		

		$("#fence_list").on('mouseleave', function(e) {
		    $('#fence_list').popover('destroy');
		});
		$("#fence_list").on('mouseover', function(e) {
		    var $e = $(e.target); 
		    if ($e.is('option')) {
		        $('#fence_list').popover('destroy');
		        $("#fence_list").popover({
		            trigger: 'manual',
		            placement: 'right',
		            //title: $e.attr("data-title"),
		            content: $e.html()
		        }).popover('show');
		    }
		});
		$("#fence_list").on('click', function(e) {//dblclick
			var id = $(this).val();
			deleteSelectedShape();
			APP_HELPER.ajaxSubmitDataCallback('geofences/get_geo_fence_info/'+id,'',function(data){
				//clearSelection();
				clearAllSelection();
				//deleteSelectedShape();
				VTS_GEOFENCE_MAN.drawShape(data);
				VTS_GEOFENCE_MAN.setFormFields(data);
			});
		});

		$("#btnClear").on('click', function(e) {
			deleteSelectedShape();	
		});	
		$("#btnClearAll").on('click', function(e) {
			//clearAllSelection();
			deleteSelectedShape();
			VTS_GEOFENCE_MAN.resetForm();
			VTS_GEOFENCE_MAN.loadGeoFences();
		});	
		$("#btnDelete").on('click', function(e) {

			var id = $('#id').val();
			
			if(id==''){
				alert('No geo-fence tobe is selected to delete!!!'); return false;
			}
			if(confirm("Are you sure you want to delete?")){
				APP_HELPER.ajaxSubmitDataCallback('geofences/delete/'+id,'',function(data){
					//console.debug(data);
					deleteSelectedShape();
					var id = $('#id').val();
					$('#fence_list option[value='+id+']').remove();
					VTS_GEOFENCE_MAN.resetForm();
				});
			}
			else{
				return false;
				}			
		});	
		
		$("#btnSave").on('click', function(e) {
			var data = VTS_GEOFENCE_MAN.getFormFields();
			
				/*if(data!=''){				
					APP_HELPER.ajaxSubmitDataCallback('geofences/save',data,function(data){
						// reload the list
						//VTS_GEOFENCE_MAN.loadGeoFences();
						if($('#id').val()==''){
							//new
							var opts = '<option value="'+data.Geofence.id+'">'+data.Geofence.name+'</option>';
							$('#fence_list').append(opts);	
							
						}else{
							//edit
							$('#fence_list option[value='+data.Geofence.id+']').text(data.Geofence.name);	
						}			
						//console.debug(data);
						deleteSelectedShape();
						VTS_GEOFENCE_MAN.resetForm();	
						//$('#name').fastLiveFilter('#fence_list');	
						var e = jQuery.Event('keypress');
			            e.which = 13; // #13 = Enter key
			            $("#name").focus();
			            $("#name").trigger(e);	
			            
					});
				}
				*/
			deleteSelectedShape();
			if(data!=''){			
				VTS_GEOFENCE_MAN.resetForm();	
				APP_HELPER.ajaxSubmitDataCallback('geofences/save', data, function(r){
					var e = jQuery.Event('keypress');
		            e.which = 13; // #13 = Enter key
		            $("#name").focus();
		            $("#name").trigger(e);
		            APP_HELPER.ajaxLoadCallback('geofences/get_geo_fences',function(list){
			            clearAllSelection();
						VTS_GEOFENCE_MAN.populateGeoFenceList(list);
						$('#name').fastLiveFilter('#fence_list');
						/*VTS_GEOFENCE_MAN.setFormFields(r);
						clearSelection();
						VTS_GEOFENCE_MAN.drawShape(r);*/
						
					});
				});
			}
			else{
				return false;
			}
			
		});
		VTS_GEOFENCE_MAN.loadGeoFences();
		
    });

</script>
