<div class="span3">
	<div class="well">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link('<i class="icon-list"></i>&nbsp;'.__('List Entities'),array('action'=>'index'), array('escape' => FALSE));?></li>
		</ul>
	</div>
</div>

<div class="span8">
	<h2><?php echo __('Entity'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($entity['Entity']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($entity['Entity']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Alias'); ?></dt>
		<dd>
			<?php echo h($entity['Entity']['alias']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Folder'); ?></dt>
		<dd>
			<?php echo h($entity['Entity']['folder']); ?>
			&nbsp;
		</dd>
	</dl>
</div>


