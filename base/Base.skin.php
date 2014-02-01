<?php
if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}


class SkinBooty extends SkinTemplate {
	public $skinname = 'bootstrap';
	public $stylename = 'bootstrap';
	public $template = 'BootyTemplate';
	public $useHeadElement = true;

	public function __construct(){
		$this->template = Booty::$options['template'];
	}


	public function initPage( OutputPage $out ) {

		parent::initPage( $out );

		$out->addModules( 'bootstrap.js' );
		$out->addModules( 'skin.booty.js');

		$out->addModuleStyles( 'bootstrap.css' );
		$out->addModuleStyles( 'skin.booty.css' );

		$out->addModuleStyles( 'font-awesome' );

		//load custom modules
		if(!empty(Booty::$options['modules'])){
			foreach( array_keys(Booty::$options['modules']) as $name){
				$out->addModules($name);
			}
		}

	}


}

