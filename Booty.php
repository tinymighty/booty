<?php
/**
 * Booty - A highly customizable MediaWiki theme built with Skinny and Bootstrap 3
 *
 * @Version 1.0.0
 * @Author Andru Vallance <andru@tinymighty.com>
 * @Copyright Andru Vallance, 2012
 * @License: GPLv2 (http://www.gnu.org/copyleft/gpl.html)
 */


$GLOBALS['wgExtensionCredits']['parserhook'][] = array(
	'name' => 'Booty',
	'author' => 'Andru Vallance',
	'description' => 'Booty is a modern mobile-first responsive MediaWiki theme built on Bootstrap 3. Designed primarily for ease of customisation to create new skins, but with an initial set of clean templates which can be used as-is.  Using [[Extension:Skinny]] allows defining skin variations and options on a per-page basis for awesome skin customisation.',
	'url' => 'https://github.com/andru/booty'
);
$cd = dirname(__FILE__);

$GLOBALS['wgAutoloadClasses']['Booty'] = $cd . '/Booty.class.php';
$GLOBALS['wgAutoloadClasses']['SkinBooty'] = $cd . '/base/Skin.php';
$GLOBALS['wgAutoloadClasses']['BootyTemplate'] = $cd . '/base/Template.php';

$GLOBALS['wgExtensionMessagesFiles'][ 'Booty' ] = $cd . '/Booty.i18n.php';

$GLOBALS['wgValidSkinNames']['booty'] = 'Booty';

//when installed via Composer, this file is loaded too early to access
//wgStylePath, so we delay init intil the SetupAfterCache hook
//by which MediaWiki is properly initialized
$GLOBALS['wgHooks']['SetupAfterCache'][] = function(){
	$cd = dirname(__FILE__);

	$GLOBALS['egBootyBasePath'] = __DIR__;
	$GLOBALS['egBootyBaseURL'] = $GLOBALS['wgStylePath'].'/'.basename(__DIR__);
	$GLOBALS['egBootyLayouts'] = array();


	//load skin variants
	require( $cd . '/layouts/default/Default.php' );
	require( $cd . '/layouts/superhero/Superhero.php' );

	Booty::init();

};