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
$wgAutoloadClasses['BootyExtension'] =  $cd.'/Bootstrap.extension.php';

//the base skin, not intended for use as a skin! But great to build ontop of
$wgAutoloadClasses['SkinBooty'] = $cd . '/base/Skin.php';
$wgAutoloadClasses['BootyTemplate'] = $cd . '/base/Template.php';

//Hero skin, a sidebar-less skin with a jumbotron-sidebar combo - ideal for a big impact main page
$wgAutoloadClasses['BootySuperhero'] = $cd . '/variants/superhero/Superhero.php';

$wgExtensionMessagesFiles[ 'Booty' ] = $cd . '/Booty.i18n.php';


//$wgHooks['RequestContextCreateSkin'][] = "Boostrap::setSkin";
$wgExtensionFunctions[] = "Booty::tags";
//$wgHooks['BeforePageDisplay'][] = 'BootstrapSetup::registerResources';

//the base skin, not 
$wgValidSkinNames['booty'] = 'Booty';

class Booty{
	
	private function __construct(){}
	protected static $modules = array(
		'bootstrap'
	);
	protected static $defaults = array(
	   'template' => 'BootyTemplate',
	   'modules'  => array()
	);
	public static $options = array();

	protected static $_modulesRegistered = false;

	public static function init($options=array()){
		//pass options along to skinny
		Skinny::setOptions($options);
    self::setOptions($options);

    /*if(self::$options['template']!==self::$defaults['template']){
    	{{$options['template']}}::init();
    }*/

	  self::registerResources();
	}
	
	static function setOptions($options){
	  self::$options = array_merge( self::$defaults, self::$options, $options );
	}

	//allow variant templates to add modules
	static function addModules($modules){
		if( self::$_modulesRegistered ){
			throw new Exception('Too late too add new modules! Modules have already been registered.');
		}
		self::$options['modules'] += $modules;
	}

	static function tags(){
	  global $wgParser;
	  /*for($i=1; $i<=16; $i++){
		    $wgParser->setHook('span'.$i, array('BootstrapExtension','span'.$i));
		} 
    $wgParser->setHook('span-one-third', array('BootstrapExtension','span-one-third'));
    $wgParser->setHook('span-two-thirds', array('BootstrapExtension','span-two-thirds'));
    $wgParser->setHook('row', array('BootstrapExtension','row'));
    $wgParser->setHook('row-fluid', array('BootstrapExtension','row-fluid'));*/

   	$wgParser->setFunctionHook('herounit', array('BootstrapExtension', 'heroUnit'));
		return true;
	}

	static function registerResources(){
		self::$_modulesRegistered = true;

	  global $wgResourceModules, $wgStylePath;

		$resourceTemplate = array(
			'localBasePath' => __DIR__,
      'remoteBasePath' => $wgStylePath.'/'.basename(__DIR__),
			'group' => 'bootstrap'
		);
		
		$wgResourceModules += array(

			'bootstrap.css' => $resourceTemplate + array(
	      'styles' => array(
	      	'bootstrap-3.0.3/css/bootstrap.css'=>array('media'=>'screen')
	      ),
	      'position'=>'top'
			),

			'bootstrap.js' => $resourceTemplate + array(
					'dependencies'=>array('jquery'),
			    'scripts'=> array('bootstrap-3.0.3/js/bootstrap.js'),
			),
			
	    'font-awesome' => $resourceTemplate + array(
	    	'styles' => array(
	      	'font-awesome-4.0.3/css/font-awesome.css'=>array('media'=>'screen')
	      )
	    ),

      'skin.booty.css' => $resourceTemplate + array(
          'styles'=> array('base/css/layout.css'),
          'position' => 'top'
      ),
      'skin.booty.js' => $resourceTemplate + array(
          'scripts'=> array('base/js/init.js'),
          'position'=> 'bottom',
          'dependencies'=>array(
          	'bootstrap.js'
          )
      )

		);

		if(!empty(self::$options['modules'])){
			$wgResourceModules += self::$options['modules'];
		}

    return true;
	}

}
