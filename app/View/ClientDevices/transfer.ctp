<div class="span12">
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>
				<?php echo __('Transfer Device to Group Client'); ?>
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
				<legend> Select Device (Using Tracker ID) </legend>
				<input id="selectedDeviceId" value="" type="hidden"> <input
					id="selectedClientId" value="" type="hidden">
				<div class="control-group">
					<label class="control-label" for="name"> Choose Device </label>
					<div class="controls">
						<div class="input-append">
							<input placeholder="Search Device" id="searchDevice" type="text">
							<button id="btnDeviceSearch" class="btn" type="button">Go</button>
						</div>
					</div>
				</div>
				<hr>

			<!-- 	<div class="control-group">
					<label class="control-label" for="name">Client Name </label>
					<div class="controls">
						<input type="text" id="nameId" disabled="disabled">
					</div>
				</div> -->

				<div class="control-group">
					<label class="control-label" for="name">Device ID </label>
					<div class="controls">
						<input type="text" id="deviceId" disabled="disabled">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Registration Number </label>
					<div class="controls">
						<input type="text" id="regId" disabled="disabled">
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend> Select Group Client (By User ID) </legend>
				<div class="control-group">
					<label class="control-label" for="name"> Choose Group Client </label>
					<div class="controls">
						<div class="input-append">
							<input placeholder="Search Client" id="searchClient" type="text">
							<button id="btnClientSearch" class="btn" type="button">Go</button>
						</div>
					</div>
				</div>
				<hr>

				<div class="control-group">
					<label class="control-label" for="name">Client Name </label>
					<div class="controls">
						<input type="text" id="clientId" disabled="disabled">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Device ID </label>
					<div class="controls">
						<input type="text" id="cdeviceId" disabled="disabled">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Registration Number </label>
					<div class="controls">
						<input type="text" id="cregId" disabled="disabled">
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
				var id = $('#selectedClientId').val();
				var did = $('#cdeviceId').val();
				var regNumber = $('#cregId').val();
				if(id == "" || regNumber == ""){
					return;
					}
				APP_HELPER.ajaxSubmitData('clientDevices/transfer/'+id, {deviceid: did, reg:regNumber,client_id : id});
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
						if(dataInput.length < 4){
							alert("Please Provide at least 4 characters !!!");
							return;
						}
						APP_HELPER.ajaxSubmitDataCallback('trackerTracks/searchContactByName/'+dataInput,'',function(client){
							if(client.length == 1){
								t = client[0].id;
								$('#selectedClientId').val(t);
								$('#clientId').val(client[0].name);
								$('#cdeviceId').val($('#deviceId').val()); 
								$('#cregId').val($('#regId').val()); 
								
							}
							else if(client.length > 1){
								$('#selectedClientId').val('');
								$("#clientId").val('');
								alert("Multiple Client Found. Be more specific !!!");
								}
							else{
								$('#selectedClientId').val('');
								$("#clientId").val('');
								alert(" No Group Client found with this name !!!");
							}
						});
						
					}
				});
				$('#btnDeviceSearch').bind('click',function(){
					$('#selectedDeviceId').val('');
					var t = $('#selectedDeviceId').val().trim();
					if(t==""){
						var dataInput = ($("#searchDevice").val()).trim();
						if(dataInput.length < 4){
							alert("Please Provide at least 4 characters !!!");
							return;
						}
						APP_HELPER.ajaxSubmitDataCallback('trackerTracks/searchByTrackerID/'+dataInput,'',function(device){
							if(device.length == 1){
								t = device[0].name;
								$('#selectedDeviceId').val(t);
								$('#deviceId').val(t);
								var rname = device[0].rname;
								var s = rname.split("<i>(");
								$('#regId').val(s[0]);  
								$('#cdeviceId').val($('#deviceId').val()); 
								$('#cregId').val($('#regId').val());  
							}
							else if(device.length > 1){
								$('#selectedDeviceId').val('');
								$('#deviceId').val('');
								$('#regId').val('');  
								$('#cdeviceId').val($('#deviceId').val()); 
								$('#cregId').val($('#regId').val()); 
								alert("Multiple Device Found. Be more specific !!!");
								}
							else{
								$('#selectedDeviceId').val('');
								$('#deviceId').val('');
								$('#regId').val('');  
								$('#cdeviceId').val($('#deviceId').val()); 
								$('#cregId').val($('#regId').val()); 
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
				$('#searchClient').typeahead({
			        ajax: { url: APP_URL_ROOT+'trackerTracks/searchContactByName', triggerLength: 1 },
					display: 'username',
			        val: 'id',        
			        itemSelected: TRANSFER.displayClientResult
			    });
			}
	}
	$(function() {
		TRANSFER.init();
	});


</script>
