<div class="reportSettings view">
<h2><?php  echo __('Report Setting'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($reportSetting['ReportSetting']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($reportSetting['ReportSetting']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($reportSetting['ReportSetting']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Report Setting'), array('action' => 'edit', $reportSetting['ReportSetting']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Report Setting'), array('action' => 'delete', $reportSetting['ReportSetting']['id']), null, __('Are you sure you want to delete # %s?', $reportSetting['ReportSetting']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Report Settings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Report Setting'), array('action' => 'add')); ?> </li>
	</ul>
</div>
