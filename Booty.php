<?php
/**
 * Booty - A highly customizable MediaWiki theme built with Skinny and Bootstrap 3
 *
 * @Version 1.0.0
 * @Author Andru Vallance <andru@tinymighty.com>
 * @Copyright Andru Vallance, 2012
 * @License: GPLv2 (http://www.gnu.org/copyleft/gpl.html)
 */


$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Booty',
	'author' => 'Andru Vallance',
	'description' => 'Booty is a modern mobile-first responsive MediaWiki theme built on Bootstrap 3. Designed primarily for ease of customisation to create new skins, but with an initial set of clean templates which can be used as-is.  Using [[Extension:Skinny]] allows defining skin variations and options on a per-page basis for awesome skin customisation.',
	'url' => 'https://github.com/andru/booty'
);
$cd = dirname(__FILE__);
//$wgAutoloadClasses['BootyExtension'] =  $cd.'/Bootstrap.extension.php';

$wgAutoloadClasses['Booty'] = $cd . '/Booty.class.php';
$wgAutoloadClasses['SkinBooty'] = $cd . '/base/Skin.php';
$wgAutoloadClasses['BootyTemplate'] = $cd . '/base/Template.php';

$wgExtensionMessagesFiles[ 'Booty' ] = $cd . '/Booty.i18n.php';

$wgValidSkinNames['booty'] = 'Booty';

Booty::init();

//load skin variants
require( $cd . '/layouts/default/Default.php' );
require( $cd . '/layouts/superhero/Superhero.php' );

