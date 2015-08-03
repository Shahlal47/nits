<div class="userLogs view">
<h2><?php  echo __('User Log'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($userLog['UserLog']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($userLog['User']['name'], array('controller' => 'users', 'action' => 'view', $userLog['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($userLog['UserLog']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User Log'), array('action' => 'edit', $userLog['UserLog']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User Log'), array('action' => 'delete', $userLog['UserLog']['id']), null, __('Are you sure you want to delete # %s?', $userLog['UserLog']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List User Logs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Log'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
