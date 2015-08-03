<div class="deviceInfos view">
<h2><?php  echo __('Device Info'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($deviceInfo['DeviceInfo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($deviceInfo['DeviceInfo']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($deviceInfo['DeviceInfo']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Device Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($deviceInfo['DeviceType']['name'], array('controller' => 'device_types', 'action' => 'view', $deviceInfo['DeviceType']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Brand'); ?></dt>
		<dd>
			<?php echo h($deviceInfo['DeviceInfo']['brand']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($deviceInfo['DeviceInfo']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($deviceInfo['DeviceInfo']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Device Info'), array('action' => 'edit', $deviceInfo['DeviceInfo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Device Info'), array('action' => 'delete', $deviceInfo['DeviceInfo']['id']), null, __('Are you sure you want to delete # %s?', $deviceInfo['DeviceInfo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Device Infos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Device Info'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Device Types'), array('controller' => 'device_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Device Type'), array('controller' => 'device_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
