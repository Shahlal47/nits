<div class="span12">
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>
		<?php echo __('Edit Geofence'); ?>		</h5>
		<div class="toolbar">
			<ul class="nav">
				<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxRequestModelAction('geofences/index');"> <i
						class="icon-list-alt"></i> List </a></li>
										<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxDeleteRecord('geofences/delete/'+$('#GeofenceId').val());">
						<i class="icon-remove"></i> Delete </a>
				</li>
							</ul>
		</div>
		</header>
		<div class="in body" id="div-1">
		
<?php 
				echo $this->Session->flash(); 
				$data = $this->Js->get('#GeofenceEditForm')->serializeForm(array('isForm' => true, 'inline' => true));
				$this->Js->get('#GeofenceEditForm')->event(
					'submit',
				$this->Js->request( 		
 array('action' => 'edit/'.$this->request->data['Geofence']['id']),		
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
						echo $this->Form->create('Geofence', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
						?>
			<fieldset>
			<?php echo $this->Form->input('id'); ?>				<div class="control-group">
					<label class="control-label" for="name">Client Device					</label>
					<div class="controls">
					<?php echo $this->Form->input('client_device_id', array('class'=>'input-large'));
 echo $this->Form->error('client_device_id'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">Geofence Type					</label>
					<div class="controls">
					<?php echo $this->Form->input('geofence_type_id', array('class'=>'input-large'));
 echo $this->Form->error('geofence_type_id'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">Geofence Points					</label>
					<div class="controls">
					<?php echo $this->Form->input('geofence_points', array('class'=>'input-large'));
 echo $this->Form->error('geofence_points'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">Geofence Obj Type					</label>
					<div class="controls">
					<?php echo $this->Form->input('geofence_obj_type', array('class'=>'input-large'));
 echo $this->Form->error('geofence_obj_type'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">Name					</label>
					<div class="controls">
					<?php echo $this->Form->input('name', array('class'=>'input-large'));
 echo $this->Form->error('name'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">Active					</label>
					<div class="controls">
					<?php echo $this->Form->input('active', array('class'=>'input-large'));
 echo $this->Form->error('active'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">ClientDevice					</label>
					<div class="controls">
					<?php 		echo $this->Form->input('ClientDevice', array('class'=>'input-large'));?>					</div>
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
		document.title = 'NITS::Geofence';
		$('#ajax-page-title').html('<i class="icon-user"></i> Geofence : Edit');	   
	});
</script>