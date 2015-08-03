<div class="expenseTypes view">
<h2><?php  echo __('Expense Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($expenseType['ExpenseType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($expenseType['ExpenseType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($expenseType['ExpenseType']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Expense Type'), array('action' => 'edit', $expenseType['ExpenseType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Expense Type'), array('action' => 'delete', $expenseType['ExpenseType']['id']), null, __('Are you sure you want to delete # %s?', $expenseType['ExpenseType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Expense Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Expense Type'), array('action' => 'add')); ?> </li>
	</ul>
</div>
