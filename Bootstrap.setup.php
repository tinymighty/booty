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
	'author' => 'Andru Vallance, ',
	'description' => 'Integrates Twitter Bootstrap (twitter.github.com/bootstrap) into MediaWiki and adds <nowiki><row> and <span[N]></nowiki> tags to support Bootstrap layouts',
	'url' => 'https://github.com/hypery2k/Bootstrap-Skin'
);

$wgAutoloadClasses['BootstrapExtension'] = dirname(__FILE__) . '/Bootstrap.extension.php';
$wgAutoloadClasses['BootstrapSkin'] = dirname(__FILE__) . '/Bootstrap.skin.php';
$wgAutoloadClasses['BootstrapTemplate'] = dirname(__FILE__) . '/Bootstrap.template.php';

$wgExtensionMessagesFiles[ 'Bootstrap' ] = __DIR__ . '/Bootstrap.i18n.php';

$wgExtensionFunctions[] = "BootstrapSetup::tags";
//$wgHooks['BeforePageDisplay'][] = 'BootstrapSetup::registerResources';

class BootstrapSetup{
	
	private function __construct(){}
	protected static $modules = array(
		'bootstrap'
	);
	protected static $settings = array(
	    
	);
	protected static $options = array();
	
	public static function init($options=array()){
      self::setOptions($options);
	    self::registerResources();
	}
	
	static function setOptions($options){
	    if(isset($options['modules']))
	        self::setModules($options['modules']);
	    unset($options['modules']);
	    self::$options = array_merge(self::$settings,$options);
	}

	static function setModules($modules){
		self::$modules = $modules;
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
			'localBasePath' => dirname( __FILE__ ).'/resources',
      'remoteBasePath' => $wgStylePath.'/Bootstrap/resources',
			'group' => 'boostrap'
		);
		
		$wgResourceModules += array(

			'bootstrap.css' => $resourceTemplate + array(
	      'styles' => array(
	      	'bootstrap/css/bootstrap.css'=>array('media'=>'screen')
	      ),
			),

	    'bootstrap' => $resourceTemplate + array(
	        'dependencies' => array( 'bootstrap.js' )
	    ),
			'bootstrap.responsive' => $resourceTemplate + array(
		        'styles' => array(
		        	'bootstrap/css/bootstrap-responsive.css'=>array('media'=>'screen')
		        ),
		        'dependencies' => array( 'bootstrap.css' )
			),
			'bootstrap.js' => $resourceTemplate + array(
			    'dependencies' => array( 'bootstrap.affix','bootstrap.alert','bootstrap.button','bootstrap.carousel',
										 'bootstrap.collapse','bootstrap.dropdown','bootstrap.modal','bootstrap.popover',
										 'bootstrap.scrollspy','bootstrap.tab','bootstrap.tooltip','bootstrap.transition',
										 'bootstrap.typeahead')
			),
			'bootstrap.affix' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/js/bootstrap-affix.js' )
			),
			'bootstrap.alert' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/js/bootstrap-alert.js' )
			),
			'bootstrap.button' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/js/bootstrap-button.js' )
			),
			'bootstrap.carousel' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/js/bootstrap-carousel.js' )
			),
			'bootstrap.collapse' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/js/bootstrap-collapse.js' )
			),
			'bootstrap.dropdown' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/js/bootstrap-dropdown.js' )
			),
			'bootstrap.modal' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/js/bootstrap-modal.js' )
			),
			'bootstrap.popover' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/js/bootstrap-popover.js' ),
			    'dependencies' => array( 'bootstrap.tooltip' )
			),
			'bootstrap.scrollspy' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/js/bootstrap-scrollspy.js' )
			),
			'bootstrap.tab' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/js/bootstrap-tab.js' )
			),
			'bootstrap.tooltip' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/js/bootstrap-tooltip.js' )
			),
			'bootstrap.transition' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/js/bootstrap-transition.js' )
			),
			'bootstrap.typeahead' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/js/bootstrap-typeahead.js' )
			),

      'skin.bootstrap.css' => $resourceTemplate + array(
          'styles'=> array('main.css'),
      ),
      'skin.bootstrap.js' => $resourceTemplate + array(
          'scripts'=> array('init.js'),
          'position'=> 'bottom',
          'dependencies'=>array(
          	'bootstrap.tooltip'
          )
      )

		);
        return true;
	}
}
BootstrapSetup::init();