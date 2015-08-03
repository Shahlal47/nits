

<script type="text/javascript">
	var historyData = [];
	<?php 
/*	
	foreach($historyData['data'] as &$hdt){
		echo '{"latLng":["",""],"data":"[][]","speed":}';	
		//echo '{"latLng":["",""],"data":"['.$hdt['serverDateTime']."][".$hdt['distance']."]".$hdt['nearaddress'].'","speed":'.$hdt['vehicleSpeed'].'},';	
	 }*/
	 ?>
	//];

	function loadHistoryDataForAnimation(){
		return historyData;
	}
	$(function() {
		var hdt = JStorageLib.getDeviceHistory();	
		$.each(hdt,function(i){
			var t = { "latLng":[ hdt[i].vehicleLat,hdt[i].vehicleLng], "data": "["+hdt[i].serverDateTime+"]["+hdt[i].distance+"]"+hdt[i].nearaddress,"speed": hdt[i].vehicleSpeed};
			historyData.push(t);
		});
			
	});
</script>
<script type="text/javascript">


var DS_ge;
var DS_geHelpers;
var DS_map;
google.load("earth", "1");

function DS_init() {
  google.earth.createInstance(
    'earth',
    function(ge) {
      DS_ge = ge;
      DS_ge.getWindow().setVisibility(true);
      DS_ge.getLayerRoot().enableLayerById(DS_ge.LAYER_BUILDINGS, true);
      DS_ge.getLayerRoot().enableLayerById(DS_ge.LAYER_BORDERS, true);
      DS_geHelpers = new GEHelpers(DS_ge);
      
      DS_ge.getNavigationControl().setVisibility(ge.VISIBILITY_AUTO);


      var myOptions = {
    	      zoom: 13,
    	      mapTypeId: google.maps.MapTypeId.ROADMAP
    	    };
      DS_map = new google.maps.Map(document.getElementById("map"), myOptions);
      DS_map.setCenter(new google.maps.LatLng(25.760650,
    		  89.222610), 13);
	  
      DS_goDirections();
    },
    function() {
    });

  function onresize() {
    var clientHeight = document.documentElement.clientHeight;

    $('#route-details, #earth, #map').each(function() {
      $(this).css({
        height: (clientHeight - $(this).position().top - 100).toString() + 'px' });      
    });
  }
  
  $(window).resize(onresize);
  onresize();
  
}

google.setOnLoadCallback(DS_init);




</script>

<div class="span12" style="margin:0;background-color:#fff">
		<!-- content-header -->
		<div class="content-header" style="height: 25px;">
			
			<div  class="btn-group btn-group pull-right">
					<button data-original-title="Reset" rel="tooltip"
						data-placement="top" onclick="DS_controlSimulator('reset');"
						type="button" class="btn btn-success">
						<i class="icon-retweet"></i>
					</button>
					<button data-original-title="Start" rel="tooltip"
						data-placement="top" onclick="DS_controlSimulator('start');"
						type="button" class="btn btn-success">
						<i class="icon-play"></i>
					</button>
					<button data-original-title="Pause" rel="tooltip"
						data-placement="top" onclick="DS_controlSimulator('pause');"
						type="button" class="btn btn-success">
						<i class="icon-pause"></i>
					</button>
				</div>
				<div  class="btn-group btn-group pull-right">
					<button data-original-title="Slower" rel="tooltip"
						data-placement="top" onclick="DS_controlSimulator('slower');"
						type="button" class="btn btn-success">
						<i class="icon-minus"></i>
					</button>
					<button data-original-title="Faster" rel="tooltip"
						data-placement="top" onclick="DS_controlSimulator('faster');"
						type="button" class="btn btn-success">
						<i class="icon-plus"></i>
					</button>

				</div>
				<div class="pull-right" style="padding: 5px 10px;">
					Speed: <strong><span id="speed-indicator">1x</span> </strong>
				</div>
				<!-- 
				<ul class="content-header-action pull-right" style="height: 20px;">
				<li><select id="selDevices" data-form="select2" style="width: 200px"
					data-placeholder="Please Select Tracker">
						<option value=""></option>
						<optgroup label="Personal Tracker">
						</optgroup>
						<optgroup label="Vahicle Tracker">
						</optgroup>
				</select>
				</li>
				<li><a class="btn" href="#" data-placement="bottom" rel="tooltip"
					data-original-title="Filter History"
					onclick="VTS_HISTORY.showFilterByDateBox();return false;"> <i
						class="icofont-search"></i> </a>
				</li>
				<li>
				<button data-original-title="Reset" rel="tooltip"
						data-placement="top" onclick="DS_goDirections();"
						type="button" class="btn btn-success">
						go
					</button>
				</li>
				

			</ul>
			 -->
			<h2>
				<i class="icofont-map-marker"></i>Animation
			</h2>

		</div>
		<!-- /content-header -->
		<div class="content-body" style="padding: 0 0 0 10px;">
			<div class="pull-left" style="width: 20%; ">
				<h4>Paths:</h4>
				<div id="route-details"
					style="width: 100%; height: 460px; overflow-y: scroll;">					
				</div>
			</div>
			<table class="pull-left" style="width: 80%; ">
				<tr>
					<td style="width: 200px" valign="top"></td>
					<td style="width: 67%" valign="top">
						<div id="earth" style="border: 1px solid #000; height: 600px;">
					
					</td>
					<td style="width: 33%" valign="top">
						<div id="map" style="border: 1px solid #000; height: 600px;"></div>
					</td>
				</tr>
			</table>
		</div>
	</div>
<style>
#route-details {
	height: 400px;
	position: relative;
	overflow: auto;
	font-size: .8em;
}

#route-details ol {
	margin: 0;
	padding: 0;
}

.dir-step {
	list-style: decimal inside;
	position: relative;
	font-size: small;
	padding-right: 50px !important;
}

.dir-step .note {
	position: absolute;
	top: 0;
	right: 0;
	padding: 6px 3px;
}

.dir-step,#dir-start,#dir-end {
	margin: 0;
	padding: 6px 3px;
	cursor: pointer;
}

#dir-start,#dir-end {
	background-color: #888;
	color: #fff;
}

#dir-start,.dir-step {
	border-bottom: 1px solid #888;
}

.dir-step.sel {
	background-color: #00f;
	color: #fff;
}
</style>

