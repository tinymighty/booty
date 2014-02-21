<?php

if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

$wgAutoloadClasses['BootyDefaultTemplate'] = __DIR__ . '/Template.php';


$egBootyLayouts['default'] = array(
	'modules' => array(),
	'templateClass' => 'BootyDefaultTemplate'
);
