<div class="poiTypes view">
<h2><?php  echo __('Poi Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($poiType['PoiType']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($poiType['PoiType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Marker'); ?></dt>
		<dd>
			<?php echo h($poiType['PoiType']['marker']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Poi Type'), array('action' => 'edit', $poiType['PoiType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Poi Type'), array('action' => 'delete', $poiType['PoiType']['id']), null, __('Are you sure you want to delete # %s?', $poiType['PoiType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Poi Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poi Type'), array('action' => 'add')); ?> </li>
	</ul>
</div>
