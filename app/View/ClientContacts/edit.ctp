<div class="span12">
	<div class="box dark">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>
				<?php echo __('Edit Client Contact'); ?>
			</h5>

		</header>
		<div class="in body" id="div-1">

			<?php
			echo $this->Session->flash();
			$data = $this->Js->get('#ClientContactEditForm')->serializeForm(array('isForm' => true, 'inline' => true));
			$this->Js->get('#ClientContactEditForm')->event(
					'submit',
					$this->Js->request(
							array('action' => 'edit/'.$this->request->data['ClientContact']['id'].'?clientid='.$this->request->data['ClientContact']['client_info_id']),
							array(
									'data' => $data,
									'async' => true,
									'dataExpression'=>true,
									'method' => 'POST',
									'before' => 'APP_HELPER.ajax_start();',
									'success' => "APP_HELPER.ajax_stop();APP_HELPER.loadContentHolder(data,'$ajaxPlaceholder');",
									'error' => 'APP_HELPER.ajax_error(errorThrown);'
							)
					)
			);
			echo $this->Form->create('ClientContact', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
			?>
			<fieldset>
				<?php echo $this->Form->input('id'); ?>

				<div class="control-group">
					<label class="control-label" for="name">Name </label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.name', array('class'=>'input-large'));
					echo $this->Form->error('ClientContact.name'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">National ID </label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.nationalid', array('class'=>'input-large'));
					echo $this->Form->error('ClientContact.nationalid'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Email </label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.email', array('class'=>'input-large'));
					echo $this->Form->error('ClientContact.email'); ?>
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
					<label class="control-label" for="name">Mobile<span class="mandatory">*</span></label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.mobile', array('class'=>'input-large'));
					echo $this->Form->error('ClientContact.mobile'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Mobile<span class="mandatory">*</span></label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.mobile_home', array('class'=>'input-large'));
						echo $this->Form->error('ClientContact.mobile_home'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Mobile<span class="mandatory">*</span></label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.mobile_office', array('class'=>'input-large'));
						echo $this->Form->error('ClientContact.mobile_office'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Fax </label>
					<div class="controls">
						<?php echo $this->Form->input('ClientContact.fax', array('class'=>'input-large'));
					echo $this->Form->error('ClientContact.fax'); ?>
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
		APP_COMMON.initPage('Edit Client Contacts');
		$('#ajax-page-title').html('<i class="icon-user"></i> Client Contact : Edit');	   
	});
</script>
