<div class="clientDeviceSubscriptions view">
<h2><?php  echo __('Client Device Subscription'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($clientDeviceSubscription['ClientDeviceSubscription']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Info'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientDeviceSubscription['ClientInfo']['name'], array('controller' => 'client_infos', 'action' => 'view', $clientDeviceSubscription['ClientInfo']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Device'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientDeviceSubscription['ClientDevice']['name'], array('controller' => 'client_devices', 'action' => 'view', $clientDeviceSubscription['ClientDevice']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subscription Date'); ?></dt>
		<dd>
			<?php echo h($clientDeviceSubscription['ClientDeviceSubscription']['subscription_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Expire Date'); ?></dt>
		<dd>
			<?php echo h($clientDeviceSubscription['ClientDeviceSubscription']['expire_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($clientDeviceSubscription['ClientDeviceSubscription']['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($clientDeviceSubscription['ClientDeviceSubscription']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($clientDeviceSubscription['ClientDeviceSubscription']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Client Device Subscription'), array('action' => 'edit', $clientDeviceSubscription['ClientDeviceSubscription']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Client Device Subscription'), array('action' => 'delete', $clientDeviceSubscription['ClientDeviceSubscription']['id']), null, __('Are you sure you want to delete # %s?', $clientDeviceSubscription['ClientDeviceSubscription']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Device Subscriptions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Device Subscription'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Infos'), array('controller' => 'client_infos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Info'), array('controller' => 'client_infos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Devices'), array('controller' => 'client_devices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Device'), array('controller' => 'client_devices', 'action' => 'add')); ?> </li>
	</ul>
</div>
