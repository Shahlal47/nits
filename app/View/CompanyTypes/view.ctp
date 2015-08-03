<div class="companyTypes view">
<h2><?php  echo __('Company Type'); ?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($companyType['CompanyType']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($companyType['CompanyType']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($companyType['CompanyType']['id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Company Type'), array('action' => 'edit', $companyType['CompanyType']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Company Type'), array('action' => 'delete', $companyType['CompanyType']['id']), null, __('Are you sure you want to delete # %s?', $companyType['CompanyType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Company Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company Type'), array('action' => 'add')); ?> </li>
	</ul>
</div>
