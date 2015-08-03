<div class="span12">
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>
				<?php echo __('Extend Subscription'); ?>
			</h5>
		</header>
		<div class="in body" id="div-1">
		<?php echo $this->Session->flash();?>
			<div class="input-append" style="">
				<input placeholder="Search device by registration number"
					style="width: 300px" id="searchText" type="text">
				<button id="btnSearch" class="btn" type="button">
					<i class="icon-search"></i>
				</button>
			</div>
			<hr>
			<div id="SubscriptionHistory">
				<fieldset>
					<div class="fluid-row">
						<div class="span4">
							<div class="control-group">
								<label class="control-label" for="name">Registration Number </label>
								<div class="controls">
									<input id="reg_number" disabled="disabled" />
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="name">Device Type </label>
								<div class="controls">
									<input id="device_type" disabled="disabled" />
								</div>
							</div>
						</div>
						<div class="span4">
							<div class="control-group">
								<label class="control-label" for="name">Unit Sim </label>
								<div class="controls">
									<input id="mob_no" disabled="disabled" />
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="name">Subscribe Date </label>
								<div class="controls">
									<input id="s_date" disabled="disabled" />
								</div>
							</div>
						</div>
						<div class="span4">
							<div class="control-group">
								<div class="control-group">
									<label class="control-label" for="name">Device ID </label>
									<div class="controls">
										<input id="device_id" disabled="disabled" />
									</div>
								</div>
								<label class="control-label" for="name=">Current Expire Date</label>
								<div class="controls">
									<input id="e_date" disabled="disabled" />
								</div>
							</div>


						</div>
					</div>
				</fieldset>
			</div>
			<hr>
			<?php 

			echo $this->Form->create('ExtHistory', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
			?>
			<fieldset>
				<input id="selectedId" value="" type="hidden"> <input
					id="subscriptionId" value="" type="hidden">

				<div class="control-group">
					<label class="control-label" for="name">Memo Number </label>
					<div class="controls">
						<?php echo $this->Form->input('memo_number', array('class'=>'input-large', 'id'=>'memoId'));
						echo $this->Form->error('memo_number'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Ref Number </label>
					<div class="controls">
						<?php echo $this->Form->input('ref_number', array('class'=>'input-large' , 'id'=>'refId'));
						echo $this->Form->error('ref_number'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">To Date </label>
					<div class="controls">
						<?php echo $this->Form->input('to_date', array('id'=> 'nDate','class'=>'input-large form-date', 'type'=>'text'));
						echo $this->Form->error('to_date'); ?>
					</div>
				</div>

				<hr>
				<div class="text-center">
					<button type="button" class="btn btn-danger btn"
						onclick="EXT_HISTORY.saveHistory();">Submit</button>
					&nbsp;&nbsp;
					<button type="reset" class="btn">Reset</button>
				</div>
			</fieldset>
			<?php
			echo $this->Form->end();
			echo $this->Js->writeBuffer();
			?>
			
			<div id="extHistories">
			</div>
		</div>
	</div>
</div>

<script>
	var EXT_HISTORY = {
			saveHistory : function(){
				var memo = $("#memoId").val();
				var ref = $("#refId").val();
				var ndate = $("#nDate").val();
				var edate = $("#e_date").val();

				if(ndate == ""){
					alert("Empty Date !!!");
					return;
					}
				if(ndate != ""){
					if(!EXT_HISTORY.checkDate()){
						alert("New Expire Date can not less than or equal Current Expire Date !!!");
						return;
					}
				}
				var data = {sId:$("#subscriptionId").val(), e_date:edate, form_data : $('#ExtHistoryAddForm').serialize()};
				APP_HELPER.ajaxSubmitDataCallback('extHistories/add', data, function(rData){
					if(rData==1){
						$('#ExtHistoryListTable').dataTable()._fnAjaxUpdate();

						$("#reg_number").val('');
						$("#mob_no").val('');
						$("#device_id").val('');
						$("#device_type").val('');
						$("#s_date").val('');
						$("#e_date").val('');
						$("#subscriptionId").val('');
						$("#nDate").val(''); 
						$('#searchText').val('');
						$('#ExtHistoryAddForm')[0].reset();
						}
					});
				},
			checkDate : function(){
				var nDate=document.getElementById('nDate').value;
				var d1 = Date.parse(nDate);
				var dt1 = new Date(d1);
				
				var eDate=document.getElementById('e_date').value;
				var d2 = Date.parse(eDate);
				var dt2 = new Date(d2);
				if(dt1 <= dt2){
					return false;
					}
				else{
					return true;
					}
				},
			displayResult:function (item, val, text) 
			{
				var f = val.split("#");
			    $('#selectedId').val(f[1]); 
			    $("#reg_number").val('');
				$("#mob_no").val('');
				$("#device_id").val('');
				$("#device_type").val('');
				$("#s_date").val('');
				$("#e_date").val('');
				$("#subscriptionId").val('');
				$("#nDate").val('');  
				$("#extHistories").hide();
			},
			init:function(){
				$('#btnSearch').bind('click',function(){
					$('#selectedId').val('');
					APP_HELPER.ajaxSubmitDataCallback('trackerTracks/searchByRegNumberWithoutLike/'+($('#searchText').val()).trim(),'',function(client){
						if(client.length > 0){
							var s = client[0].deviceid;
							var d = s.split("#");
							t = d[1]; 
							if(t==""){
								return;
							}
							
							var	url = 'clientDevices/getDeviceInfoForExtansion/'+t;	
											
							APP_HELPER.ajaxSubmitDataCallback(url,'',function(data){
								$("#reg_number").val(data[0].ClientDevice.name);
								$("#mob_no").val(data[0].ClientDevice.mob_no);
								$("#device_id").val(data[0].ClientDevice.deviceid);
								$("#device_type").val(data[0].DeviceType.name);
								$("#s_date").val(data[0].ClientDeviceSubscription.subscribe_date);
								$("#e_date").val(data[0].ClientDeviceSubscription.expire_date);
								$("#subscriptionId").val(data[0].ClientDeviceSubscription.id);
								$("#nDate").val(data[0].ClientDeviceSubscription.expire_date);
								$("#extHistories").show();
								APP_HELPER.ajaxSubmitDataCallback('extHistories/index/'+data[0].ClientDeviceSubscription.id, '', function(data){
									$("#extHistories").html(data);
									});
							});
						}
						else{
							$("#reg_number").val('');
							$("#mob_no").val('');
							$("#device_id").val('');
							$("#device_type").val('');
							$("#s_date").val('');
							$("#e_date").val('');
							$("#subscriptionId").val('');
							$("#nDate").val('');  
							$("#extHistories").hide();

							alert('No Device found !!!');
							}
					});
					//var t = $('#selectedId').val();
					
					
				});
				
				$('#searchText').typeahead({
			        ajax: { url: APP_URL_ROOT+'trackerTracks/searchByRegNumber', triggerLength: 1 },
					display: 'name',
			        val: 'deviceid',        
			        itemSelected: EXT_HISTORY.displayResult
			    });
			}
	}		
	$(function() {
		$(".form-date").datetimepicker({format: 'yyyy-mm-dd',autoclose:true,minView:2}).val(getTodaysDate(0)); 
		EXT_HISTORY.init();
		APP_HELPER.ajaxSubmitDataCallback('trackerTracks/getAccountProfile', '', function(rData){
			$("#tt").html(rData.tt);
			$("#pt").html(rData.pt);
			$("#vt").html(rData.vt);
			$("#tc").html(rData.tc);
			$("#sc").html(rData.sc);
			$("#gc").html(rData.gc);
			});
	});
</script>
