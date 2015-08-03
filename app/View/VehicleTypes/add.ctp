<div class="span12">
	<div class="box dark">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>
		<?php echo __('Add Vehicle Type'); ?>
		</h5>
		<div class="toolbar">
			<ul class="nav">
				<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxRequestModelAction('vehicleTypes/index');">
						<i class="icon-list-alt"></i> List </a>
				</li>
			</ul>
		</div>
		</header>
		<div class="in body" id="div-1">

		<?php
		echo $this->Session->flash();
		$data = $this->Js->get('#VehicleTypeAddForm')->serializeForm(array('isForm' => true, 'inline' => true));
		$this->Js->get('#VehicleTypeAddForm')->event(
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
						echo $this->Form->create('VehicleType', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
						?>
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="name">Name </label>
					<div class="controls">
					<?php echo $this->Form->input('name', array('class'=>'input-large'));
					echo $this->Form->error('name'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Speed Limit </label>
					<div class="controls">
					<?php echo $this->Form->input('def_speed_limit', array('class'=>'input-large'));
					echo $this->Form->error('def_speed_limit'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Minimum Mileage </label>
					<div class="controls">
					<?php echo $this->Form->input('def_min_mileage', array('class'=>'input-large'));
					echo $this->Form->error('def_min_mileage'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Maintanance Mileage </label>
					<div class="controls">
					<?php echo $this->Form->input('def_man_mileage', array('class'=>'input-large'));
					echo $this->Form->error('def_man_mileage'); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="name">Fuel Consumption </label>
					<div class="controls">
					<?php echo $this->Form->input('def_fuel_consumption', array('class'=>'input-large'));
					echo $this->Form->error('def_fuel_consumption'); ?>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="name">Description </label>
					<div class="controls">
					<?php echo $this->Form->input('description', array('class'=>'input-large'));
					echo $this->Form->error('description'); ?>
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
		APP_COMMON.initPage('Add Vehicle Type');
		$('#ajax-page-title').html('<i class="icon-user"></i> Vehicle Type : Add');	   
	});
</script>
