<footer id="main-footer" role="contentinfo"<?php $this->html('userlangattributes') ?>>
<div class="container">
	<div class="mediawiki-info">

	</div>
<?php	foreach ( $icons as $blockName => $footerIcons ) { ?>
	<div id="f-<?php echo htmlspecialchars($blockName); ?>ico">
<?php foreach ( $footerIcons as $icon ) { ?>
		<?php echo $this->getSkin()->makeFooterIcon( $icon ); ?>
<?php }
?>
	</div>
<?php }

		if ( count( $links ) > 0 ):
?>	<ul id="links">
<?php
			foreach( $links as $aLink ) { ?>
		<li id="<?php echo $aLink ?>"><?php $this->html($aLink) ?></li>
<?php
			}
?>

	</ul>
<?php endif; ?>
</div>
</footer>