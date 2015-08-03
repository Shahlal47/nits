
<div style="margin: 0;">
	<div class="box dark">
		<header>
		<h5>Search By Place</h5>
		</header>
		<div id="div-1" class=" body">
			<div class="input-append">
				<input placeholder="Place to search..." style="width: 200px"
					id="searchText" type="text">
				<button id="btnSearch" class="btn" type="button">
					<i class="icon-search"></i>
				</button>
			</div>
		</div>
	</div>
	<div class="box dark">
		<input id="selectedId" value="" type="hidden">
		<header>
		<h5>Search Result</h5>
		</header>
		<div id="div-1" class=" body">
			<ul class="tracker" id="trackers">
			</ul>
		</div>
	</div>
</div>
<style>
.spn1{
	float:left;
}
.spn2{
    padding: 5px;
    vertical-align: middle;
}
#trackers {
	min-height: 300px;
	overflow-y: scroll;
	padding: 5px 0 0 5px;
}

.tracker {
	margin: 0;
}

.tracker li {
	background: none repeat scroll 0 0 #EEEEEE;
	border-radius: 3px 3px 3px 3px;
	box-shadow: 0 0 0 1px #F8F8F8 inset, 0 0 0 1px #CCCCCC;
	display: inline-block;
	line-height: 18px;
	margin: 0 0 5px 0;
	padding: 0 10px;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.6);
	width: 230px;
}

.tracker li a {
	color: #000;
	text-decoration: none;
	display: block;
	font-size: .8em;
}
</style>
<script type="text/javascript">
var VTS_LEFT={

	init:function(){
		
		APP_COMMON.bindResizeDiv('#trackers',250);

		$('#btnSearch').bind('click',function(){
			var t = $('#selectedId').val();
			if(t==""){
				return;
			}
			var f = t.split("#");
			var url = ""; 
			$('#trackers').html('');
			if(f[0]=="Contact"){
				url = 'clientContactDevices/getDeviceidInfos/'+f[1];	
			}else if(f[0]=="Device"){
				url = 'clientDevices/getDeviceInfo/'+f[1];	
			}else if(f[0]=="User"){
				//url = 'clientDevices/getDeviceInfo/'+f[1];	
			}				
			APP_HELPER.ajaxSubmitDataCallback(url,'',function(data){
				$.each(data,function(i){
					VTS_LEFT.drawTracker(data[i]);
				});	
				$('.lnkTracker').bind('click',VTS_LEFT.bindTrackers);		
			});
		});
		
		$('#searchText').typeahead({
	        ajax: { url: APP_URL_ROOT+'trackerTracks/search', triggerLength: 1 },
			display: 'name',
	        val: 'id',        
	        itemSelected: VTS_LEFT.displayResult
	    });

	    $('#left').css('width','300px');
	    $('#content').css('margin-left','300px');
	},
	drawTracker:function (f){
		var c = 'ash';
		if(f.ClientDevice.active){
			c = 'grn';
		}else{
			c = 'red';
		}
		var v = '';
		var icn = 'human';
		if(f.DeviceType.name=='VT'){
			icn = f.VehicleType.name;
		}	
		v += '<li><a class="lnkTracker" href="javascript:;" id="'+f.ClientDevice.id+'">';
		v += '<span class="spn1"><img alt="" src="<?php echo $this->webroot;?>img/tracker/32w/'+icn+'-'+c+'.png">';
		v += '</span><span class="spn2"><strong>'+f.ClientDevice.name+' ('+f.ClientDevice.deviceid+')</strong></span></a></li>';

		$('#trackers').append(v);
	},
	bindTrackers:function (){
		var did = $(this).attr('id');
		APP_HELPER.loadIframe('trackerTracks/singletracker/'+did,'#ajax-content');
	},
	displayResult:function (item, val, text) {
	    $('#selectedId').val(val);   
	} 
};


$(function(){
	VTS_LEFT.init();
});
</script>
