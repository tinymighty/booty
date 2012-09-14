<?php
/**
 * Bootstrap - A MediaWiki extension to integrate Twitter Bootstrap 
 *
 * @Version 1.0.0
 * @Author Andru Vallance <andru@tinymighty.com>
 * @Copyright Andru Vallance, 2012
 * @License: GPLv2 (http://www.gnu.org/copyleft/gpl.html)
 */

$wgExtensionFunctions[] = "BootstrapSetup::setHooks";
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Bootstrap',
	'author' => 'Andru Vallance, ',
	'description' => 'Integrates Twitter Bootstrap (twitter.github.com/bootstrap) into MediaWiki and adds <nowiki><row> and <span[N]></nowiki> tags to support Bootstrap layouts',
	'url' => 'https://github.com/hypery2k/Bootstrap-Skin'
);

$wgAutoloadClasses['BootstrapExtension'] = dirname(__FILE__) . '/Boostrap.body.php';

class BootstrapSetup{
	static function hooks(){
	    global $wgParser;
	    for($i=1; $i<=16; $i++)
		    $wgParser->setHook('span'.$i, array('BootstrapExtension','span'.$i));
		    $wgParser->setHook('span-one-third', array('BootstrapExtension','span-one-third'));
		    $wgParser->setHook('span-two-thirds', array('BootstrapExtension','span-two-thirds'));
		    $wgParser->setHook('row', array('BootstrapExtension','row'));
		} 
	}
	static function resourceLoader()
		$resourceTemplate = array(
			'localBasePath' => dirname( __FILE__ ).'/resources',
			'remoteExtPath' => 'Bootstrap',
			'group' => 'boostrap'
		);
		$wgResourceModules += array(
			'bootstrap.css' => $resourceTemplate + array(
		        'styles' => array(
		        	'bootstrap/bootstrap.css'=>array('media'=>'screen')
		        ),
		        'dependencies' => array( )
			),
			'bootstrap.responsive' => $resourceTemplate + array(
		        'styles' => array(
		        	'bootstrap/bootstrap-responsive.css'=>array('media'=>'screen')
		        ),
		        'dependencies' => array( 'bootstrap.css' )
			),
			'bootstrap.affix' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/bootstrap-affix.js' )
			),
			'bootstrap.alert' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/bootstrap-alert.js' )
			),
			'bootstrap.button' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/bootstrap-button.js' )
			),
			'bootstrap.carousel' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/bootstrap-carousel.js' )
			),
			'bootstrap.collapse' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/bootstrap-collapse.js' )
			),
			'bootstrap.dropdown' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/bootstrap-dropdown.js' )
			),
			'bootstrap.modal' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/bootstrap-modal.js' )
			),
			'bootstrap.popover' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/bootstrap-popover.js' )
			),
			'bootstrap.scrollspy' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/bootstrap-scrollspy.js' )
			),
			'bootstrap.tab' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/bootstrap-tab.js' )
			),
			'bootstrap.tooltip' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/bootstrap-tooltip.js' )
			),
			'bootstrap.transition' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/bootstrap-transition.js' )
			),
			'bootstrap.typehead' => $resourceTemplate + array(
			    'scripts' => array( 'bootstrap/bootstrap-typeahead.js' )
			)
		);
	}
}