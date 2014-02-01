<?php 
//basic language dropdown - to support a small subset of mediawiki localizations
//this takes priority over the full ULS selector (set the languages option to enable it)
if( $languages ): ?>
	<li class="language-menu dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-comment"></i> <?php echo $active['name'] ?>  <b class="caret"></b></a>
		<ul class="dropdown-menu">
	<?php foreach($languages as $code => $name): ?>
			<li lang="<?php echo $code ?>" dir="ltr" data-code="<?php echo $code ?>"><a href="?setlang=<?php echo $code ?>"><?php echo $name ?></a></li>
	<?php endforeach; ?>
		</ul>
	</li>
<?php 

//Universal language selector menu - to support ALL mediawiki localizations
elseif( $uls ): ?>
	<li><a href="#" class="<?php echo $uls['class'] ?>"><i class="glyphicon glyphicon-language"></i> <?php echo $uls['text'] ?></a></li>

<?php endif; ?>

