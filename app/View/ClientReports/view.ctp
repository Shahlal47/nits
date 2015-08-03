<div class="clientReports view">
<h2><?php  echo __('Client Report'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($clientReport['ClientReport']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Info'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientReport['ClientInfo']['name'], array('controller' => 'client_infos', 'action' => 'view', $clientReport['ClientInfo']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Reports'); ?></dt>
		<dd>
			<?php echo h($clientReport['ClientReport']['reports']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($clientReport['ClientReport']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($clientReport['ClientReport']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Client Report'), array('action' => 'edit', $clientReport['ClientReport']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Client Report'), array('action' => 'delete', $clientReport['ClientReport']['id']), null, __('Are you sure you want to delete # %s?', $clientReport['ClientReport']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Reports'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Report'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Infos'), array('controller' => 'client_infos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Info'), array('controller' => 'client_infos', 'action' => 'add')); ?> </li>
	</ul>
</div>
