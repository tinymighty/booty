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

	protected $_hero_defaults = array(
		'show title'=> false
	);
	protected $defaults = array();
	public $options = array();

	public function __construct( $options=array() ){
		//merge in the default settings
		$this->setDefaults( $this->_hero_defaults );

		parent::__construct( $options );

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

