<div class="extHistories view">
<h2><?php  echo __('Ext History'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($extHistory['ExtHistory']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Memo Number'); ?></dt>
		<dd>
			<?php echo h($extHistory['ExtHistory']['memo_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ref Number'); ?></dt>
		<dd>
			<?php echo h($extHistory['ExtHistory']['ref_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('From Date'); ?></dt>
		<dd>
			<?php echo h($extHistory['ExtHistory']['from_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('To Date'); ?></dt>
		<dd>
			<?php echo h($extHistory['ExtHistory']['to_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($extHistory['ExtHistory']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Device Subscriptions Id'); ?></dt>
		<dd>
			<?php echo h($extHistory['ExtHistory']['client_device_subscriptions_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ext History'), array('action' => 'edit', $extHistory['ExtHistory']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Ext History'), array('action' => 'delete', $extHistory['ExtHistory']['id']), null, __('Are you sure you want to delete # %s?', $extHistory['ExtHistory']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Ext Histories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ext History'), array('action' => 'add')); ?> </li>
	</ul>
</div>
