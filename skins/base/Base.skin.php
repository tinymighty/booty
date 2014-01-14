<?php
if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}


class SkinBootstrapBase extends SkinTemplate {
	public $skinname = 'bootstrap';
	public $stylename = 'bootstrap';
	public $template = 'BootstrapHeroTemplate';
	public $useHeadElement = true;


	public function initPage( OutputPage $out ) {

		parent::initPage( $out );

		$out->addModules( 'bootstrap.js' );
		$out->addModules( 'skin.bootstrap.js');

		$out->addModuleStyles( 'bootstrap.css' );
		$out->addModuleStyles( 'skin.bootstrap.css' );

	}



}

