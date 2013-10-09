<?php
/**
 *
 * @file
 * @ingroup Skins
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}


/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @ingroup Skins
 */
class BootstrapSkin extends SkinTemplate {
	var $skinname = 'bootstrap', $stylename = 'bootstrap',
		$template = 'BootstrapTemplate', $useHeadElement = true;


	/**
	 * Initializes output page and sets up skin-specific parameters
	 * @param $out OutputPage object to initialize
	 */
	public function initPage( OutputPage $out ) {
		global $wgLocalStylePath;

		parent::initPage( $out );

		// Append CSS which includes IE only behavior fixes for hover support -
		// this is better than including this in a CSS fille since it doesn't
		// wait for the CSS file to load before fetching the HTC file.
		/*$min = $this->getRequest()->getFuzzyBool( 'debug' ) ? '' : '.min';
		$out->addHeadItem( 'csshover',
			'<!--[if lt IE 7]><style type="text/css">body{behavior:url("' .
				htmlspecialchars( $wgLocalStylePath ) .
				"/{$this->stylename}/csshover{$min}.htc\")}</style><![endif]-->"
		);*/

		//$out->addModules( 'bootstrap.css' );
		//$out->addModules( 'skin.bootstrap' );
		$out->addModules( 'bootstrap.dropdown');
		$out->addModules( 'skin.bootstrap.js');
	}

	/**
	 * Load skin and user CSS files in the correct order
	 * fixes bug 22916
	 * @param $out OutputPage object
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		//first add the general bootstrap css
		$out->addModuleStyles( 'bootstrap.css' );
		$out->addModuleStyles( 'bootstrap.responsive' );
		//then the css specific to this skin
		$out->addModuleStyles( 'skin.bootstrap.css' );

	}


}

