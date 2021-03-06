<div class="trackerTypes view">
<h2><?php  echo __('Tracker Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($trackerType['TrackerType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($trackerType['TrackerType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($trackerType['TrackerType']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tracker Type'), array('action' => 'edit', $trackerType['TrackerType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tracker Type'), array('action' => 'delete', $trackerType['TrackerType']['id']), null, __('Are you sure you want to delete # %s?', $trackerType['TrackerType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tracker Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tracker Type'), array('action' => 'add')); ?> </li>
	</ul>
</div>
