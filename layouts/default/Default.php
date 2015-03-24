<?php

if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

$GLOBALS['wgAutoloadClasses']['BootyDefaultTemplate'] = __DIR__ . '/Template.php';


$GLOBALS['egBootyLayouts']['default'] = array(
	'modules' => array(),
	'templateClass' => 'BootyDefaultTemplate'
);
