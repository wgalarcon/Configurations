<?php if(isset($authuser['Group']['name']) && $authuser['Group']['name'] == 'superadmin'): ?>
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog"></i>&nbsp;<?php echo __('Configurations') ?><b class="caret"></b></a>
	<ul class="dropdown-menu">		
		<li><?php echo $this->Html->link(__('Entities'), array('plugin'=>'configurations', 'controller' => 'entities', 'action' => 'index', 'admin' => TRUE)); ?></li>	
		<li><?php echo $this->Html->link(__('Languages'), array('plugin'=>'configurations', 'controller' => 'languages', 'action' => 'index', 'admin' => TRUE)); ?></li>	
		<li><?php echo $this->Html->link(__('Locations'), array('plugin'=>'configurations', 'controller' => 'locations', 'action' => 'index', 'admin' => TRUE)); ?></li>	
	</ul>
</li>
<?php endif; ?>