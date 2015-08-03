<div class="span12">
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>
				<?php echo __('Client Transfer [Single User Transfer to Existing Group]'); ?>
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
				<legend> Select Single User </legend>
				<input id="selectedSingleId" value="" type="hidden">
				<div class="control-group">
					<label class="control-label" for="name"> Choose User </label>
					<div class="controls">
						<div class="input-append">
							<input placeholder="Search Single Client" id="searchTextSingle"
								type="text">
							<button id="btnSingleSearch" class="btn" type="button">Go</button>
						</div>
					</div>
				</div>
				<hr>

				<div class="control-group">
					<label class="control-label" for="name">Name </label>
					<div class="controls">
						<input type="text" id="nameId" disabled="disabled">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Mobile </label>
					<div class="controls">
						<input type="text" id="mobileId" disabled="disabled">
					</div>
				</div>


			</fieldset>
			<hr>

			<fieldset>
				<legend> Select Group To Transfer </legend>
				<input id="selectedGroupId" value="" type="hidden">
				<div class="control-group">
					<label class="control-label" for="name"> Choose Group </label>
					<div class="controls">
						<div class="input-append">
							<input placeholder="Search Group" id="searchTextGroup"
								type="text">
							<button id="btnGroupSearch" class="btn" type="button">Go</button>
						</div>
					</div>
				</div>
				<hr>

				<div class="control-group">
					<label class="control-label" for="name">Name </label>
					<div class="controls">
						<input type="text" id="gnameId" disabled="disabled">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Mobile </label>
					<div class="controls">
						<input type="text" id="gmobileId" disabled="disabled">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Total Devices</label>
					<div class="controls">
						<input type="text" id="gdeviceId" disabled="disabled"
							style="text-align: right;">
					</div>
				</div>


			</fieldset>
			<!-- <fieldset>
			<legend> Select Group to Transfer</legend>
			<div class="control-group">
					<label class="control-label" for="name"> Choose Group </label>
					<div class="control">
				<input id="selectedGroupId" value="" type="hidden">
				<div class="input-append" style="margin-left: 30%;">
					<input placeholder="Search Group" id="searchTextGroup" type="text">
					<button id="btnGroupSearch" class="btn" type="button">Go</button>
				</div>
					</div>
				</div>
				<hr>

				<div class="control-group">
					<label class="control-label" for="name">Group Supervisor Name </label>
					<div class="control">
						<input type="text" id="gnameId" disabled="disabled">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name"> Mobile Number </label>
					<div class="control">
						<input type="text" id="gmobileId" disabled="disabled">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Total Devices </label>
					<div class="control">
						<input type="text" id="gdeviceId" disabled="disabled"
							style="text-align: right;">
					</div>
				</div>
			</fieldset> -->
			<hr>
			<div class="form-actions">
				<button type="button" class="btn btn-danger"
					onclick="TRANSFER.saveTransfer()">Transfer To Group</button>
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
				var sid = $('#selectedSingleId').val();
				var gid = $('#selectedGroupId').val();
				if(sid == "" || gid == ""){
					alert("Missing Information !!!");
					return;
					}
				console.debug(sid);
				console.debug(gid);
				APP_HELPER.ajaxSubmitDataCallback('clientInfos/transferToGroupClient/'+sid+'/'+gid, '', function(htmlData){
					$("#ajax-content").html(htmlData);
					});
				},
			displaySingleResult:function (item, val, text) 
			{
			    $('#selectedSingleId').val(val);   
			},
			displayGroupResult:function (item, val, text) 
			{
			    $('#selectedGroupId').val(val);   
			},

			init:function(){
				$('#btnSingleSearch').bind('click',function(){
					
					$('#selectedSingleId').val('');
					var t = $('#selectedSingleId').val().trim();
					if(t==""){
						var dataInput = ($('#searchTextSingle').val()).trim();
						if(dataInput.length < 4){
							alert("Please Provide at least 4 characters !!!");
							return;
							}
						APP_HELPER.ajaxSubmitDataCallback('trackerTracks/searchSingleClient/'+dataInput,'',function(client){
							if(client.length == 1){
								t = client[0].id;
								$('#selectedSingleId').val(t);
								var	url = 'clientDevices/getTransferDetail/'+t;	
								
								APP_HELPER.ajaxSubmitDataCallback(url,'',function(data){
									$("#nameId").val(data[0].name);
									$("#mobileId").val(data[0].mobile);
								});
							}
							else if(client.length > 1){
								$("#nameId").val('');
								$("#mobileId").val('');
								$('#selectedSingleId').val('');
								alert("Multiple single client found. Be more specific !!!");
								}
							else{
								$("#nameId").val('');
								$("#mobileId").val('');
								$('#selectedSingleId').val('');
								alert(" No single client found with this username !!!");
							}
						});
						
					}
					/*
					else{
						var	url = 'clientDevices/getTransferDetail/'+t;	
										
						APP_HELPER.ajaxSubmitDataCallback(url,'',function(data){
							$("#nameId").val(data[0].name);
							$("#mobileId").val(data[0].mobile);
						});
						}
					*/
					
				});

				$('#btnGroupSearch').bind('click',function(){
					$('#selectedGroupId').val('');
					var t = $('#selectedGroupId').val().trim();
					if(t==""){
						var dataInput = ($('#searchTextGroup').val()).trim();
						if(dataInput.length < 4){
							alert("Please Provide at least 4 characters !!!");
							return;
						}
						APP_HELPER.ajaxSubmitDataCallback('trackerTracks/searchGroupClient/'+dataInput,'',function(client){
							if(client.length == 1){
								t = client[0].id;
								$('#selectedGroupId').val(t);
								var	url = 'clientDevices/getTransferDetail/'+t;	
								
								APP_HELPER.ajaxSubmitDataCallback(url,'',function(data){
									$("#gnameId").val(data[0].name);
									$("#gmobileId").val(data[0].mobile);
									$("#gdeviceId").val(data[0].total_device);
								});
							}
							else if(client.length > 1){
								$("#gnameId").val('');
								$("#gmobileId").val('');
								$("#gdeviceId").val('');
								$('#selectedGroupId').val('');
								alert("Multiple group found. Be more specific !!!");
								}
							else{
								$("#gnameId").val('');
								$("#gmobileId").val('');
								$("#gdeviceId").val('');
								$('#selectedGroupId').val('');
								alert(" No group client found with this username !!!");
							}
						});
						
					}
					/*
					else{
						var	url = 'clientDevices/getTransferDetail/'+t;	
										
						APP_HELPER.ajaxSubmitDataCallback(url,'',function(data){
							$("#nameId").val(data[0].name);
							$("#mobileId").val(data[0].mobile);
						});
						}
					*/
					
				});
				
				$('#searchTextSingle').typeahead({
			        ajax: { url: APP_URL_ROOT+'trackerTracks/searchSingleClient', triggerLength: 1 },
					display: 'username',
			        val: 'id',        
			        itemSelected: TRANSFER.displaySingleResult
			    });
				$('#searchTextGroup').typeahead({
			        ajax: { url: APP_URL_ROOT+'trackerTracks/searchGroupClient', triggerLength: 1 },
					display: 'username',
			        val: 'id',        
			        itemSelected: TRANSFER.displayGroupResult
			    });
			}
	}
	$(function() {
		APP_COMMON.initPage('Transfer Client');
		TRANSFER.init();
	});


</script>
