<div class="span12">
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>
		<?php echo __('Edit Client Device Subscription'); ?>		</h5>
		<div class="toolbar">
			<ul class="nav">
				<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxRequestModelAction('clientDeviceSubscriptions/index');"> <i
						class="icon-list-alt"></i> List </a></li>
										<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxDeleteRecord('clientDeviceSubscriptions/delete/'+$('#ClientDeviceSubscriptionId').val());">
						<i class="icon-remove"></i> Delete </a>
				</li>
							</ul>
		</div>
		</header>
		<div class="in body" id="div-1">
		
<?php 
				echo $this->Session->flash(); 
				$data = $this->Js->get('#ClientDeviceSubscriptionEditForm')->serializeForm(array('isForm' => true, 'inline' => true));
				$this->Js->get('#ClientDeviceSubscriptionEditForm')->event(
					'submit',
				$this->Js->request( 		
 array('action' => 'edit/'.$this->request->data['ClientDeviceSubscription']['id']),		
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
						echo $this->Form->create('ClientDeviceSubscription', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
						?>
			<fieldset>
			<?php echo $this->Form->input('id'); ?>				<div class="control-group">
					<label class="control-label" for="name">Client Info Id					</label>
					<div class="controls">
					<?php echo $this->Form->input('client_info_id', array('class'=>'input-large'));
 echo $this->Form->error('client_info_id'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">Client Device Id					</label>
					<div class="controls">
					<?php echo $this->Form->input('client_device_id', array('class'=>'input-large'));
 echo $this->Form->error('client_device_id'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">Subscription Date					</label>
					<div class="controls">
					<?php echo $this->Form->input('subscription_date', array('class'=>'input-large'));
 echo $this->Form->error('subscription_date'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">Expire Date					</label>
					<div class="controls">
					<?php echo $this->Form->input('expire_date', array('class'=>'input-large'));
 echo $this->Form->error('expire_date'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">Active					</label>
					<div class="controls">
					<?php echo $this->Form->input('active', array('class'=>'input-large'));
 echo $this->Form->error('active'); ?>					</div>
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
 ?>		</div>
	</div>
</div>

<script>
	$(function() {
		document.title = 'NITS::ClientDeviceSubscription';
		$('#ajax-page-title').html('<i class="icon-user"></i> Client Device Subscription : Edit');	   
	});
</script>