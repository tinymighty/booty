<li class="toolbox-menu dropdown">
  <a href="" data-toggle="dropdown" class="dropdown-toggle">
    <i class="glyphicon glyphicon-cog"></i> <span class="title"><?php echo $title ?></span> <b class="caret"></b>
  </a>
  <ul class="dropdown-menu">
	<?php foreach($items as $key => $item): ?>
		<?php echo $this->makeListItem($key, $item); ?>
	<?php endforeach; ?>
	</ul>
</li>
