  <li><a href="#" class="dropdown" title="<?php echo $label ?>" data-toggle="dropdown">
  	<i class="glyphicon glyphicon-user"></i> <span class="title"><?php echo $label ?></span> <b class="caret"></b></a>
		<ul class="dropdown-menu">
<?php	foreach($items as $key => $item) { ?>
				<?php echo $this->makeListItem($key, $item); ?>
<?php	} ?>
		</ul>
	</li>