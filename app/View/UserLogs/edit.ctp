<div class="span12">
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>
		<?php echo __('Edit User Log'); ?>		</h5>
		<div class="toolbar">
			<ul class="nav">
				<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxRequestModelAction('userLogs/index');"> <i
						class="icon-list-alt"></i> List </a></li>
										<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxDeleteRecord('userLogs/delete/'+$('#UserLogId').val());">
						<i class="icon-remove"></i> Delete </a>
				</li>
							</ul>
		</div>
		</header>
		<div class="in body" id="div-1">
		
<?php 
				echo $this->Session->flash(); 
				$data = $this->Js->get('#UserLogEditForm')->serializeForm(array('isForm' => true, 'inline' => true));
				$this->Js->get('#UserLogEditForm')->event(
					'submit',
				$this->Js->request( 		
 array('action' => 'edit/'.$this->request->data['UserLog']['id']),		
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
						echo $this->Form->create('UserLog', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
						?>
			<fieldset>
			<?php echo $this->Form->input('id'); ?>				<div class="control-group">
					<label class="control-label" for="name">User Id					</label>
					<div class="controls">
					<?php echo $this->Form->input('user_id', array('class'=>'input-large'));
 echo $this->Form->error('user_id'); ?>					</div>
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
		document.title = 'NITS::UserLog';
		$('#ajax-page-title').html('<i class="icon-user"></i> User Log : Edit');	   
	});
</script>