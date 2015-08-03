<div class="clientAlertSettings view">
<h2><?php  echo __('Client Alert Setting'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($clientAlertSetting['ClientAlertSetting']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Info'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientAlertSetting['ClientInfo']['name'], array('controller' => 'client_infos', 'action' => 'view', $clientAlertSetting['ClientInfo']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Alert Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientAlertSetting['AlertType']['name'], array('controller' => 'alert_types', 'action' => 'view', $clientAlertSetting['AlertType']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Contact'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientAlertSetting['ClientContact']['name'], array('controller' => 'client_contacts', 'action' => 'view', $clientAlertSetting['ClientContact']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($clientAlertSetting['ClientAlertSetting']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($clientAlertSetting['ClientAlertSetting']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Device'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientAlertSetting['ClientDevice']['name'], array('controller' => 'client_devices', 'action' => 'view', $clientAlertSetting['ClientDevice']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Sms'); ?></dt>
		<dd>
			<?php echo h($clientAlertSetting['ClientAlertSetting']['is_sms']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Email'); ?></dt>
		<dd>
			<?php echo h($clientAlertSetting['ClientAlertSetting']['is_email']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Client Alert Setting'), array('action' => 'edit', $clientAlertSetting['ClientAlertSetting']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Client Alert Setting'), array('action' => 'delete', $clientAlertSetting['ClientAlertSetting']['id']), null, __('Are you sure you want to delete # %s?', $clientAlertSetting['ClientAlertSetting']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Alert Settings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Alert Setting'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Infos'), array('controller' => 'client_infos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Info'), array('controller' => 'client_infos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Alert Types'), array('controller' => 'alert_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Alert Type'), array('controller' => 'alert_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Contacts'), array('controller' => 'client_contacts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Contact'), array('controller' => 'client_contacts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Devices'), array('controller' => 'client_devices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Device'), array('controller' => 'client_devices', 'action' => 'add')); ?> </li>
	</ul>
</div>
