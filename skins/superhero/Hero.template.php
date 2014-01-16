<?php
/**
 * @todo document
 * @ingroup Skins
 */
$wgResourceModules['skins.basabali'] = array(
        'styles' => array(
                'Basabali/main.css' => array( 'media' => 'screen' ),
        ),
        'remoteBasePath' => &$GLOBALS['wgStylePath'],
        'localBasePath' => &$GLOBALS['wgStyleDirectory']
);

class BootstrapHeroTemplate extends BootstrapBaseTemplate {

	public $_hero_settings = array(
		'show title'=>false
	);

	public function __construct(){
		//merge in the default settings
		$this->settings = array_merge($this->settings, $this->_hero_settings);
		parent::__construct();
		$this->addTemplatePath( dirname(__FILE__).'/templates' );
	}
	protected function initialize(){
		//add it before the parent initialize, so it appears before the standard hero
		$this->addHook('before:lower-container', 'superhero');
		$this->addHTML('navbar.class', 'transparent superhero');
		parent::initialize();
	}

	protected function superhero(){
		$content = '';
		//Skinny can be used to content from the article into the 
		if( class_exists('Skinny') && Skinny::hasContent('superhero') ){
			$content = Skinny::getContent('superhero');
			return $this->renderTemplate('superhero', array(
				'content'=> $content
			));
		}
	}
} // end of class

