<div class="span12">
	<div class="box">
		<header>
		<h5>
			<i class="icon-th-large"></i> Report Settings
		</h5>


		</header>
		<div class="accordion-body collapse in body" id="div-3">
		   <?php echo $this->Session->flash();?>
		   <input id="id" type="hidden" value="<?php echo $id?>"/>
			<div class="row-fluid">
				<div style="width: 45%; float: left;">
					<select size="16" style="width: 100%;" multiple="multiple"
						id="reports">
						<?php foreach ($reports as &$value) {
							if (!in_array($value, $client_reports)) {
							    echo "<option value='$value'>$value</option>";
							}						
						}?>
					</select>
				</div>
				<div
					style="width: 10%; float: left; text-align: center; padding-top: 6%;">
					<div style="white-space: normal;"
						class="btn-group btn-group-vertical">
						<button class="btn btn-primary" type="button" id="to2">
							<i class="icon-chevron-right"></i>
						</button>
						<button class="btn btn-primary" type="button" id="allTo2">
							<i class="icon-forward"></i>
						</button>
						<button class="btn btn-danger" type="button" id="allTo1">
							<i class="icon-backward"></i>
						</button>
						<button class="btn btn-danger" type="button" id="to1">
							<i class=" icon-chevron-left icon-white"></i>
						</button>
					</div>
				</div>
				<div style="width: 45%; float: left;">
					<select size="16" style="width: 100%;" multiple="multiple"
						id="client-reports">
						<?php foreach ($reports as &$value) {
							if (in_array($value, $client_reports)) {
							    echo "<option value='$value'>$value</option>";
							}						
						}?>
					</select>
				</div>
				
			</div>
			<div class="form-actions">
					<button id="btnSaveSettings" type="submit" class="btn btn-danger btn">Save</button>
					
				</div>
		</div>
	</div>
</div>

<script>
	$(function() {
		document.title = 'NITS::ClientReport';
		$('#ajax-page-title').html('<i class="icon-user"></i> Client Report : Add');
		$( "#to1" ).click(function() {
			var selectedReport = $('#client-reports :selected');
			if(selectedReport.index()>=0){
				$('#reports').append(selectedReport);
			}
		});	   
		$( "#to2" ).click(function() {
			var selectedReport = $('#reports :selected');
			if(selectedReport.index()>=0){
				$('#client-reports').append(selectedReport);
			}
		});	   
		$( "#allTo1" ).click(function() {
			var selectedReports = $('#client-reports').children();
			$('#reports').append(selectedReports);
		});	   
		$( "#allTo2" ).click(function() {
			var selectedReports = $('#reports').children();
			$('#client-reports').append(selectedReports);
		});	
		$( "#btnSaveSettings" ).click(function() {
			var id = $('#id').val();
			var cid = '<?php echo $client_info_id?>';
			var selectedReports = $('#client-reports').children();
			var selectValues = "";
			var i = 0;
			$( selectedReports ).each(function( index ) {
				if(i>0) selectValues += ",";
				selectValues += $(this).val();
				i++;
			});
			var data = 'data[ClientReport][id]='+id+'&data[ClientReport][client_info_id]='+cid+'&data[ClientReport][reports]='+selectValues;
			//console.debug(data);
			var url = 'clientReports/savesettings';
			APP_HELPER.ajaxSubmitDataCallback(url,data,function(data){
				$('#ajaxClientInfo').html(data);
			});
		});	   
	});
</script>
