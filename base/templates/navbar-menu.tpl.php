<?php $this->before('mediawiki-sidebar') ?>
		<nav class="navbar-menu navbar-links collapse <?php $this->insert('sidebar-in-navbar.class') ?>">
			<ul class="nav navbar-nav">
		<?php 
		$this->prepend('mediawiki-sidebar');

		foreach($items as $name => $items): 
			//show items without a header as first-level navigation
			if(empty($name)):	
				foreach($items as $key => $item): ?>
			<li class="">
				<a class="" data-toggle="" href="<?php echo $item['href'] ?>">
					<?php /*<i class="glyphicon glyphicon-cog"></i> */ ?>
					<span class="title"><?php echo $item['text'] ?></span>
				</a>
			</li>
		<?php endforeach; ?>
<?php
			//show items with a header as dropdown menus
			else: 
				?> 


			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown">
					<?php /*<i class="glyphicon glyphicon-cog"></i> */ ?>
					<span class="title"><?php $this->msg($name) ?></span>
					<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
				<?php foreach($items as $key => $item): ?>
				<?php echo $this->makeListItem($key, $item); ?>
				<?php endforeach; ?>
				</ul>
			</li>
<?php
			endif;
		endforeach;
		$this->append('mediawiki-sidebar');
		?>
		</nav>
<?php $this->after('mediawiki-sidebar') ?>
