<div class="span12 inner">

	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-search"></i>
		</div>
		<h5>Search Client Devices</h5>
		
		</header>
		<div id="div-1" class=" body">
			<div class="input-append">
				<input type="hidden" value="" id="selectedId" />
				<input placeholder="Place to search..." style="width: 200px"
					id="searchText" type="text">
				<button id="btnEdit" class="btn" type="button">
					<i class="icon-edit"></i>
				</button>
			</div>
		</div>
	</div>
		
	<hr>
	<div id="ajaxSearch">
				
	</div>
</div>


<script type="text/javascript">
var VTS_DEV_SEARCH={

	init:function(){
		
		APP_COMMON.bindResizeDiv('#trackers',250);

		$('#btnEdit').bind('click',function(){
			var t = $('#selectedId').val();
			if(t==""){
				return;
			}
			var f = t.split("#");
			var url = ""; 
			$('#trackers').html('');

			if(f[0]=="Device"){
				url = 'clientDevices/edit/'+f[1];	
			}else if(f[0]=="Contact"){
				url = 'clientInfos/showClientInfo?contactid='+f[1];	
			}else if(f[0]=="User"){
				url = 'clientInfos/showClientInfo?userid='+f[1];	
			}else if(f[0]=="ClientInfo"){
				url = 'clientInfos/showClientInfo?clientid'+f[1];	
			}				


			APP_HELPER.ajaxLoad(url,'#ajaxSearch');
		});
		
		$('#searchText').typeahead({
	        ajax: { url: APP_URL_ROOT+'trackerTracks/search', triggerLength: 1 },
			display: 'name',
	        val: 'id',        
	        itemSelected: VTS_DEV_SEARCH.displayResult
	    });

	},
	displayResult:function (item, val, text) {
	    $('#selectedId').val(val);   
	} 
};


$(function(){
	VTS_DEV_SEARCH.init();
});
</script>