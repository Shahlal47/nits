<div class="clientExpenses view">
<h2><?php  echo __('Client Expense'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($clientExpense['ClientExpense']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Info'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientExpense['ClientInfo']['name'], array('controller' => 'client_infos', 'action' => 'view', $clientExpense['ClientInfo']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Expense Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientExpense['ExpenseType']['name'], array('controller' => 'expense_types', 'action' => 'view', $clientExpense['ExpenseType']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Client Device'); ?></dt>
		<dd>
			<?php echo $this->Html->link($clientExpense['ClientDevice']['name'], array('controller' => 'client_devices', 'action' => 'view', $clientExpense['ClientDevice']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ondate'); ?></dt>
		<dd>
			<?php echo h($clientExpense['ClientExpense']['ondate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Amount'); ?></dt>
		<dd>
			<?php echo h($clientExpense['ClientExpense']['amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comments'); ?></dt>
		<dd>
			<?php echo h($clientExpense['ClientExpense']['comments']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($clientExpense['ClientExpense']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($clientExpense['ClientExpense']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Client Expense'), array('action' => 'edit', $clientExpense['ClientExpense']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Client Expense'), array('action' => 'delete', $clientExpense['ClientExpense']['id']), null, __('Are you sure you want to delete # %s?', $clientExpense['ClientExpense']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Expenses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Expense'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Infos'), array('controller' => 'client_infos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Info'), array('controller' => 'client_infos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Expense Types'), array('controller' => 'expense_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Expense Type'), array('controller' => 'expense_types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Client Devices'), array('controller' => 'client_devices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Client Device'), array('controller' => 'client_devices', 'action' => 'add')); ?> </li>
	</ul>
</div>
