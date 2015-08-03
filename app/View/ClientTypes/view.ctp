<div class="clientTypes view">
<h2><?php  echo __('Client Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($clientType['ClientType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($clientType['ClientType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($clientType['ClientType']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Client Type'), array('action' => 'edit', $clientType['ClientType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Client Type'), array('action' => 'delete', $clientType['ClientType']['id']), null, __('Are you sure you want to delete # %s?', $clientType['ClientType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Type'), array('action' => 'add')); ?> </li>
	</ul>
</div>
