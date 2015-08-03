<div class="sensorTypes view">
<h2><?php  echo __('Sensor Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($sensorType['SensorType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($sensorType['SensorType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($sensorType['SensorType']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sensor Type'), array('action' => 'edit', $sensorType['SensorType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sensor Type'), array('action' => 'delete', $sensorType['SensorType']['id']), null, __('Are you sure you want to delete # %s?', $sensorType['SensorType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sensor Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sensor Type'), array('action' => 'add')); ?> </li>
	</ul>
</div>
