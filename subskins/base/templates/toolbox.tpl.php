<div class="related-nav-section">
	<h4><?php echo $header ?></h4>
	<ul class="nav">
		<?php foreach($items as $key => $item): ?>
			<?php echo $this->makeListItem($key, $item); ?>
		<?php endforeach; ?>
	</ul>
</div>