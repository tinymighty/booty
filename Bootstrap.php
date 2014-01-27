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
$wgAutoloadClasses['SkinBootstrapBase'] = $cd . '/subskins/base/Base.skin.php';
$wgAutoloadClasses['BootstrapBaseTemplate'] = $cd . '/subskins/base/Base.template.php';

//Hero skin, a sidebar-less skin with a jumbotron-sidebar combo - ideal for a big impact main page
$wgAutoloadClasses['SkinBootstrapHero'] = $cd . '/subskins/superhero/Hero.skin.php';
$wgAutoloadClasses['BootstrapHeroTemplate'] = $cd . '/subskins/superhero/Hero.template.php';

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
	protected static $defaults = array(
	   'subskin'  => 'SkinBootstrapBase',
	   'template' => 'BootstrapBaseTemplate',
	   'modules'  => array()
	);
	public static $options = array();

	public static function init($options=array()){
		//pass options along to skinny
		Skinny::setOptions($options);
    self::setOptions($options);

	  self::registerResources();
	}
	
	static function setOptions($options){
	  self::$options = array_merge( self::$defaults, self::$options, $options );
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
			),

			'bootstrap.js' => $resourceTemplate + array(
					'dependencies'=>array('jquery'),
			    'scripts'=> array('bootstrap-3.0.3/js/bootstrap.js'),
			),

			'bootstrap' => $resourceTemplate + array(
	        'dependencies' => array( 'bootstrap.js', 'bootstrap.css' )
	    ),

	    'font-awesome' => $resourceTemplate + array(
	    	'styles' => array(
	      	'font-awesome-4.0.3/css/font-awesome.css'=>array('media'=>'screen')
	      )
	    ),

      'skin.bootstrap.css' => $resourceTemplate + array(
          'styles'=> array('subskins/base/base.css')
      ),
      'skin.bootstrap.js' => $resourceTemplate + array(
          'scripts'=> array('subskins/base/init.js'),
          'position'=> 'bottom',
          'dependencies'=>array(
          	'bootstrap.js'
          )
      ),


			//resources for the Hero theme
			'skin.bootstrap.hero' => $resourceTemplate + array(
				'styles'=> array('subskins/superhero/hero.css'),
				'scripts'=> array('subskins/superhero/init.js')
			),

		);

		if(!empty(self::$options['modules'])){
			$wgResourceModules += self::$options['modules'];
		}

    return true;
	}

}
