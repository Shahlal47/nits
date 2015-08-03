<div
	style="margin: -10px; margin-top: 10px; font-size: 0.9em;">
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>
				<?php echo __('Alert Report Filters'); ?>
			</h5>
			<div class="toolbar">
				<a class="accordion-toggle minimize-box" data-toggle="collapse"
					href="#reportFilter"> <i class="icon-chevron-up"></i>
				</a>
			</div>

		</header>

		<div class="collapse in body" id="reportFilter">

			<?php echo $this->Form->create('frm', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
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
				<?php echo $this->Form->hidden('trackers', array('id'=>'trackers'));?>
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
								name="data[frm][fromdate]">
							</td>
						</tr>

						<tr>
							<td><span class="add-on"><i class="icon-calendar"> </i> </span> <input
								id="toDate" type="text" class="input-medium  form_date"
								placeholder="To Date-Time" data-placement="bottom" rel="tooltip"
								data-original-title="From Date-Time" name="data[frm][todate]"></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div style="margin: 0%;">
				<header>
					<div class="icons">
						<i class="icon-edit"></i>
					</div>
					<h5>
						<?php echo __('Status'); ?>
					</h5>
				</header>
				<table id="" style="width: 100%;" class="report_class">
					<tbody>
						<tr>
							<td><input type="radio" name="status" checked="checked"
								value="All"></input>
							</td>
							<td>All Status</td>
						</tr>
						<tr>
							<td><input type="radio" name="status" value="Overspeed"></input>
							</td>
							<td>Overspeed</td>
						</tr>
						<tr>
							<td><input type="radio" name="status"
								value="EmergencySwitchPressed"></input>
							</td>
							<td>Emergency Switch Pressed</td>
						</tr>
						<tr>
							<td><input type="radio" name="status"
								value="MainPowerFailureAlert"></input>
							</td>
							<td>Main Power Failure Alert</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div style="margin: 0%;">
				<hr>
				<button class="btn btn-info" type="button" id="btnShowReport"
					style="margin: 10%; width: 80%;">Show</button>
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
					
					var url = 'reports/ajaxAlertReport';
					var data = $('#frmAlertReportForm').serialize();
					console.debug(data);
					APP_HELPER.ajaxSubmitDataCallback(url,data,function(d){
						if(d.length > 0){
							d = JSON.parse(d);
							var st = '';
							$( d ).each(function(index) {
								st += '<tr>';
								st += ('<td>'+d[index].from+'</td>');
								st += ('<td>'+d[index].to+'</td>');
								st += ('<td>'+d[index].preTime+'</td>');
								st += ('<td>'+d[index].recordTime+'</td>');
								st += ('<td>'+d[index].duration+'</td>');
								st += ('<td>'+d[index].mileage+'</td>');
								st += ('<td>'+d[index].fuel+'</td>');
							  	st += '<tr>';
							});
						}
						else{
							alert('No records found !!')
							}
						if(d.length>0){
							$('#reportBody').html(st);
						}				
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
