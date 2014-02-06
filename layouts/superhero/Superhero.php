<?php

if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

$wgAutoloadClasses['BootySuperheroTemplate'] = __DIR__ . '/Template.php';

//$wgValidSkinNames['folgerpedia'] = 'Folgerpedia';

$tpl = array(
	'remoteBasePath' => $GLOBALS['wgStylePath'].'/'.basename(__DIR__),
  'localBasePath' => __DIR__
);

$modules = array();

$modules['skins.booty.superhero'] = $tpl + array(
  'styles' => array(
    'css/layout.css'
  ),
  'position'=>'top'
);

$modules['skins.booty.superhero.js'] = $tpl + array(
  'scripts'=>array(
  	'js/init.js'
  )
);

class BootySuperhero{
  public static function init(){
    Booty::addModules($modules);
  }
}

