<div class="deviceTypes view">
<h2><?php  echo __('Device Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($deviceType['DeviceType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($deviceType['DeviceType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($deviceType['DeviceType']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Device Type'), array('action' => 'edit', $deviceType['DeviceType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Device Type'), array('action' => 'delete', $deviceType['DeviceType']['id']), null, __('Are you sure you want to delete # %s?', $deviceType['DeviceType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Device Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Device Type'), array('action' => 'add')); ?> </li>
	</ul>
</div>
