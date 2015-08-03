<div class="clientDevices view">
<h2><?php  echo __('Client Device'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Info'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientDevice['ClientInfo']['name'], array('controller' => 'client_infos', 'action' => 'view', $clientDevice['ClientInfo']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deviceid'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['deviceid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Device Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientDevice['DeviceType']['name'], array('controller' => 'device_types', 'action' => 'view', $clientDevice['DeviceType']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vehicle Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientDevice['VehicleType']['name'], array('controller' => 'vehicle_types', 'action' => 'view', $clientDevice['VehicleType']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sensors'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['sensors']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Imei'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['imei']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mob No'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['mob_no']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Speed Limit'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['speed_limit']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Minimum Mileage'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['minimum_mileage']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Maintenance Mileage'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['maintenance_mileage']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fuel Consumption'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['fuel_consumption']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Expiry Date'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['expiry_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comments'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['comments']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Account Type Id'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['account_type_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Contact Id'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['client_contact_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($clientDevice['ClientDevice']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Client Device'), array('action' => 'edit', $clientDevice['ClientDevice']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Client Device'), array('action' => 'delete', $clientDevice['ClientDevice']['id']), null, __('Are you sure you want to delete # %s?', $clientDevice['ClientDevice']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Devices'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Device'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Infos'), array('controller' => 'client_infos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Info'), array('controller' => 'client_infos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Device Types'), array('controller' => 'device_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Device Type'), array('controller' => 'device_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Vehicle Types'), array('controller' => 'vehicle_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vehicle Type'), array('controller' => 'vehicle_types', 'action' => 'add')); ?> </li>
	</ul>
</div>
