<?php
/**
 * Bootstrap - A MediaWiki extension to integrate Twitter Bootstrap 
 *
 * @Version 1.0.0
 * @Author Andru Vallance <andru@tinymighty.com>
 * @Copyright Andru Vallance, 2012
 * @License: GPLv2 (http://www.gnu.org/copyleft/gpl.html)
 */


$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Bootstrap',
	'author' => 'Andru Vallance',
	'description' => 'A Bootstrap 3 skin for MediaWiki. Multiple templates to choose from, so ideal for use 
	with the Skinny extension. It makes a great base for a custom skin project, providing easy subskinning 
	with a much saner templating system than the standard MediaWiki one-huge-file method.',
	'url' => 'https://github.com/andru/mediawiki-bootstrap'
);
$cd = dirname(__FILE__);
$wgAutoloadClasses['BootstrapExtension'] =  $cd.'/Bootstrap.extension.php';

//the base skin, not intended for use as a skin! But great to build ontop of
$wgAutoloadClasses['SkinBootstrapBase'] = $cd . '/skins/base/Base.skin.php';
$wgAutoloadClasses['BootstrapBaseTemplate'] = $cd . '/skins/base/Base.template.php';

//Hero skin, a sidebar-less skin with a jumbotron-sidebar combo - ideal for a big impact main page
$wgAutoloadClasses['SkinBootstrapHero'] = $cd . '/skins/superhero/Hero.skin.php';
$wgAutoloadClasses['BootstrapHeroTemplate'] = $cd . '/skins/superhero/Hero.template.php';

$wgExtensionMessagesFiles[ 'Bootstrap' ] = $cd . '/Bootstrap.i18n.php';


//$wgHooks['RequestContextCreateSkin'][] = "Boostrap::setSkin";
$wgExtensionFunctions[] = "Bootstrap::tags";
//$wgHooks['BeforePageDisplay'][] = 'BootstrapSetup::registerResources';

//the base skin, not 
$wgValidSkinNames['bootstrap'] = 'BootstrapBase';
$wgValidSkinNames['bootstrap-superhero'] = 'BootstrapHero';

class Bootstrap{
	
	private function __construct(){}
	protected static $modules = array(
		'bootstrap'
	);
	protected static $settings = array(
	   'skin'=>'Bootstrap'
	);
	public static $options = array();
	
	public static function init($options=array()){
      self::setOptions($options);
	    self::registerResources();
	}
	
	static function setOptions($options){
	    self::$options = array_merge(self::$settings,$options);
	}

	static function tags(){
	    global $wgParser;
	    for($i=1; $i<=16; $i++){
		    $wgParser->setHook('span'.$i, array('BootstrapExtension','span'.$i));
		} 
    $wgParser->setHook('span-one-third', array('BootstrapExtension','span-one-third'));
    $wgParser->setHook('span-two-thirds', array('BootstrapExtension','span-two-thirds'));
    $wgParser->setHook('row', array('BootstrapExtension','row'));
    $wgParser->setHook('row-fluid', array('BootstrapExtension','row-fluid'));

   	$wgParser->setFunctionHook('herounit', array('BootstrapExtension', 'heroUnit'));
		return true;
	}

	static function registerResources(){
	    global $wgResourceModules, $wgStylePath;
	    
		$resourceTemplate = array(
			'localBasePath' => dirname( __FILE__ ),
      'remoteBasePath' => $wgStylePath.'/'.basename(dirname( __FILE__ )),
			'group' => 'bootstrap'
		);
		
		$wgResourceModules += array(

			'bootstrap.css' => $resourceTemplate + array(
	      'styles' => array(
	      	'bootstrap-3.0.3/css/bootstrap.min.css'=>array('media'=>'screen')
	      ),
			),

			'bootstrap.js' => $resourceTemplate + array(
					'dependencies'=>array('jquery'),
			    'scripts'=> array('bootstrap-3.0.3/js/bootstrap.min.js'),
			),

			'bootstrap' => $resourceTemplate + array(
	        'dependencies' => array( 'bootstrap.js', 'bootstrap.css' )
	    ),


      'skin.bootstrap.css' => $resourceTemplate + array(
          'styles'=> array('skins/base/base.css')
      ),
      'skin.bootstrap.js' => $resourceTemplate + array(
          'scripts'=> array('skins/base/init.js'),
          'position'=> 'bottom',
          'dependencies'=>array(
          	'bootstrap.js'
          )
      ),


			//resources for the Hero theme
			'skin.bootstrap.hero' => $resourceTemplate + array(
				'styles'=> array('skins/superhero/hero.css'),
				'scripts'=> array('skins/superhero/init.js')
			),

		);
        return true;
	}

}
