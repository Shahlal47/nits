<div class="span12">
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>
		<?php echo __('Edit Ext History'); ?>		</h5>
		<div class="toolbar">
			<ul class="nav">
				<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxRequestModelAction('extHistories/index');"> <i
						class="icon-list-alt"></i> List </a></li>
										<li><a href="javascript:;"
					onclick="APP_HELPER.ajaxDeleteRecord('extHistories/delete/'+$('#ExtHistoryId').val());">
						<i class="icon-remove"></i> Delete </a>
				</li>
							</ul>
		</div>
		</header>
		<div class="in body" id="div-1">
		
<?php 
				echo $this->Session->flash(); 
				$data = $this->Js->get('#ExtHistoryEditForm')->serializeForm(array('isForm' => true, 'inline' => true));
				$this->Js->get('#ExtHistoryEditForm')->event(
					'submit',
				$this->Js->request( 		
 array('action' => 'edit/'.$this->request->data['ExtHistory']['id']),		
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
						echo $this->Form->create('ExtHistory', array('inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
						?>
			<fieldset>
			<?php echo $this->Form->input('id'); ?>				<div class="control-group">
					<label class="control-label" for="name">Memo Number					</label>
					<div class="controls">
					<?php echo $this->Form->input('memo_number', array('class'=>'input-large'));
 echo $this->Form->error('memo_number'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">Ref Number					</label>
					<div class="controls">
					<?php echo $this->Form->input('ref_number', array('class'=>'input-large'));
 echo $this->Form->error('ref_number'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">From Date					</label>
					<div class="controls">
					<?php echo $this->Form->input('from_date', array('class'=>'input-large'));
 echo $this->Form->error('from_date'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">To Date					</label>
					<div class="controls">
					<?php echo $this->Form->input('to_date', array('class'=>'input-large'));
 echo $this->Form->error('to_date'); ?>					</div>
				</div>

								<div class="control-group">
					<label class="control-label" for="name">Client Device Subscriptions Id					</label>
					<div class="controls">
					<?php echo $this->Form->input('client_device_subscriptions_id', array('class'=>'input-large'));
 echo $this->Form->error('client_device_subscriptions_id'); ?>					</div>
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
		document.title = 'NITS::ExtHistory';
		$('#ajax-page-title').html('<i class="icon-user"></i> Ext History : Edit');	   
	});
</script>