<?php

if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

$GLOBALS['wgAutoloadClasses']['BootySuperheroTemplate'] = __DIR__ . '/Template.php';

//ValidSkinNames['folgerpedia'] = 'Folgerpedia';

$tpl = array(
	'remoteBasePath' => $GLOBALS['egBootyBaseURL'].'/layouts/'.basename(__DIR__),
  'localBasePath' => __DIR__
);

$modules = array();

$modules['skins.booty.superhero'] = $tpl + array(
  'styles' => array(
    'css/hero.css'
  ),
  'position'=>'top'
);

$modules['skins.booty.superhero.js'] = $tpl + array(
  'scripts'=>array(
  	'js/init.js'
  )
);

$GLOBALS['egBootyLayouts']['superhero'] = array(
  'templateClass' =>'BootySuperheroTemplate',
  'modules'       =>$modules,
);