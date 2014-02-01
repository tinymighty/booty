  <li class="user-menu dropdown"><a href="#" class="dropdown-toggle" title="<?php echo $title ?>" data-toggle="dropdown">
  	<i class="glyphicon glyphicon-user"></i> <span class="title"><?php echo $title ?></span> <b class="caret"></b></a>
		<ul class="dropdown-menu">
<?php	
foreach($items as $key => $item) { 
	if($key==='logout'){
		?><li class="divider"></li><?php
	}
		echo $this->makeListItem($key, $item, array('class'=>'usermenu-'.$key));
} ?>
		</ul>
	</li>