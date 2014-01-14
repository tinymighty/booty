<?php
/**
 * @todo document
 * @ingroup Skins
 */
class BootstrapBaseTemplate extends SkinnyTemplate {

	protected $settings = array(
		'layout'=>'fluid',
		'show-sidebar-logo'=>true,

		'contentClass'=>'',

		'enable navbar'=>true,
		'use navbar search'=>true,

		'enable related navigation'=>true,
		'enable secondary search'=>false,

		'enable fancy toc'=>true,
	);

	public $options = array();

	//map content_navigation array keys to glyphicon names
	public $key_to_icon = array(
		'form_edit'=> 'edit',
		'edit'=> 'edit',
		'history'=> 'time',
		'delete'=> 'remove',
		'move'=> 'arrow-right',
		'protect'=> 'lock',
		'watch'=> 'eye-open',
		'viewsource'=> 'align-justify',
		'purge' => 'refresh',
		'main' => 'file',
		'talk' => 'comment'
	);

	protected $_template_paths = array();

	public function __construct(){
		
		parent::__construct(false);

		$this->addTemplatePath( dirname(__FILE__).'/templates' );

		if(isset($this->options['languages'])){
			$names = Language::getLanguageNames(); 
			$languages = array();
			foreach($this->options['languages'] as $code){
				if(array_key_exists($code, $names)){
					$languages[$code] = $names[$code];
				}
			}
			$this->data['languages'] = $languages;
			$context = RequestContext::getMain();
			$active = $context->getLanguage();
			$this->data['active_language'] = array(
				'name'=>$active->fetchLanguageName( $active->getCode() ),
				'code'=>$active->getCode() 
			);
		}

		$this->initialize();
	}

	protected function addTemplatePath($path){
		array_unshift( $this->_template_paths, $path);
	}

	protected function initialize(){
		//site notice
		$this->add('notice', array('notice', $this));
		//head element (including opening body tag)
		$this->add('head', array('headElement', $this));
		if($this->options['enable navbar']){
			//add a top navigation bar
			$this->add('prepend:body', array('primaryNavigation', $this));
		}

		$this->add('primary nav menus', array('languageMenu', $this));
		$this->add('primary nav menus', array('contentActionsMenu', $this));
		$this->add('primary nav menus', array('userMenu', $this));

		//allow for a full-width hero unit above the content
		$this->add('before:lower-container', array('hero', $this));

		//add the usual mediawiki sidebar as a righthand sidebar
		if($this->options['enable related navigation']){
			$this->add('content-container-class', 'has-related');
			$this->add('append:content-container', array('relatedNav', $this));
		}

		if($this->options['enable fancy toc']){
			$this->add('content-container-class', 'has-toc');
		}

		//the article title 
		$this->add('title', array('title', $this));
		//article content
		$this->add('content', array('content', $this));
		//page footer
		$this->add('footer', array('footer', $this));
		//mediawiki needs this to inject script tags after the footer
		$this->add('after:footer', array('afterFooter', $this));
	}



	protected function siteNotice(){
		return $this->renderTemplate('sitenotice');
	}


	protected function title(){
		return $this->renderTemplate('article-title', array(
				'title'=>$this->data['title']
			)
		);
	}

	protected function tagline(){
		return $this->renderTemplate('tagline', array(
				'tagline'=>wfMsg('tagline')
			)
		);
	}

	protected function content(){
		return $this->renderTemplate('content', array(
				'content_html'=>$this->data['bodytext']
			)
		);
	}

	protected function hero(){
		$content = '';
		//Skinny can be used to content from the article into the 
		if( class_exists(Skinny) && Skinny::hasContent('hero') ){
			$content = Skinny::getContent('hero');
			return $this->renderTemplate('hero');
		}
	}

	protected function notice(){
		if( isset($this->data['sitenotice']) ){
			return $this->renderTemplate('notice', array(
					'notice'=>$this->data['sitenotice']
				)
			);
		}
	}

	protected function primaryNavigation(){
		return $this->renderTemplate('primary-navigation');
	}

	protected function relatedNav(){
		$sections = $this->data['sidebar'];
		if(!$this->options['enable secondary search']){
			unset($sections['SEARCH']);
		}
		
		return $this->renderTemplate('related-nav', array(
			'sections'=>$sections
			)
		);
	}

	protected function footer(){ 
		return $this->renderTemplate('footer', array(
			'icons'=>$this->getFooterIcons( "icononly" ), 
			'links'=>$this->getFooterLinks( "flat" )
			)
		);
	} 

	protected function afterFooter(){
		ob_start();
		$this->printTrail();
		return ob_get_clean();
	}

	function inlineSearchElements(){
		global $wgUseTwoButtonsSearchForm;
		return $this->renderTemplate('inline-search-elements', array(
			'two_button_search' => $wgUseTwoButtonsSearchForm,
			'label'=>wfMsg('search'),
			'search_button_label' => wfMsg('searcharticle'),
			'fulltext_button_label'	=> wfMsg('searchbutton')
		));
	}

	function inlineSearchForm(){
		return $this->renderTemplate('inline-search-form', array(

		));
	}


	/**
	 * Primary Navigation menus...
	 */

	protected function languageMenu(){
		$languages =  isset( $this->data['languages'] ) ?  $this->data['languages'] : false;
		$uls = isset( $this->data['uls'] ) ? $this->data['uls'] : false;
		if($uls || $languages){
			return $this->renderTemplate('language-selection', array(
				'languages' => $languages,
				'active' => $this->data['active_language'],
				'uls' => $uls
			));
		}
		return '';
	}

	protected function contentActionsMenu(){
		return $this->renderTemplate('contentactions-menu', array(
			'namespaces'=>$this->data['content_navigation']['namespaces'],
			'views'=>$this->data['content_navigation']['views'],
			'actions'=>$this->data['content_navigation']['actions'],
			'variants'=>$this->data['content_navigation']['variants']
		));
	}

	protected function userMenu(){
		return $this->renderTemplate('user-menu', array(
			'items' => $this->data['personal_urls'],
			'label' => wfMsg('personaltools') 
		));
	}



		

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



	/* A hacky way to move to Universal Language Selector out of the personal_urls
	as soon as it's added... */
	public function set($prop, $val){
		parent::set($prop, $val);

		//if Universal Language Selector is installed
		//pull it out of the user menu
		if($prop === 'personal_urls'){
			if( isset($this->data['personal_urls']['uls']) ){
				$this->data['uls'] = $this->data['personal_urls']['uls'];
				unset($this->data['personal_urls']['uls']);
			}
		}
	}




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

