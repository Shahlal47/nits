<div class="geofenceTypes view">
<h2><?php  echo __('Geofence Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($geofenceType['GeofenceType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($geofenceType['GeofenceType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($geofenceType['GeofenceType']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Geofence Type'), array('action' => 'edit', $geofenceType['GeofenceType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Geofence Type'), array('action' => 'delete', $geofenceType['GeofenceType']['id']), null, __('Are you sure you want to delete # %s?', $geofenceType['GeofenceType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Geofence Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Geofence Type'), array('action' => 'add')); ?> </li>
	</ul>
</div>
