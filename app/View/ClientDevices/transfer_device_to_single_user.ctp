<div class="span12">
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>
				<?php echo __('Transfer Device to Single Client'); ?>
			</h5>

		</header>
		<div class="in body" id="div-1">

			<?php
			echo $this->Session->flash();
			$data = $this->Js->get('#ClientInfoAddForm')->serializeForm(array('isForm' => true, 'inline' => true));
			$this->Js->get('#ClientInfoAddForm')->event(
					'submit',
					$this->Js->request(
							array('action' => 'transfer'),
							array(
									'data' => $data,
									'async' => true,
									'dataExpression'=>true,
									'method' => 'POST',
									'before' => 'APP_HELPER.ajax_start();',
									'success' => 'APP_HELPER.ajax_stop();APP_HELPER.loadContents(data);',
									'error' => 'APP_HELPER.ajax_error(errorThrown);'
							)
					)
			);
			echo $this->Form->create('ClientInfo', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
			?>
			<fieldset>
				<legend> Selected Device </legend>
				<input id="selectedDeviceId" value="" type="hidden"> <input
					id="selectedClientId" value="" type="hidden">
				<div class="control-group">
					<label class="control-label" for="name">Tracker Id </label>
					<div class="controls">
						<div class="input-append">
							<input placeholder="Search Device" id="searchDevice" type="text" value="<?php echo $deviceId?>">
							<button id="btnDeviceSearch" class="btn" type="button">Go</button>
						</div>
					</div>
				</div>
				<hr>
				<div class="control-group">
					<table>
						<thead>
							<tr>
								<th>
									User Name
								</th>
								<th>
									Mobile#
								</th>
								<th>
									Device Id
								</th>
								<th>
									Vehicle Reg#								
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<input type="text" id="userName" readonly="readonly">
									<input type="hidden" id="fromUserId">
									<input type="hidden" id="fromClientInfoId">
								</td>
								<td>
									<input type="text" id="userMobile" readonly="readonly">
								</td>
								<td>
									<input type="text" id="deviceId" readonly="readonly">
								</td>
								<td>
									<input type="text" id="regId" readonly="readonly">
								</td>
							</tr>
							
						</tbody>
					</table>
				</div>

			<!-- 	<div class="control-group">
					<label class="control-label" for="name">Client Name </label>
					<div class="controls">
						<input type="text" id="nameId" disabled="disabled">
					</div>
				</div> -->
			</fieldset>
			<fieldset>
				<legend> Select Single User </legend>
				<div class="control-group">
					<label class="control-label" for="name"> Choose Single User </label>
					<div class="controls">
						<div class="input-append">
							<input placeholder="Search Client" id="searchClient" type="text" list="userId">
							<datalist id="userId">
								<?php 
								foreach($userNames as $val){
									?>
									<option value="<?php echo $val?>"><?php echo $val?></option>
									<?php 
								}
								?>
							</datalist>
							<button id="btnClientSearch" class="btn" type="button">Go</button>
						</div>
					</div>
				</div>
				<hr>

				<div class="control-group">
					<label class="control-label" for="name">Client Name </label>
					<div class="controls">
						<input type="text" id="clientId" readonly="readonly">
						<input type="hidden" id="toUserId">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Device ID </label>
					<div class="controls">
						<input type="text" id="cdeviceId" readonly="readonly">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Registration Number </label>
					<div class="controls">
						<input type="text" id="cregId" readonly="readonly">
					</div>
				</div>
				<!-- <div class="fluid-row">
					<div class="span6">
						<div class="input-append" style="margin-left: 20%;">
							<input placeholder="Search Device" id="searchDevice" type="text">
							<button id="btnDeviceSearch" class="btn" type="button">
								<i class="icon-search"></i>
							</button>
						</div>
						
						<hr>
						&nbsp;
						<table>
							<tbody>
								<tr>
									<td>Device ID</td>
									<td><input disabled="disabled" id="deviceId"></td>
								</tr>
								<tr>
									<td>Registration Number</td>
									<td><input disabled="disabled" id="regId"></td>
								</tr>
							</tbody>
						</table>

					</div>
					<div class="span6">
						<div class="input-append" style="margin-left: 20%;">
							<input placeholder="Search Client" id="searchClient" type="text">
						</div>
						<hr>
						&nbsp;
						<table>
							<tbody>
								<tr>
									<td>Device ID</td>
									<td><input disabled="disabled" id="cdeviceId"></td>
								</tr>
								<tr>
									<td>Registration Number</td>
									<td><input type="text" id="cregId"></td>
								</tr>
								<tr>
									<td>Client Information</td>
									<td><input disabled="disabled" id="clientId"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
 -->
			</fieldset>
			<div class="form-actions">
				<button type="button" class="btn btn-danger"
					onclick="TRANSFER.saveTransfer()">Transfer Device</button>
			</div>
			<?php
			echo $this->Form->end();
			echo $this->Js->writeBuffer();
			?>
		</div>
	</div>
</div>

<script>
	var TRANSFER = 
	{
			saveTransfer : function(){
				var from_user_id = $('#fromUserId').val();
				var from_client_id = $('#fromClientInfoId').val();
				var to_user_id = $('#toUserId').val();
				var to_client_id = $('#selectedClientId').val();
				var from_reg_no = $('#regId').val();
				var to_reg_no = $('#cregId').val();
				var device_id = $('#cdeviceId').val();
				if(device_id == "" || to_reg_no == ""){
					alert("Please provide Vehicle Registration Number!!!");
					return;
					}
				APP_HELPER.ajaxSubmitData('clientDevices/transferDeviceToSingleUser/'+device_id, 
					{from_user_id: from_user_id, 
					 from_client_id: from_client_id, 
					 to_user_id: to_user_id,
					 to_client_id: to_client_id,
					 from_reg_no: from_reg_no,
					 to_reg_no: to_reg_no,
					 device_id: device_id});
				},
			displaySingleResult:function (item, val, text) 
			{
				var f = val.split("#");
			    $('#selectedDeviceId').val(f[1]); 
			    $('#deviceId').val(f[1]);
			    var d = text.split("(");
			    $('#regId').val(d[0]);  
			    $('#cdeviceId').val($('#deviceId').val()); 
			    $('#cregId').val($('#regId').val());  
			},
			displayClientResult:function (item, val, text) 
			{
			    $('#selectedClientId').val(val); 
			    $('#clientId').val(text);
			},

			init:function(){
				$('#btnClientSearch').bind('click',function(){
					$('#selectedClientId').val('');
					var t = $('#selectedClientId').val().trim();
					if(t==""){
						var dataInput = ($("#searchClient").val()).trim();
						if(dataInput.length <= 1){
							alert("Please Provide at least two characters !!!");
							return;
						}
						APP_HELPER.ajaxSubmitDataCallback('trackerTracks/searchSingleClientWithoutDevice/'+dataInput,'',function(client){
							if(client.length == 1){
								client = client[0];
								$('#selectedClientId').val(client.client_info_id);
								$('#clientId').val(client.client_name);
								$('#cdeviceId').val($('#deviceId').val());
								$('#toUserId').val(client.user_id);
							    $('#cregId').val($('#regId').val());  
															}
							else if(client.length > 1){
								$('#selectedClientId').val('');
								$("#clientId").val('');
								$('#cdeviceId').val('');
								$('#toUserId').val('');
								$('#cregId').val(''); 
								alert("Single Client can't have multiple devices !!!");
								}
							else{
								$('#selectedClientId').val('');
								$("#clientId").val('');
								alert(" No Single Client found with this name !!!");
							}
						});
						
					}
				});
				$('#btnDeviceSearch').bind('click',function(){
					$('#selectedDeviceId').val('');
					var t = $('#selectedDeviceId').val().trim();
					if(t==""){
						var dataInput = ($("#searchDevice").val()).trim();
						if(dataInput.length <= 1){
							alert("Please Provide at least two characters !!!");
							return;
						}
						APP_HELPER.ajaxSubmitDataCallback('trackerTracks/getDeviceInfoByTrackerId/'+dataInput,'',function(device){
							if(device.length == 1){
								device = device[0];
								$('#selectedDeviceId').val(device.client_device_id);
								$('#userName').val(device.username);  
								$('#userMobile').val(device.mob_no);  
								$('#deviceId').val(device.deviceid);
								$('#regId').val(device.vehicle_reg_no);
								$('#fromUserId').val(device.user_id);
								$('#fromClientInfoId').val(device.client_info_id);
								$('#cdeviceId').val($('#deviceId').val()); 
							    $('#cregId').val($('#regId').val());  
															}
							else{
								$('#selectedDeviceId').val('');
								$('#userName').val('');  
								$('#userMobile').val('');  
								$('#deviceId').val('');
								$('#regId').val('');
								$('#fromUserId').val('');
								$('#fromClientInfoId').val('');
								$('#cdeviceId').val('');
								$('#cregId').val('');  
								alert(" No device found with this tracker id !!!");
							}
						});
						
					}
				});
				
				$('#searchDevice').typeahead({
			        ajax: { url: APP_URL_ROOT+'trackerTracks/searchByRegNumber', triggerLength: 1 },
					display: 'name',
			        val: 'deviceid',        
			        itemSelected: TRANSFER.displaySingleResult
			    });
// 				$('#searchClient').typeahead({
// 			        ajax: { url: APP_URL_ROOT+'trackerTracks/searchSingleClientWithoutDevice', triggerLength: 1 },
// 					display: 'username',
// 			        val: 'id',        
// 			        itemSelected: TRANSFER.displayClientResult
// 			    });
			}
	}
	$(function() {
		TRANSFER.init();
		$('#btnDeviceSearch').trigger('click');

		$('#ClientInfoTransferDeviceToSingleUserForm').keydown(function(e){
		    if (e.keyCode === 13) { // If Enter key pressed
		    	$('#btnClientSearch').trigger('click');
		    }
		});		
	});


</script>
