<?php $isReportView = 1;?>
<div style="margin: 0;">
	<div class="box dark">
		<header>
			<h5>Select Report</h5>
		</header>
		<div id="div-1" class=" body">
			<form id="selectReportForm">
				<table style="width: 100%;" class="report_class">
					<tbody>
						<tr>
							<td style="font-size: 0.8em;width:20%;"><b>User</b></td>
							<td style="font-size: 0.9em;width:80%;"><b><?php echo $name;?> </b></td>
						</tr>
						<tr>
							<td style="font-size: 0.8em;width:20%;"><?php echo $this->Form->hidden('id', array('value'=>$id))?><b>Report</b>
							</td>
							<td style="font-size: 0.9em;width:80%;"><?php echo $this->Form->select('report_type', $cr, array('style'=>'width:140px;margin:4px;'))?></td>
						</tr>
					</tbody>
				</table>
			</form>
			<div id="report-contents"></div>
		</div>
	</div>
</div>

<style>
.report_class tbody tr {
	border: 1px solid #DDDDDD;
	height: 20px;
}

.report_class tbody tr td {
	border-right: 1px solid #DDDDDD;
	padding: 2px 5px 2px 5px;
}

.reportResult table tr td {
	border-right: 1px solid white;
	padding: 2px 5px 2px 5px;
}
</style>
<script type="text/javascript">
var REPORT_LEFT = {
		tracker_data :''
}
$(function(){
	$('#report_type').bind('change', function() {
		var changeData = $(this).find("option:selected").val();
  		APP_HELPER.ajaxSubmitDataCallback('reports/'+changeData+'/<?php echo $id;?>', '',function(data){
  			$('#report-contents').html(data);
  			APP_HELPER.ajaxSubmitDataCallback('reports/'+changeData+'_list', '',function(data){
  	  			$('#report-view').html(data);
	  	  		APP_HELPER.ajaxSubmitDataCallback('clientDevices/getDeviceInfoByUserId/<?php echo $id;?>', '', function(data){
	  	  		var s = '<tbody">';
	  	  			$.each(data, function(i, val){
		  	  			s+='<tr><td valign="top"><input type="checkbox" class="tracker_device" name="checkboxlist" value="'+val.ClientDevice.deviceid+'" checked="checked"></td><td valign="top"> '+val.ClientDevice.name+'</td></tr>';
		  	  			});
	  	  			s+='</tbody>';
	  	  		$('#report_trackers').append(s);
	  				 });  
  	  	  		});
  	  		});
  		return false;
	});	
});

</script>
