<div class="span12">
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>
		<?php echo __('Add Client Device Subscription'); ?>
		</h5>
		
		</header>
		<div class="in body" id="div-1">

		<?php
		echo $this->Session->flash();
		$data = $this->Js->get('#ClientDeviceSubscriptionAddForm')->serializeForm(array('isForm' => true, 'inline' => true));
		$this->Js->get('#ClientDeviceSubscriptionAddForm')->event(
					'submit',
		$this->Js->request(
		array('action' => 'add'),
		array(
						'data' => $data,
						'async' => true,    
						'dataExpression'=>true,
						'method' => 'POST',
						'before' => 'APP_HELPER.ajax_start();',
						'success' => 'APP_HELPER.ajax_stop();APP_HELPER.loadContentHolder(data,"#ajaxClientInfo");',
						'error' => 'APP_HELPER.ajax_error(errorThrown);'
						)
						)
						);
						echo $this->Form->create('ClientDeviceSubscription', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
						?>
			<fieldset>
				<input name="data[ClientDeviceSubscription][client_deviceid]" value="<?php echo $did; ?>" type="hidden"/>
					<div class="control-group">
						<label class="control-label" for="name">Account Type </label>
						<div class="controls">
						<?php echo $this->Form->input('account_type_id', array('class'=>'input-large'));
						echo $this->Form->error('account_type_id'); ?>
						</div>
					</div>

				<div class="control-group">
					<label class="control-label" for="name">Subscription Date </label>
					<div class="controls">
					<input id="subscription_date" name="data[ClientDeviceSubscription][subscribe_date]" value="<?php echo $sDate;?>" type="text" class="form_date"/>
					<?php echo $this->Form->error('subscription_date'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Expire Date </label>
					<div class="controls">
					<input id="expire_date" name="data[ClientDeviceSubscription][expire_date]" value="" type="text" class="form_date" readonly="readonly"/>
					<?php echo $this->Form->error('expire_date'); ?>
					</div>
				</div>

				<div class="form-actions">
					<button type="submit" class="btn btn-danger btn">Submit</button>
					&nbsp;&nbsp;
					<button type="reset" class="btn">Reset</button>
				</div>
			</fieldset>
			<?php
			echo $this->Form->end();
			echo $this->Js->writeBuffer();
			?>
		</div>
	</div>
</div>

<script>
	$(function() {
		APP_COMMON.initPage('Add Client Subscription');
		//$('#expire_date').datetimepicker('update', new Date());
		$('#subscription_date').datetimepicker();
		getExpireDate();
		$('#subscription_date').datetimepicker()
	    .on('changeDate', function(ev){
    		getExpireDate();
	    });
		$('#ClientDeviceSubscriptionAccountTypeId').bind('change',function(){
			getExpireDate();
		});
		function getExpireDate(){
		       var dt = $('#subscription_date').val();
		       var at = $('#ClientDeviceSubscriptionAccountTypeId').val();
		       APP_HELPER.ajaxSubmitDataCallback('clientDeviceSubscriptions/getExpireDateJson','at='+at+'&ad='+dt,function(data){
		    	   $('#expire_date').val(data);
			   });
		}
	});
</script>

