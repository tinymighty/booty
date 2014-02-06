<?php

if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

$wgAutoloadClasses['BootyDefaultTemplate'] = __DIR__ . '/Template.php';

Booty::addLayout('default', array(
  'templateClass' => 'BootyDefaultTemplate',
  //'modules'       => $modules,
));


