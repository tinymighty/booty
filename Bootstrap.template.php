<?php
/**
 * @todo document
 * @ingroup Skins
 */
class BootstrapTemplate extends BaseTemplate {

	private $settings = array(
		'layout'=>'fluid',
		'show-sidebar-logo'=>true,

		'contentClass'=>''
	);

	public $options = array();


	/**
	 * Template filter callback for MonoBook skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	function execute() {
		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

		$this->data['pageLanguage'] = $this->getSkin()->getTitle()->getPageViewLanguage()->getCode();

		$options = array_merge($this->settings, $this->options);

		$this->html( 'headelement' );
		//$this->navbar();
		$this->masthead($options);
		?>
		<div id="lower-container" class="">
		<?php $this->leftColumn($options); ?>
			<div id="content-container">
				<div class="container-fluid">
				<?php
				$this->content($options);
				?>
				</div>
			</div><!--/content-container-->
		<?php $this->rightColumn($options); ?>
		</div>
		<?php
		$this->footer($this->getFooterIcons( "icononly" ), $this->getFooterLinks( "flat" ));

		$this->printTrail();
		echo Html::closeElement( 'body' );
		echo Html::closeElement( 'html' );
		wfRestoreWarnings();
	}

	protected function navbar(){
?>
<div class="navbar navbar-fixed-top" id="sitemast">
  <div class="navbar-inner">
    <div class="container-fluid">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="brand" href="#" lang="<?php	$this->html( 'pageLanguage' );?>"><?php $this->html('sitename') ?></a>
      <p id="site-tagline"><?php $this->msg('tagline') ?></p>
      <div class="nav-collapse collapse">
        <p class="navbar-text pull-right">
          Logged in as <a href="#" class="navbar-link">Username</a>
        </p>
        <ul class="nav">
          <li class="active"><a href="/wiki">Wiki</a></li>
					<li><a href="#">Community</a></li>
					<li><a href="#">Blog</a></li>
					<li><a href="#">Bookshop</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>
<?php
	}//end header()

	protected function masthead(){

	}

	protected function leftColumn($opts){
		$this->sidebar($options);
	}

	protected function rightColumn($opts){

	}

	protected function beforeContent($opts){

	}
	protected function afterContent($opts){

	}

	protected function content($opts){	
		$this->beforeContent($opts);
		?>

<article id="content" class="mw-body-primary <?php echo $opts['contentClass']?>" role="main">
	<?php $this->cactions(); ?>
	<a id="top"></a>
	<?php if($this->data['sitenotice']) { ?><div id="siteNotice"><?php $this->html('sitenotice') ?></div><?php } ?>

	<h1 id="firstHeading" class="firstHeading" ><span dir="auto"><?php $this->html('title') ?></span></h1>
	<div id="bodyContent" class="mw-body">
		<div id="siteSub"><?php $this->msg('tagline') ?></div>
		<div id="contentSub"<?php $this->html('userlangattributes') ?>><?php $this->html('subtitle') ?></div>
<?php if($this->data['undelete']) { ?>
		<div id="contentSub2"><?php $this->html('undelete') ?></div>
<?php } ?><?php if($this->data['newtalk'] ) { ?>
		<div class="usermessage"><?php $this->html('newtalk')  ?></div>
<?php } ?><?php if($this->data['showjumplinks']) { ?>
		<div id="jump-to-nav" class="mw-jump"><?php $this->msg('jumpto') ?> <a href="#column-one"><?php $this->msg('jumptonavigation') ?></a><?php $this->msg( 'comma-separator' ) ?><a href="#searchInput"><?php $this->msg('jumptosearch') ?></a></div>
<?php } ?>
		<!-- start content -->
<?php $this->html('bodytext') ?>
		<?php if($this->data['catlinks']) { $this->html('catlinks'); } ?>
		<!-- end content -->
		<?php if($this->data['dataAfterContent']) { $this->html ('dataAfterContent'); } ?>
		<div class="visualClear"></div>
	</div>
</article>

<?php 
		$this->afterContent($opts);
	}//end content()

	protected function sidebar($options){ ?>
<nav id="sidebar"<?php $this->html('userlangattributes')  ?> class="sidebar-nav well">

<?php if($options['show-sidebar-logo']): ?>
	<div id="sidebar-logo" role="banner"><a href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ) ?>" <?php echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( 'p-logo' ) ) ?>><img src="<?php $this->text( 'logopath' ) ?>"></a></div>
<?php endif; ?>

<?php
	$this->renderPortals( $this->data['sidebar'] );
?>
</nav>
<?php } //end sidebar() 


	protected function advert(){ ?>
<aside id="vertical-banner">

</aside>
<?php 
	}// end advert() 

	protected function footer($icons, $links){ ?>



<footer id="footer" role="contentinfo"<?php $this->html('userlangattributes') ?>>
<?php	foreach ( $icons as $blockName => $footerIcons ) { ?>
	<div id="f-<?php echo htmlspecialchars($blockName); ?>ico">
<?php foreach ( $footerIcons as $icon ) { ?>
		<?php echo $this->getSkin()->makeFooterIcon( $icon ); ?>

<?php }
?>
	</div>
<?php }

		if ( count( $links ) > 0 ) {
?>	<ul id="f-list" class="unstyled">
<?php
			foreach( $links as $aLink ) { ?>
		<li id="<?php echo $aLink ?>"><?php $this->html($aLink) ?></li>
<?php
			}
?>
	</ul>
<?php	}
echo $footerEnd;
?>
</footer>
	 <?php } //end footer() 

		

	/*************************************************************************************************/

	/**
	 * @param $sidebar array
	 */
	protected function renderPortals( $sidebar ) {
		if ( !isset( $sidebar['SEARCH'] ) ) $sidebar['SEARCH'] = true;
		if ( !isset( $sidebar['TOOLBOX'] ) ) $sidebar['TOOLBOX'] = true;
		if ( !isset( $sidebar['LANGUAGES'] ) ) $sidebar['LANGUAGES'] = true;

		foreach( $sidebar as $boxName => $content ) {
			if ( $content === false )
				continue;

			if ( $boxName == 'SEARCH' ) {
				$this->searchBox();
			} elseif ( $boxName == 'TOOLBOX' ) {
				$this->toolbox();
			} elseif ( $boxName == 'LANGUAGES' ) {
				$this->languageBox();
			} else {
				$this->customBox( $boxName, $content );
			}
		}
	}

	function searchBox(){
		?>
		<ul class="nav nav-list">
		<li class="nav-header"><?php $this->msg('search') ?></li>
		<li><?php $this->searchForm() ?></li>
	</ul>
		<?php
	}

	function searchForm() {
		global $wgUseTwoButtonsSearchForm;
?>
			<form action="<?php $this->text('wgScript') ?>" id="searchform" method="get">
				<input type='hidden' name="title" value="<?php $this->text('searchtitle') ?>"/>

				<div class="input-append">
				  <input class="" id="searchInput" size="16" type="text" name="search">
				  <button class="btn searchButton" id="searchGoButton" type="submit"><i class="icon icon-circle-arrow-right" rel="tooltip" title="<?php $this->msg('searcharticle') ?>"></i> </button>
					<?php if ($wgUseTwoButtonsSearchForm): ?>
				  	<button class="btn searchButton" type="submit" id="mw-searchButton" name="search" value="fulltext"><i class="icon icon-search" rel="tooltip" title="<?php $this->msg('searchbutton')?>"></i> </button>
					<?php	endif; ?>
				</div>

			</form>
<?php
	}

	/**
	 * Prints the cactions bar.
	 * Shared between MonoBook and Modern
	 */
	function cactions() {
?>
	<div id="content-actions">
			<div class="btn-group caction-button" data-toggle="buttons-checkbox">
	<?php 

	$cactions = $this->data['content_actions'];
	$nstab = array_shift($cactions);
	if($cactions['talk']):
		?>
	  <a href="<?php echo $nstab['href']; ?>" class="btn btn-small <?php echo str_replace('selected', 'active', $nstab['class']);?>">
	  	<i class="icon icon-file"></i> <?php echo $nstab['text']?></a>
	  <a href="<?php echo $cactions['talk']['href']; ?>" class="btn btn-small <?php echo str_replace('selected', 'active', $cactions['talk']['class']);?>">
	  	<i class="icon icon-comment"></i> <?php echo $cactions['talk']['text']?></a>
	<?php elseif ($cactions['nstab_main'] ): ?>

	<?php endif; 

	unset($cactions['talk']);
	$key_to_icon = array(
		'edit'=> 'edit',
		'history'=> 'time',
		'delete'=> 'remove',
		'move'=> 'arrow-right',
		'protect'=> 'lock',
		'watch'=> 'eye-open',
		'viewsource'=> 'align-justify'
	);
	?>
	  </div><!-- end button group-->

  <div class="caction-button dropdown pull-right" >
  	<button class="btn btn-small" data-toggle="dropdown" title="<?php $this->msg('personaltools') ?>">
  		<i class="icon icon-user"></i> <b class="caret"></b>
  	</button>
		<ul class="dropdown-menu">
<?php		foreach($this->getPersonalTools() as $key => $item) { ?>
				<?php echo $this->makeListItem($key, $item); ?>
<?php		} ?>
		</ul>
	</div>

	<div class="caction-button dropdown pull-right">
  <button class="btn btn-small dropdown-toggle" data-toggle="dropdown" title="<?php $this->msg('actions') ?>">
  	<i class="icon icon-cog"></i>  <b class="caret"></b>
  </button>

  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
    	<?php
				foreach($cactions as $key => $tab):?>
				<li><a href="<?php echo $tab['href'] ?>" class="<?php echo str_replace('selected', 'active', $cactions['talk']['class']);?>" id="contentaction-<?php echo $key?>">
					<i class="icon icon-<?php echo $key_to_icon[$key]?>"></i> <?php echo $tab['text'] ?>
				</a></li>
			<?php endforeach; ?>
  </ul>
  </div>


</div><!--end of content-actions-->
<?php
	}
	/*************************************************************************************************/
	function toolbox() {
?>
	<div class="portlet" id="p-tb" role="navigation">
		<ul class="nav nav-list">
		<li class="nav-header"><?php $this->msg('toolbox') ?></li>

<?php
		foreach ( $this->getToolbox() as $key => $tbitem ) { ?>
				<?php echo $this->makeListItem($key, $tbitem); ?>

<?php
		}
		wfRunHooks( 'MonoBookTemplateToolboxEnd', array( &$this ) );
		wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this, true ) );
?>
		</ul>
	</div>
<?php
	}

	/*************************************************************************************************/
	function languageBox() {
		if( $this->data['language_urls'] ) {
?>
	<div id="p-lang" class="portlet" role="navigation">
		<ul class="nav nav-list">
		<li class="nav-header"><?php $this->html('userlangattributes') ?>><?php $this->msg('otherlanguages') ?></li>
<?php		foreach($this->data['language_urls'] as $key => $langlink) { ?>
				<?php echo $this->makeListItem($key, $langlink); ?>

<?php		} ?>
		</ul>
	</div>
<?php
		}
	}

	/*************************************************************************************************/
	/**
	 * @param $bar string
	 * @param $cont array|string
	 */
	function customBox( $bar, $cont ) {
		$portletAttribs = array( 'class' => 'generated-sidebar portlet', 'id' => Sanitizer::escapeId( "p-$bar" ), 'role' => 'navigation' );
		$tooltip = Linker::titleAttrib( "p-$bar" );
		if ( $tooltip !== false ) {
			$portletAttribs['title'] = $tooltip;
		}
		echo '	' . Html::openElement( 'div', $portletAttribs );
?>
		<ul class="nav nav-list">
		<li class="nav-header"><?php $msg = wfMessage( $bar ); echo htmlspecialchars( $msg->exists() ? $msg->text() : $bar ); ?></li>
<?php   if ( is_array( $cont ) ) { ?>
<?php 			foreach($cont as $key => $val) { ?>
				<?php echo $this->makeListItem($key, $val); ?>

<?php			} ?>
<?php   } else {
			# allow raw HTML block to be defined by extensions
			print '<li>'.$cont.'</li>';
		}
?>
		</ul>
	</div>
<?php
	}
} // end of class

