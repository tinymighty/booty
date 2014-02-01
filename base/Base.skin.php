<?php
if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}


class SkinBootstrapBase extends SkinTemplate {
	public $skinname = 'bootstrap';
	public $stylename = 'bootstrap';
	public $template = 'BootstrapBaseTemplate';
	public $useHeadElement = true;

	public function __construct(){
		$this->template = Bootstrap::$options['template'];
	}


	public function initPage( OutputPage $out ) {

		parent::initPage( $out );

		$out->addModules( 'bootstrap.js' );
		$out->addModules( 'skin.bootstrap.js');

		$out->addModuleStyles( 'bootstrap.css' );
		$out->addModuleStyles( 'skin.bootstrap.css' );

		$out->addModuleStyles( 'font-awesome' );

		//load custom modules
		if(!empty(Bootstrap::$options['modules'])){
			foreach( array_keys(Bootstrap::$options['modules']) as $name){
				$out->addModules($name);
			}
		}

	}


}

