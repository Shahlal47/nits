<div class="span12">
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>
		<?php echo __('Edit Client Device Geofence'); ?>		</h5>
		<div class="toolbar">
			<ul class="nav">
				<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxRequestModelAction('clientDeviceGeofences/index');"> <i
						class="icon-list-alt"></i> List </a></li>
										<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxDeleteRecord('clientDeviceGeofences/delete/'+$('#ClientDeviceGeofenceId').val());">
						<i class="icon-remove"></i> Delete </a>
				</li>
							</ul>
		</div>
		</header>
		<div class="in body" id="div-1">
		
<?php 
				echo $this->Session->flash(); 
				$data = $this->Js->get('#ClientDeviceGeofenceEditForm')->serializeForm(array('isForm' => true, 'inline' => true));
				$this->Js->get('#ClientDeviceGeofenceEditForm')->event(
					'submit',
				$this->Js->request( 		
 array('action' => 'edit/'.$this->request->data['ClientDeviceGeofence']['id']),		
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
						echo $this->Form->create('ClientDeviceGeofence', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
						?>
			<fieldset>
			<?php echo $this->Form->input('id'); ?>				<div class="control-group">
					<label class="control-label" for="name">Client Contact Id					</label>
					<div class="controls">
					<?php echo $this->Form->input('client_contact_id', array('class'=>'input-large'));
 echo $this->Form->error('client_contact_id'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">Client Device Id					</label>
					<div class="controls">
					<?php echo $this->Form->input('client_device_id', array('class'=>'input-large'));
 echo $this->Form->error('client_device_id'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">Geofence Id					</label>
					<div class="controls">
					<?php echo $this->Form->input('geofence_id', array('class'=>'input-large'));
 echo $this->Form->error('geofence_id'); ?>					</div>
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
		APP_COMMON.initPage('Geo-Fence Manager');
		$('#ajax-page-title').html('<i class="icon-user"></i> Client Device Geofence : Edit');	   
	});
</script>