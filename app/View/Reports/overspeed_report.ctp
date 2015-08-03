<div
	style="margin: -10px; margin-top: 10px; font-size: 0.9em;">
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>
				<?php echo __('Report Filters'); ?>
			</h5>
			<div class="toolbar">
				<a class="accordion-toggle minimize-box" data-toggle="collapse"
					href="#reportFilter"> <i class="icon-chevron-up"></i>
				</a>
			</div>

		</header>

		<div class="collapse in body" id="reportFilter">

			<?php echo $this->Form->create('Create', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
			?>
			<div style="margin: 0%;">
				<header>
					<div class="icons">
						<i class="icon-edit"></i>
					</div>
					<h5>
						<?php echo __('Select Tracker'); ?>
					</h5>
				</header>
				<table style="width: 100%;" class="report_class">
					<tbody>
						<tr>
							<td><input type="radio" id="selectall" name="check" value=1
								checked="checked"></td>
							<td>Select All</td>
							<td><input type="radio" id="deselectall" name="check" value=2></td>
							<td>De-select All</td>
						</tr>
					</tbody>
				</table>
				&nbsp;
				<table id="report_trackers" style="width: 100%;"
					class="report_class"></table>
				<?php echo $this->Form->hidden('OverspeedReport.trackers', array('id'=>'trackers'));?>
				&nbsp;
			</div>

			<div style="margin: 0%;">
				<header>
					<div class="icons">
						<i class="icon-edit"></i>
					</div>
					<h5>
						<?php echo __('Date Range'); ?>
					</h5>
				</header>
				<table style="width: 100%" class="report_class">
					<tbody>

						<tr>
							<td><span class="add-on"><i class="icon-calendar"> </i> </span> <input
								id="fromDate" type="text" class="input-medium  form_date"
								placeholder="From Date-Time" data-placement="bottom"
								rel="tooltip" data-original-title="From Date-Time"
								name="data[OverspeedReport][fromdate]">
							</td>
						</tr>

						<tr>
							<td><span class="add-on"><i class="icon-calendar"> </i> </span> <input
								id="toDate" type="text" class="input-medium  form_date"
								placeholder="To Date-Time" data-placement="bottom" rel="tooltip"
								data-original-title="From Date-Time"
								name="data[OverspeedReport][todate]"></td>
						</tr>
					</tbody>
				</table>
			</div>

			<hr>
			<div style="margin: 0%; text-align: center">
				<button class="btn btn-info" type="button" id="btnShowReport">Report</button>
				&nbsp;&nbsp;
				<button class="btn btn-info" type="button" id="btnShowGraph">Graph</button>
			</div>
			</form>

		</div>
	</div>
</div>
<style>
<!--
#reportFilter form div fieldset legend {
	font-size: 1.1em;
	margin-left: -10%;
}

#reportFilter form div fieldset {
	width: 300px;
}
-->
</style>

<!--/datatables tools-->
<script type="text/javascript">
	var ALERT_REPORT = {
			init : function(){

				$('#selectall').bind('click',function(){
					if($(this).is(':checked')){	
						$('input[name=checkboxlist]').prop('checked', $(this).is(":checked"));
					}
			    });
				$('#deselectall').bind('click',function(){
					if($(this).is(':checked')){	
						$('input[name=checkboxlist]').removeAttr('checked');
					}
			    });
				
				$('#btnShowReport').bind('click',function(){

					$('#graphdiv').hide();	
					$('#nitsreport').show();
					$('#btnExport').show();
					
					var checkValues = $('input[name=checkboxlist]:checked').map(function()
				            {
				                return $(this).val();
				            }).get();
		            $("#trackers").val(checkValues);

					if($('#trackers').val()==''){
						alert('Please select a device!!!'); return;
					}
					if($('#fromDate').val()==''){
						alert('Please select a valid date from!!!'); return;
					}
					if($('#toDate').val()==''){
						alert('Please select a valid date to!!!'); return;
					}
					
					var url = 'reports/ajaxOverspeedReport';
					var data = $('#CreateOverspeedReportForm').serialize();
					APP_HELPER.ajaxSubmitDataCallback(url,data,function(d){
						if($.isEmptyObject(d) == false){
							var st = '';
							var isData = false;
							
							$.each(d,function(index,val) {
								var row = 1;
								$.each(val,function(index,r) {
									isData = true;
									if(index % 2 == 0){
										st += '<tr style="background-color:#F1F1F1">';
										}
									else{
										st += '<tr style="background-color:#DDDDDD">';
										}
									if(row == 1){
										st += ('<td><b>'+r.reg_number+'</b></td>');
									}
									else{
										st += ('<td></td>');
										}
									st += ('<td>'+r.date+'</td>');
									st += ('<td>'+r.speed+'</td>');
									st += ('<td>'+r.addr+'</td>');
									st += ('<td>'+r.info+'</td>');
								  	st += '<tr>';
								  	row = 0;
								});
							});
							if(isData == true){
								$('#reportBody').html(st);
							}
							else{
								var st = '<tr>';
								st += ('<td colspan="8">No Records found</td>');
							  	st += '<tr>';
							  	$('#reportBody').html(st);
								}
							
						}
						else{
							var st = '<tr>';
							st += ('<td colspan="8">No Records found</td>');
						  	st += '<tr>';
							$('#reportBody').html(st);
							}				
					});
				});

				$('#btnShowGraph').bind('click',function(){
					$('#graphdiv').show();	
					$('#nitsreport').hide();
					$('#btnExport').hide();
					var checkValues = $('input[name=checkboxlist]:checked').map(function()
				            {
				                return $(this).val();
				            }).get();
		            $("#trackers").val(checkValues);

					if($('#trackers').val()==''){
						alert('Please select a device!!!'); return;
					}
					if($('#fromDate').val()==''){
						alert('Please select a valid date from!!!'); return;
					}
					if($('#toDate').val()==''){
						alert('Please select a valid date to!!!'); return;
					}
					
					var url = 'reports/overspeedReportGraph';
					var data = $('#CreateOverspeedReportForm').serialize();
					APP_HELPER.ajaxSubmitDataCallback(url,data,function(d){
						$('#graphdiv').html(d);
					});
				}); 
				}
			};
	$(document).ready(function() {	
			 ALERT_REPORT.init();
			 
			 $("#fromDate").datetimepicker({format: 'yyyy-mm-dd',autoclose:true,minView:2}).val(getTodaysDate(0));
			 $("#toDate").datetimepicker({format: 'yyyy-mm-dd',autoclose:true,minView:2}).val(getTodaysDate(0));
			        
    });
</script>
