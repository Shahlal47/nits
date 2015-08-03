<div class="container-fluid outer">
	<div class="row-fluid">
		<!-- .inner -->
		<div class="span12">
			<div class="row-fluid">
				<div class="span12">
					<div class="box dark">
						<header>
							<h5>Trackers Current Status</h5>
							<div class="toolbar">
								<a class="accordion-toggle minimize-box" data-toggle="collapse"
									href="#defaultTable"> <i class="icon-chevron-up"></i>
								</a>
							</div>
						</header>
						<div class="body collapse in" id="defaultTable">
							<table class="table table-bordered table-striped" style="width:100%;">
								<thead>
									<tr>
										<th style="width:30%">Registration</th>
<!-- 										<th>Description</th> -->
										<th style="width:10%">Device ID</th>
										<th style="width:50%">Current Location</th>
										<th style="width:10%">Last Updated</th>
									</tr>
								</thead>
								<tbody id="dashboard-device-status">
									<tr>
										<td colspan="4">Data not available</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!--	<div class="row-fluid">
				<div class="span4">
					<div class="box dark alerts">
						<header>
						<h5>Alerts</h5>
						<div class="toolbar">
							<a class="accordion-toggle minimize-box" data-toggle="collapse"
								href="#alertTable"> <i class="icon-chevron-up"></i> </a>
						</div>
						</header>
						 
						<div class="body collapse in" id="alertTable">
						
							<div class="alert alert-error">
								<a class="close" data-dismiss="alert"><i class="btn-icon-only icon-remove"></i></a>
								<h5 class="alert-heading">Speed Alert</h5>
								<a href="#">Vehicle: Dhaka-Cha-1213, Location: Baridhara, Dhaka</a>
							</div>
							<div class="alert alert-error">
								<a class="close" data-dismiss="alert"><i class="btn-icon-only icon-remove"></i></a>
								<h5 class="alert-heading">Speed Alert</h5>
								<a href="#">Vehicle: Dhaka-Ga-1213, Location: Baridhara, Dhaka</a>
							</div>
							
						</div>
					</div>
				</div>
				<div class="span4">
					<div class="box dark alerts">
						<header>
						<h5>Notifications</h5>
						<div class="toolbar">
							<a class="accordion-toggle minimize-box" data-toggle="collapse"
								href="#notificationTable"> <i class="icon-chevron-up"></i> </a>
						</div>
						</header>
						<div class="body collapse in" id="notificationTable">
						
							<div class="alert ">
								<a class="close" data-dismiss="alert"><i class="btn-icon-only icon-remove"></i></a> Vehicle
									(Dhaka-Ga-1213) Tracking Registration will be expired on: <i>2013-03-04</i>
								
							</div>
							<div class="alert alert-info">
								<a class="close" data-dismiss="alert"><i class="btn-icon-only icon-remove"></i></a> There will not be
								any tracking service from 2013-03-04 01:00:00 to 2013-03-04
								13:00:00
							</div>
						
						</div>
					</div>
				</div>
				
				<div class="span4">
					<div class="box dark">
						<header>
						<h5>Expense Summary</h5>
						<div class="toolbar">
							<a class="accordion-toggle minimize-box" data-toggle="collapse"
								href="#expanseTable"> <i class="icon-chevron-up"></i> </a>
						</div>
						</header>
						<div class="body collapse in" id="expanseTable">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Expense Item</th>
										<th>Total Cost</th>
									</tr>
								</thead>
								<tbody id="tblExpenseSummary">
									<tr>
										<td colspan="2">Data not available</td>
									</tr>									
								</tbody>
							</table>
						</div>
					</div>
				</div>
				 -->
		</div>
	</div>
</div>

<style>
.alerts {
	font-size: .8em;
	font-weight: bold;
}

.alerts h5 {
	margin: 0;
}

#dashboard-device-status tr:hover {
	cursor: pointer;
	cursor: hand;
	backgroun-color: #fff;
}
</style>
<script type="text/javascript">
	var VTS_DASHBOARD={

		init:function(){
			
			// load portlets
			
			// load tracker latest status
			var deviceProfiles = APP_COMMON.getDeviceProfiles();
			if(deviceProfiles.length>0){
				$('#dashboard-device-status').html('');
				$.each(deviceProfiles,function(i){
					var dp = deviceProfiles[i];
					
					var ds = APP_COMMON.getDeviceStatusByDeviceid(dp.ClientDevice.deviceid);
					//var onoff = 'OFF';
					var lbl = 'important';
					
					if(ds.ignitionStatus=='1'){
						//onoff = 'ON';
						lbl = 'success';
					}
					var tr = '<tr id="'+ dp.ClientDevice.deviceid +'">';
					tr += '<td>';
					if(dp.DeviceType.name=='VT'){
						tr += '<span class="label btn-metis-6"><i class="icon-truck"></i></span> ';
					}else{
						tr += '<span class="label btn-metis-5"><i class="icon-male"></i></span> ';
					}
					tr += '<span class="label label-'+lbl+'">'+dp.ClientDevice.name+'</span></td>';
					//tr += '<td><span class="label label-warning">'+onoff+'</span></td>';
					/*if(dp.ClientDevice.tags!=null){
						tr += '<td><code style="color: #000">'+dp.ClientDevice.tags+'</code></td>';
					}else{
						tr += '<td><code></code></td>';
					}*/
					if(dp.ClientDevice.deviceid != null){
						tr += '<td><code style="color: #000">'+dp.ClientDevice.deviceid+'</code></td>';
					}else{
						tr += '<td><code style="color: #000">No record found!</code></td>';
					}
					if(ds.nearaddress){
						tr += '<td><p style="color: grey;word-wrap: break-word;">'+ds.nearaddress+'</p></td>';
					}else{
						tr += '<td><code style="color: #000">No record found!</code></td>';
					}
					if(ds.serverDateTime){
						tr += '<td><code style="color: #000">'+ds.serverDateTime+'</code></td>';
					}else{
						tr += '<td><code style="color: #000">No record found!</code></td>';
					}				
					tr += '</tr>';
					$('#dashboard-device-status').append(tr);
					
				});
				$('#dashboard-device-status tr').bind('click',function(){
					var deviceid = $(this).attr('id');
					APP_HELPER.ajaxLoad('trackerTracks/tracker_live_view/'+deviceid,'#ajax-content');
				});
						
			}
					
			// load user latest user alerts

			// load user notifications

			// load user expense summery
			/*
			APP_HELPER.ajaxSubmitDataCallback('clientExpenses/get_summary','',function(data){
				
				if(data.length>0){
					$('#tblExpenseSummary').html('');
					$.each(data,function(i){
						
											
						var tr = '<tr>';
						tr += '<td><span class="label label-info">'+data[i].ExpenseType.name+'</span></td>';
						tr += '<td><code>'+data[i][0].total+'</code></td>';
						
						tr += '</tr>';
						$('#tblExpenseSummary').append(tr);
					});
				}
			});
			*/
			APP_COMMON.initPage('Dashboard');
		}
	};
	$(function() {
		APP_COMMON.loadUserDeviceStatus(function(){
			VTS_DASHBOARD.init();
			
		});
		/*APP_HELPER.ajaxSubmitDataCallback('dashboard/left','',function(data){
			
			$('#left').html(data);
			
			APP_COMMON.initLayout("<?php echo $user['username']?>");

			APP_COMMON.loadUserDeviceStatus(function(){
				VTS_DASHBOARD.init();
				
			});
		});	
		$('#left').css('width','220px');
	    $('#content').css('margin-left','220px');*/
	});
	</script>
