<?php
/**
 * @todo document
 * @ingroup Skins
 */

class BootySuperheroTemplate extends BootyTemplate {

	protected $_hero_defaults = array(
		'show title'   => false,
		'show tagline' => false,
		'mediawiki sidebar' => false
	);

	public function __construct( $options=array() ){
		//merge in the default settings
		//echo '<pre>'; print_r($options); exit;
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

