<div class="span12" style="margin: 0;">
	<div class="box">
		<header>
		<div class="icons">
			<i class="icon-edit"></i>
		</div>
		<h5>
		<?php echo __('Upload Client Logo'); ?>
		</h5>
		</header>
		<div class="in body" id="div-1">
		<?php
		echo $this->Session->flash();
		echo $this->Form->create('ClientInfo', array('type' => 'file','inputDefaults' => array('label' => false,'div' => false, 'error' => false), 'class'=>'form-horizontal'));
		?>
			<fieldset>
			<?php echo $this->Form->input('ClientInfo.id', array('type'=>'hidden'));?>
			<?php echo $this->Form->input('ClientInfo.name', array('type'=>'hidden'));?>
				<?php if(!empty($this->request->data['ClientInfo']['logo'])){?>
				<div class="control-group">
					<div class="controls">
						<img src="<?php echo $this->webroot;?>files/logo/<?php echo $this->request->data['ClientInfo']['logo']?>" />
					</div>
				</div>
				<br/>
				<?php }?>
				<div class="control-group">
					<div class="controls">
					<?php echo $this->Form->input('ClientInfo.filename', array('type' => 'file', 'class'=>'input-large'));
					echo $this->Form->error('ClientInfo.filename'); ?>

					</div>
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-danger btn">Submit</button>
				</div>
			</fieldset>
			<?php echo $this->Form->end() ?>
		</div>
	</div>
</div>
<style>
.message {
	bachground-color: green;
}
</style>
