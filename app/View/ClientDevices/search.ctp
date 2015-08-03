<div class="span12 inner">

	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-search"></i>
			</div>
			<h5>Search Client Information</h5>

		</header>
		<div id="div-1" class=" body">
			<fieldset>
				<legend>Dynamic Autocomplete Searching</legend>
				<div class="input-append">
					<input type="hidden" value="" id="selectedId" /> <input
						placeholder="Place to search..." style="width: 200px"
						id="searchText" type="text">
					<button id="btnEdit" class="btn" type="button">Go</button>
				</div>
			</fieldset>
			<hr>
			<fieldset>
				<legend>Static Searching</legend>
				<div class="fluid-row">
					<div class="input-append" style="margin-right: 1%;">
						<input placeholder="Search by User Name" style="width: 200px"
							id="searchTextName" type="text">
						<button id="btnUserName" class="btn" type="button">Go</button>
					</div>
					<div class="input-append" style="margin-right: 1%;">
						<input placeholder="Search By Device ID" style="width: 200px"
							id="searchTextDeviceId" type="text">
						<button id="btnDeviceId" class="btn" type="button">Go</button>
					</div>
					<div class="input-append" style="margin-right: 1%;">
						<input placeholder="Search By Registration Number"
							style="width: 200px" id="searchTextRGN" type="text">
						<button id="btnRGN" class="btn" type="button">Go</button>
					</div>
				</div>
				<div class="fluid-row">
					<div class="input-append" style="margin-right: 1%;">
						<input placeholder="Search By Unit Sim" style="width: 200px"
							id="searchTextSim" type="text">
						<button id="btnSim" class="btn" type="button">Go</button>
					</div>
					<div class="input-append" style="margin-right: 1%;">
						<input placeholder="Search By Tracker Id" style="width: 200px"
							id="searchTextTrackerId" type="text">
						<button id="btnTrackerId" class="btn" type="button">Go</button>
					</div>
					<div class="input-append" style="margin-right: 1%;">
						<input placeholder="Search By Contact Mobile" style="width: 200px"
							id="searchTextCM" type="text">
						<button id="btnCM" class="btn" type="button">Go</button>
					</div>
				</div>
			</fieldset>
		</div>
	</div>

	<hr>
	<div id="ajaxSearch"></div>
</div>


<script type="text/javascript">
var VTS_DEV_SEARCH={

	sType: '',
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

		$('#btnUserName').bind('click',function(){
			var t = $('#searchTextName').val();
			APP_HELPER.ajaxLoad('clientInfos/showClientInfoStaticSearch?username='+t,'#ajaxSearch');
		});
		$('#btnDeviceId').bind('click',function(){
			var t = $('#searchTextDeviceId').val();
			APP_HELPER.ajaxLoad('clientInfos/showClientInfoStaticSearch?deviceid='+t,'#ajaxSearch');
		});
		$('#btnRGN').bind('click',function(){
			var t = $('#searchTextRGN').val();
			APP_HELPER.ajaxLoad('clientInfos/showClientInfoStaticSearch?rgn='+t,'#ajaxSearch');
		});
		$('#btnSim').bind('click',function(){
			var t = $('#searchTextSim').val();
			APP_HELPER.ajaxLoad('clientInfos/showClientInfoStaticSearch?sim='+t,'#ajaxSearch');
		});
		$('#btnTrackerId').bind('click',function(){
			var t = $('#searchTextTrackerId').val();
			APP_HELPER.ajaxLoad('clientInfos/showClientInfoStaticSearch?trackerid='+t,'#ajaxSearch');
		});
		$('#btnCM').bind('click',function(){
			var t = $('#searchTextCM').val();
			APP_HELPER.ajaxLoad('clientInfos/showClientInfoStaticSearch?cm='+t,'#ajaxSearch');
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
