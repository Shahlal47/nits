<div class="vehicleTypes view">
<h2><?php  echo __('Vehicle Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($vehicleType['VehicleType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($vehicleType['VehicleType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($vehicleType['VehicleType']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Vehicle Type'), array('action' => 'edit', $vehicleType['VehicleType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Vehicle Type'), array('action' => 'delete', $vehicleType['VehicleType']['id']), null, __('Are you sure you want to delete # %s?', $vehicleType['VehicleType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Vehicle Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehicle Type'), array('action' => 'add')); ?> </li>
	</ul>
</div>
