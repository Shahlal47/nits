<div class="fuelTypes view">
<h2><?php  echo __('Fuel Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($fuelType['FuelType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($fuelType['FuelType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($fuelType['FuelType']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Fuel Type'), array('action' => 'edit', $fuelType['FuelType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Fuel Type'), array('action' => 'delete', $fuelType['FuelType']['id']), null, __('Are you sure you want to delete # %s?', $fuelType['FuelType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Fuel Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Fuel Type'), array('action' => 'add')); ?> </li>
	</ul>
</div>
