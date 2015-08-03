<div class="span12">
	<div class="box" id="divClientInfo">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>
				<?php echo __('Edit Client Information'); ?>
			</h5>
		</header>
		<div class="in body" id="div-1">

			<?php
			echo $this->Session->flash();
			$data = $this->Js->get('#ClientInfoEditForm')->serializeForm(array('isForm' => true, 'inline' => true));
			$this->Js->get('#ClientInfoEditForm')->event(
					'submit',
					$this->Js->request(
							array('action' => 'edit/'.$this->request->data['ClientInfo']['id']),
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
				<legend>User Account</legend>
				<?php echo $this->Form->input('id'); ?>
				<div>
					<div class="control-group">
						<label class="control-label" for="name">Username </label>
						<div class="controls">
							<?php echo $this->Form->input('User.username', array('class'=>'input-large', 'disabled'=>'disabled'));
						echo $this->Form->error('User.username'); ?>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>Client Information</legend>
				<div>
					<div class="control-group">
						<label class="control-label" for="name">Client Type</label>
						<div class="controls">
							<?php echo $this->Form->input('ClientInfo.client_type_id', array('class'=>'input-large', 'disabled'=>'disabled'));
						echo $this->Form->error('ClientInfo.client_type_id'); ?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="name" id="lblName">Name </label>
						<div class="controls">
							<?php echo $this->Form->input('ClientInfo.name', array('class'=>'input-large','maxlength'=>64));
						echo $this->Form->error('ClientInfo.name'); ?>
						</div>
					</div>


					<div class="control-group" id="divCompanyType">
						<label class="control-label" for="name">Company Type</label>
						<div class="controls">
							<?php echo $this->Form->input('ClientInfo.company_type_id', array('class'=>'input-large'));
						echo $this->Form->error('ClientInfo.company_type_id'); ?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="name" id="lblName">Buyer No </label>
						<div class="controls">
							<?php echo $this->Form->input('ClientInfo.buyerno', array('class'=>'input-large'));
						echo $this->Form->error('ClientInfo.buyerno'); ?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="name">Address </label>
						<div class="controls">
							<?php echo $this->Form->input('ClientInfo.address', array('class'=>'input-large'));
						echo $this->Form->error('ClientInfo.address'); ?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="website" id="lblName">Website</label>
						<div class="controls">
							<?php echo $this->Form->input('ClientInfo.website', array('class'=>'input-large'));
						echo $this->Form->error('ClientInfo.website'); ?>
						</div>
					</div>
				</div>

			</fieldset>
			<fieldset>
				<legend>Client Contact Detail</legend>
				<div>
					<?php echo $this->Form->input('ClientContact.id'); ?>
					<div class="control-group" id="divContactName">
						<label class="control-label" for="name">Contact Person Name </label>
						<div class="controls">
							<?php echo $this->Form->input('ClientContact.name', array('class'=>'input-large','maxlength'=>128));
						echo $this->Form->error('ClientContact.name'); ?>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label" for="name" id="lblName">National ID </label>
						<div class="controls">
							<?php echo $this->Form->input('ClientContact.nationalid', array('class'=>'input-large', 'maxlength'=>17));
						echo $this->Form->error('ClientContact.nationalid'); ?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="name">Phone </label>
						<div class="controls">
							<?php echo $this->Form->input('ClientContact.phone', array('class'=>'input-large'));
						echo $this->Form->error('ClientContact.phone'); ?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="name">Mobile<span
							class="mandatory">*</span>
						</label>
						<div class="controls">
							<?php echo $this->Form->input('ClientContact.mobile', array('class'=>'input-large','maxlength'=>20));
						echo $this->Form->error('ClientContact.mobile'); ?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="name">Mobile<span
							class="mandatory">*</span>
						</label>
						<div class="controls">
							<?php echo $this->Form->input('ClientContact.mobile_home', array('class'=>'input-large', 'maxlength'=>20));
						echo $this->Form->error('ClientContact.mobile_home'); ?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="name">Mobile<span
							class="mandatory">*</span>
						</label>
						<div class="controls">
							<?php echo $this->Form->input('ClientContact.mobile_office', array('class'=>'input-large','maxlength'=>20));
						echo $this->Form->error('ClientContact.mobile_office'); ?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="name">Email </label>
						<div class="controls">
							<?php echo $this->Form->input('ClientContact.email', array('class'=>'input-large','maxlength'=>64));
						echo $this->Form->error('ClientContact.email'); ?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="name">Fax </label>
						<div class="controls">
							<?php echo $this->Form->input('ClientContact.fax', array('class'=>'input-large','maxlength'=>30));
						echo $this->Form->error('ClientContact.fax'); ?>
						</div>
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
		APP_COMMON.initPage('Edit Client Information');
		$('#ajax-page-title').html('<i class="icon-user"></i> Client Info : Edit');
		if($('#ClientInfoClientTypeId').val()==1){
			$('#divCompanyType').hide();
			$('#divContactName').hide();
			$('#lblName').html('Name');
		}else{
			$('#lblName').html('Business Name');
		}
	});
</script>
