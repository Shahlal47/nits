<div class="span12">
	<div class="box">
		<header>
			<div class="icons">
				<i class="icon-edit"></i>
			</div>
			<h5>
				<?php echo __('Add '.$device_type['description']); ?>
			</h5>

		</header>
		<div class="in body" id="div-1">

			<?php
			echo $this->Session->flash();
			$data = $this->Js->get('#DeviceInfoAddForm')->serializeForm(array('isForm' => true, 'inline' => true));
			$this->Js->get('#DeviceInfoAddForm')->event(
					'submit',
					$this->Js->request(
							array('action' => 'add'),
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
			echo $this->Form->create('DeviceInfo', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
			?>
			<fieldset>
				<?php echo $this->Form->input('device_type_id', array('type'=>'hidden','value'=>$device_type['id']));?>
				<div class="control-group">
					<label class="control-label" for="name">Model </label>
					<div class="controls">
						<?php echo $this->Form->input('name', array('class'=>'input-large'));
					echo $this->Form->error('name'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Brand </label>
					<div class="controls">
						<?php echo $this->Form->input('brand', array('class'=>'input-large'));
					echo $this->Form->error('brand'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Description </label>
					<div class="controls">
						<?php echo $this->Form->input('description', array('class'=>'input-large'));
					echo $this->Form->error('description'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Sensors </label>
					<div class="controls">
						<?php echo $this->Form->input('sensors', array('class'=>'input-large'));
					echo $this->Form->error('sensors'); ?>
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
		APP_COMMON.initPage('Add Device Information');
		$('#ajax-page-title').html('<i class="icon-user"></i> Device Info : Add');	  
		jQuery('select.readonly option:not(:selected)').attr('disabled',true);		
	});
</script>
