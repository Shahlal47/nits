<div class="clientContactDevices view">
<h2><?php  echo __('Client Contact Device'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($clientContactDevice['ClientContactDevice']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Contact'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientContactDevice['ClientContact']['name'], array('controller' => 'client_contacts', 'action' => 'view', $clientContactDevice['ClientContact']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Device'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientContactDevice['ClientDevice']['name'], array('controller' => 'client_devices', 'action' => 'view', $clientContactDevice['ClientDevice']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($clientContactDevice['ClientContactDevice']['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($clientContactDevice['ClientContactDevice']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($clientContactDevice['ClientContactDevice']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Client Contact Device'), array('action' => 'edit', $clientContactDevice['ClientContactDevice']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Client Contact Device'), array('action' => 'delete', $clientContactDevice['ClientContactDevice']['id']), null, __('Are you sure you want to delete # %s?', $clientContactDevice['ClientContactDevice']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Contact Devices'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Contact Device'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Contacts'), array('controller' => 'client_contacts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Contact'), array('controller' => 'client_contacts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Devices'), array('controller' => 'client_devices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Device'), array('controller' => 'client_devices', 'action' => 'add')); ?> </li>
	</ul>
</div>
