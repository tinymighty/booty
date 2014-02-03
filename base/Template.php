<?php
/**
 * @todo document
 * @ingroup Skins
 */
class BootyTemplate extends SkinnyTemplate {

	protected $_base_defaults = array(

		'content class'=>'',

		'shared sidebar'=>array(
			'enabled' => true,
			'position' => 'right'
		),

		'fancy toc'=>array(
			'enabled'=>true,
			'position'=>'shared sidebar'
		),

		'navbar'=>array(
			'enabled'=>true,
			'position'=>'top',
			'fixed'=>true
		),

		'search'=>array(
			'enabled'=>true,
			'position'=>'navbar-center'
		),

		'mediawiki sidebar'=>array(
			'enabled'=>true,
			'position'=>'shared sidebar'
		),

		'toolbox'=>array(
			'position'=>'page menu'
		),

		'user menu'=>array(
			'title' => 'username'
		)

	);

	//map content_navigation array keys to glyphicon names
	public $key_to_icon = array(
		've-edit'    => 'edit',
		'form_edit'  => 'edit',
		'edit'       => 'edit',
		'history'    => 'time',
		'delete'     => 'remove',
		'move'       => 'arrow-right',
		'protect'    => 'lock',
		'watch'      => 'eye-open',
		'viewsource' => 'align-justify',
		'purge'      => 'refresh',
		'main'       => 'file',
		'talk'       => 'comment'
	);

	protected $_template_paths = array();

	public function __construct( $options=array() ){
		$this->_defaults[] = $this->_base_defaults;

		parent::__construct( $options );

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
	}

	protected function addTemplatePath($path){
		array_unshift( $this->_template_paths, $path);
	}

	protected function initialize(){


		/* 
		In order to be highly configurable, this skin regularly renders a template to a zone,
		and then adds that zone to another zone.
		eg.

			$this->addTemplate('navbar-brand', 'navbar-brand'); //render the `navbar-brand.tpl.php` template to the `navbar-brand` zone
			$this->addZone('navbar', 'navbar-brand'); //append the content of the `navbar-brand` zone to the `navbar` zone

		This makes it easier to override standard content. If you swap out a template, you can choose
		to skip a main zone (eg. navbar) and instead specifically insert the zones you want (eg. navbar-brand, navbar-menu) 

		Incase you're looking at this skin as a Skinny reference, don't feel like you need to follow this pattern.
		Rendering a template directly to a zone (eg. this->addTemplate('navbar', 'navbar-brand')) is absolutely fine for most cases.

		This pattern of rendering to a specific zone and then appending that zone to another is a level of
		complexity only used in order to allow advanced customisation of this skin without having to create a sub-skin
		with custom templates.
		*/

		if($this->options['navbar']['enabled']){
			//add a top navigation bar
			$this->addTemplate('prepend:body', 'navbar');

			//the navbar toggler
			$this->addTemplate('navbar-toggler', 'navbar-toggler');
			//prepend it to the navbar zone
			$this->addZone('prepend:navbar', 'navbar-toggler');

			//the wiki name ("brand" in bootstrap lingo)
			$this->addTemplate('navbar-brand', 'navbar-brand');
			//add it to the navbar zone
			$this->addZone('navbar', 'navbar-brand');

			//process the MediaWiki:navbar message, which works more or less like MediaWiki:sidebar
			$items = $this->processNavigationFromMessage('navbar');
			if(count($items)){
				$this->addTemplate('navbar-menu', 'navbar-menu', array(
					'items'=>$items
				));
				//add it to the navbar zone
				$this->addZone('navbar', 'navbar-menu');
			}

			//render the navbar-right-menu.tpl.php template to the nav-bar-right-menu zone
			$this->addTemplate('navbar-right', 'navbar-right-menu');
			//append menus to the navbar-right-menu zone
			$this->addHook('navbar-right-menu', 'languageMenu');
			$this->addHook('navbar-right-menu', 'pageMenu');
			$this->addHook('navbar-right-menu', 'toolboxMenu');
			$this->addHook('navbar-right-menu', 'userMenu');
			//append the navbar-right-menu zone to the navbar zone
			$this->addZone('navbar', 'navbar-right');

			$this->addTemplate('navbar-search', 'navbar-search');

		}

		if($this->options['search']['enabled']){
			$this->addTemplate('search', 'navbar-search');
			if( $this->options['search']['position']==='navbar-center' ){
				$this->addTemplate('append:navbar', 'navbar-search');
			}
			else
			if( $this->options['search']['position']==='navbar-right' ){
				//$this->addTemplate('append:navbar', 'navbar-search');
			}
		}

		$this->addTemplate('inline-search', 'inline-search', array(
			'label'=>$this->getMsg('search')->plain(),
			'search_button_label' => $this->getMsg('searcharticle')->plain(),
			'fulltext_button_label'	=> $this->getMsg('searchbutton')->plain()
		));
		

		if($this->options['breadcrumbs']['enabled']){
			$this->addZone('prepend:title', 'breadcrumbs');
		}

		//allow for a full-width hero unit above the content
		$this->addHook('before:lower-container', 'hero');


		//add a shared sidebar
		if($this->options['shared sidebar']['enabled']){
			$this->addTemplate('append:content-container', 'shared-sidebar' );
		}

		//add the usual mediawiki sidebar contewnt
		if($this->options['mediawiki sidebar']['enabled']){

			if($this->options['mediawiki sidebar']['position']==='shared sidebar'){
				//append to the shared sidebar
				$this->addZone('append:shared-sidebar', 'classic-sidebar');
			}
			else
			if($this->options['mediawiki sidebar']['position']==='navbar'){
				//append the template to #content-container
				$this->addTemplate('append:navbar', 'sidebar-in-navbar', array(
					'sections'=>$this->data['sidebar']
				));
			}else{

			}

		}

		
		if($this->options['fancy toc']['enabled']){
			//add .has-toc class to #content-container if there is a toc on the page
			if(Skinny::hasContent('toc')){
				$this->addHTML('content-container.class', 'has-toc');
			}
			if($this->options['mediawiki sidebar']['position']==='shared sidebar'){
				$this->addZone('append:shared-sidebar', 'toc' );
			}else{
				$this->addTemplate('append:content-container', 'fancy-toc');
			}
		}


	}

	protected function hero(){
		$content = '';
		//Skinny can be used to content from the article into the 
		if( class_exists('Skinny') && Skinny::hasContent('hero') ){
			$content = Skinny::getContent('hero');
			return $this->renderTemplate('hero');
		}
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

	protected function pageMenu(){
		return $this->renderTemplate('page-menu', array(
			'title'=>$this->getMsg( 'actions' )->plain(),
			'namespaces'=>$this->data['content_navigation']['namespaces'],
			'views'=>$this->data['content_navigation']['views'],
			'actions'=>$this->data['content_navigation']['actions'],
			'variants'=>$this->data['content_navigation']['variants']
		));
	}

	protected function userMenu(){
		$user = $this->getSkin()->getUser();
		if($this->options['user menu']['title']==='username'){
			if($user->isLoggedIn()){
				$title = $user->getName();
			}else{
				//ideally this should display 'account' or something, but for now we'll leave it as the default
				$title = $this->getMsg('personaltools')->plain();
			}
			
		}else{
			$title = $this->getMsg('personaltools')->plain();
		}
		return $this->renderTemplate('user-menu', array(
			'items' => $this->data['personal_urls'],
			'title' => $title 
		));
	}

	protected function toolboxMenu(){
		return $this->renderTemplate('toolbox-menu', array(
			'items' => $this->getToolbox(),
			'title' => $this->getMsg('toolbox')->plain()
		)); 
	}

	/* Override SkinTemplate::makeListItem in order to inject icons */
	/*public function makeListItem( $key, $attributes, $options=array() ){
		if( isset($options['icon-class']) ){
			$class_name = $options['icon-class'];
			unset( $options['icon-class'] );
			$options['text-wrapper'] = array('tag' => 'span');
			$item = parent::makeListItem($key, $attributes, $options);
			//echo 'WOAH'.$item.'WOAH';
			$item = str_replace('<span', '<i class="'.$class_name.'"></i> <span', $item);
			return $item;
		}else{
			return parent::makeListItem($key, $attributes, $options);
		}
	}*/


	/*************************************************************************************************/

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

} // end of class

