<div class="span12">
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>
		<?php echo __('Edit Client Device'); ?>
		</h5>
		<div class="toolbar">
			<ul class="nav">
				<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxLoad('clientDeviceSubscriptions/add/<?php echo $this->request->data['ClientDevice']['deviceid']?>','#ajaxClientInfo');">
						<i class="icon-list-alt"></i> New Subscription </a>
				</li>
				<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxLoad('clientDeviceSubscriptions/index/<?php echo $this->request->data['ClientDevice']['deviceid']?>','#ajaxClientInfo');">
						<i class="icon-list-alt"></i> Subscription History </a>
				</li>
			</ul>
		</div>

		</header>
		<div class="in body" id="div-1">

		<?php
		echo $this->Session->flash();
		$data = $this->Js->get('#ClientDeviceEditForm')->serializeForm(array('isForm' => true, 'inline' => true));
		$this->Js->get('#ClientDeviceEditForm')->event(
					'submit',
		$this->Js->request(
		array('action' => 'edit/'.$this->request->data['ClientDevice']['id'].'?clientid='.$client_info_id),
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
						echo $this->Form->create('ClientDevice', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
						?>
			<fieldset>
			<?php echo $this->Form->input('id'); ?>

				<fieldset>
					<legend>Device Information</legend>
					<div class="control-group">
						<label class="control-label" for="name">Device Type </label>
						<div class="controls">
						<?php echo $this->Form->input('device_type_id', array('class'=>'input-large','readonly'=>'readonly'));
						echo $this->Form->error('device_type_id'); ?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="name">Device Model </label>
						<div class="controls">
						<?php echo $this->Form->input('device_info_id', array('class'=>'input-large','readonly'=>'readonly'));
						echo $this->Form->error('device_info_id'); ?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="name">Device ID</label>
						<div class="controls">
						<?php echo $this->Form->input('deviceid', array('class'=>'input-large','readonly'=>'readonly'));
						echo $this->Form->error('deviceid'); ?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="name">IMEI </label>
						<div class="controls">
						<?php echo $this->Form->input('imei', array('class'=>'input-large', 'maxlength'=>20));
						echo $this->Form->error('imei'); ?>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label" for="name">Tracker ID *</label>
						<div class="controls">
							<?php echo $this->Form->input('tracker_id', array('class'=>'input-large', 'type'=>'text', 'maxlength'=>20));
						echo $this->Form->error('tracker_id'); ?>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="name">Unit SIM *</label>
						<div class="controls">
						<?php echo $this->Form->input('mob_no', array('class'=>'input-large', 'maxlength'=>20));
						echo $this->Form->error('mob_no'); ?>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label" for="name">Credit File Number </label>
						<div class="controls">
							<?php echo $this->Form->input('credit_file_num', array('type' => 'text', 'class'=>'input-large'));
						echo $this->Form->error('credit_file_num'); ?>
						</div>
					</div>
					
				</fieldset>
				<fieldset>
					<legend id="legendTrackerInfo">Person Information</legend>
					<div class="control-group">
						<label id="lblTrackerName" class="control-label" for="name">Person Name *</label>
						<div class="controls">
						<?php echo $this->Form->input('name', array('class'=>'input-large','maxlength'=>128));
						echo $this->Form->error('name'); ?>
						</div>
					</div>
					<div id="divVehicleTrakcker">
						<div class="control-group">
							<label class="control-label" for="name">Vehicle Type *</label>
							<div class="controls">
							<?php echo $this->Form->input('vehicle_type_id', array('class'=>'input-large'));
							echo $this->Form->error('vehicle_type_id'); ?>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="name">Vehicle Model *</label>
							<div class="controls">
								<?php echo $this->Form->input('vehicle_model_id', array('class'=>'input-large'));
							echo $this->Form->error('vehicle_model_id'); ?>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="name">Vehicle Desciption </label>
							<div class="controls">
							<?php echo $this->Form->input('tags', array('class'=>'input-large'));
							echo $this->Form->error('tags'); ?>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="name">Speed Limit *</label>
							<div class="controls">
							<?php echo $this->Form->input('speed_limit', array('class'=>'input-large','maxlength'=>20, 'class'=>'text-right'));
							echo $this->Form->error('speed_limit'); ?>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="name">Minimum Mileage *</label>
							<div class="controls">
							<?php echo $this->Form->input('minimum_mileage', array('class'=>'input-large','maxlength'=>20, 'class'=>'text-right'));
							echo $this->Form->error('minimum_mileage'); ?>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="name">Maintenance Mileage *</label>
							<div class="controls">
							<?php echo $this->Form->input('maintenance_mileage', array('class'=>'input-large','maxlength'=>20, 'class'=>'text-right'));
							echo $this->Form->error('maintenance_mileage'); ?>
							</div>
						</div>

						<div class="control-group">
							<label class="control-label" for="name">Fuel Consumption *</label>
							<div class="controls">
							<?php echo $this->Form->input('fuel_consumption', array('class'=>'input-large','maxlength'=>20, 'class'=>'text-right'));
							echo $this->Form->error('fuel_consumption'); ?>
							</div>
						</div>
												
					</div>
				</fieldset>
				<div class="form-actions">
					<button type="submit" class="btn btn-danger btn" id="btnSaveClientDevice">Submit</button>
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
		APP_COMMON.initPage('Add Client Devices');
		var v = $('#ClientDeviceVehicleTypeId').val();
		populateVehicleDefaults(v);
		$('#ajax-page-title').html('<i class="icon-user"></i> Client Device : Add');	
		var val = $('#ClientDeviceDeviceTypeId').val();
		if(val==1){
			$('#divVehicleTrakcker').hide();
			$('#legendTrackerInfo').html('Person Information');
			$('#lblTrackerName').html('Person Name');
		}else{
			$('#divVehicleTrakcker').show();
			$('#legendTrackerInfo').html('Vehicle Information');
			$('#lblTrackerName').html('Vehicle Registration Number *');
		}

		$('#ClientDeviceVehicleTypeId').bind('change',function(){
			var v = $(this).val();
			populateVehicleDefaults(v);
		});
		function populateVehicleDefaults(v){
			APP_HELPER.ajaxLoadCallback('vehicleTypes/get_vahicle_defaults/'+v,function(data){
				$('#ClientDeviceSpeedLimit').val(data.VehicleType.def_speed_limit);
				$('#ClientDeviceMinimumMileage').val(data.VehicleType.def_min_mileage);
				$('#ClientDeviceMaintenanceMileage').val(data.VehicleType.def_man_mileage);
				$('#ClientDeviceFuelConsumption').val(data.VehicleType.def_fuel_consumption);

				$("#ClientDeviceVehicleModelId").empty();
				APP_HELPER.ajaxLoadCallback('vehicleModels/getVehicleModelByVehicleType/'+v,function(data){
					var a = '';
					$.each(data, function(index, val) {
							a += '<option value="'+index+'">'+val+'</option>'; 
				       });
					$("#ClientDeviceVehicleModelId").append(a);
					$("#ClientDeviceVehicleModelId").val('<?php echo $this->request->data['ClientDevice']['vehicle_model_id'];?>');
				});
			}); 
		}
	});
</script>
