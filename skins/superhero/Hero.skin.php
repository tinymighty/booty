<?php

if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

class SkinBootstrapHero extends SkinBootstrapBase {
	public $skinname = 'bootstrap';
	public $stylename = 'bootstrap';
	public $template = 'BootstrapHeroTemplate';
	public $useHeadElement = true;

	public function __construct(){
		if( isset(Bootstrap::$options['layout']) ){
			$this->template = Bootstrap::$options['layout'];
		}
		//parent::__construct();
	}
	/**
	 * Initializes output page and sets up skin-specific parameters
	 * @param $out OutputPage object to initialize
	 */
	public function initPage( OutputPage $out ) {

		parent::initPage( $out );

		$out->addModuleStyles( 'skin.bootstrap.hero' );
	}



}

