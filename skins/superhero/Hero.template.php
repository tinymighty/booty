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

	public function __construct(){
		parent::__construct();
		$this->addTemplatePath( dirname(__FILE__).'/templates' );
	}
	protected function initialize(){
		//add it before the parent initialize, so it appears before the standard hero
		$this->add('before:lower-container', array('superhero', $this));

		parent::initialize();
	}

	protected function superhero(){
		$content = '';
		//Skinny can be used to content from the article into the 
		if( class_exists(Skinny) && Skinny::hasContent('superhero') ){
			$content = Skinny::getContent('superhero');
			return $this->renderTemplate('superhero', array(
				'content'=> $content
			));
		}
	}
} // end of class

