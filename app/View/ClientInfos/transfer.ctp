<div class="span12">
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>
				<?php echo __('Update Client (From Single User to Group User)'); ?>
			</h5>

		</header>
		<div class="in body" id="div-1">

			<?php
			$transfer = 1;
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
				<input id="selectedSingleId" value="" type="hidden">

				<div class="control-group">
					<div class="controls">
						<div class="input-append">
							<input placeholder="Search Single Client" id="searchTextSingle"
								type="text">
							<button id="btnSingleSearch" class="btn" type="button">
								Go
							</button>
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

				<div class=form-actions>
					<button type="button" class="btn btn-danger"
						onclick="TRANSFER.saveTransfer()">Transfer To Group User</button>
				</div>

				<div id="clientDevices"></div>

			</fieldset>
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
				var id = $('#selectedSingleId').val();
				if(id == ""){
					return;
					}
				APP_HELPER.ajaxSubmitData('clientInfos/transfer/'+id);
				},
			displaySingleResult:function (item, val, text) 
			{
			    $('#selectedSingleId').val(val);   
			},

			init:function(){
				$('#btnSingleSearch').bind('click',function(){
					$('#selectedSingleId').val('');
					var t = $('#selectedSingleId').val().trim();
					if(t==""){
						APP_HELPER.ajaxSubmitDataCallback('trackerTracks/searchSingleClient/'+($('#searchTextSingle').val()).trim(),'',function(client){
							if(client.length > 0){
							t = client[0].id;
							$('#selectedSingleId').val(t);
							var	url = 'clientDevices/getTransferDetail/'+t;	
							
							APP_HELPER.ajaxSubmitDataCallback(url,'',function(data){
								$("#nameId").val(data[0].name);
								$("#mobileId").val(data[0].mobile);
								APP_HELPER.ajaxSubmitDataCallback('clientDevices/index/'+t+'/1', '', function(data){
									$("#clientDevices").html(data);
								});
							});
							}
							else{
								$("#clientDevices").html('');
								$("#nameId").val('');
								$("#mobileId").val('');
								$('#selectedSingleId').val('');
								alert(" No client found with this username !!!");
							}
						});
						
					}
					else{
						var	url = 'clientDevices/getTransferDetail/'+t;	
										
						APP_HELPER.ajaxSubmitDataCallback(url,'',function(data){
							$("#nameId").val(data[0].name);
							$("#mobileId").val(data[0].mobile);
							APP_HELPER.ajaxSubmitDataCallback('clientDevices/index/'+t, '', function(data){
								$("#clientDevices").html(data);
							});
						});
						}
					
				});
				
				$('#searchTextSingle').typeahead({
			        ajax: { url: APP_URL_ROOT+'trackerTracks/searchSingleClient', triggerLength: 1 },
					display: 'username',
			        val: 'id',        
			        itemSelected: TRANSFER.displaySingleResult
			    });
			}
	}
	$(function() {
		APP_COMMON.initPage('Update Client');
		TRANSFER.init();
	});


</script>
