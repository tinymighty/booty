<?php
if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}
global $wgResourceModules, $wgStylePath;

$resourceTemplate = array(
	'localBasePath' => realpath(__DIR__.'/../'),
  'remoteBasePath' => $wgStylePath.'/'.basename(realpath(__DIR__.'/../')),
	'group' => 'bootstrap'
);

//Bootstrap 3 & FontAwesome
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
  )

);

//Resources for Booty applicable to all layouts
$wgResourceModules += array(
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

class SkinBooty extends SkinSkinny {
	public $skinname = 'booty';
	public $stylename = 'booty';
	//default template, this can be changed by skin layouts
	public $template = 'BootyTemplate';
	public $useHeadElement = true;

	public function __construct( $options=array() ){
		if(!empty(Booty::$skinOptions)){
			$options = Skinny::mergeOptionsArrays(Booty::$skinOptions, $options);
		}
		parent::__construct( $options );
	}


	public function initPage( OutputPage $out ) {
		//add the css modules separately to prevent a FOUC
		$out->addModules( 'bootstrap.css' );
		$out->addModules( 'skin.booty.css');
		$out->addModules( 'font-awesome' );
		//js items will be appended after page load
		$out->addModules( 'bootstrap.js' );
		$out->addModules( 'skin.booty.js' );

		parent::initPage( $out );

	}


}

