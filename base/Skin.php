<?php
if( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

class SkinBooty extends SkinSkinny {

	public static $modules = array();


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

	public static function init(){
		global $egBootyBasePath, $egBootyBaseURL;

		$template = array(
			'localBasePath' => $egBootyBasePath,
		  'remoteBasePath' => $egBootyBaseURL
		 );

		$modules = array(

			//Bootstrap 3 & FontAwesome
			'bootstrap.css' => $template + array(
		    'styles' => array(
		    	'bootstrap-3.0.3/css/bootstrap.css'=>array('media'=>'screen')
		    ),
		    'position'=>'top',
		    'group'=>'bootstrap'
			),

			'bootstrap.js' => $template + array(
				'dependencies'=>array('jquery'),
			  'scripts'=> array('bootstrap-3.0.3/js/bootstrap.js'),
		    'group'=>'bootstrap'
			),
			
		  'font-awesome' => $template + array(
		  	'styles' => array(
		    	'font-awesome-4.0.3/css/font-awesome.css'=>array('media'=>'screen')
		    ),
		    'group'=>'bootstrap'
		  ),

			//Resources for Booty applicable to all layouts
		  'skin.booty.css' => $template + array(
		    'styles'=> array('base/css/layout.css', 'base/css/content.css'),
		    'position' => 'top',
		    'group'=>'booty'
		  ),
		  'skin.booty.js' => $template + array(
		    'scripts'=> array('base/js/init.js'),
		    'position'=> 'bottom',
		    'dependencies'=>array(
		    	'bootstrap.js'
		    ),
		    'group'=>'booty'
		  )
		); 

		self::addModules($modules);
	}


	public function initPage( OutputPage $out ) {
		global $egBootyBaseURL;

		//add the css modules separately to prevent a FOUC
		$out->addModuleStyles( 'bootstrap.css' );
		$out->addModuleStyles( 'skin.booty.css');
		$out->addModuleStyles( 'font-awesome' );

		//since we're using theb mediawiki generated head element, we have to add the viewport meta tag
		//so the layout scaled properly to mobile devices
		$out->addMeta( 'viewport', 'width=device-width');//,initial-width=1,maximum-width=1' );

		/* Until ResourceLoader can correctly parse multiple urls in a single font-family
		webfont files have to be defined in the head to prevent it screwing things up */

		$out->addInlineStyle("@font-face {
		  font-family: 'Glyphicons Halflings';
		  src: url('$egBootyBaseURL/bootstrap-3.0.3/fonts/glyphicons-halflings-regular.eot');
		  src: url('$egBootyBaseURL/bootstrap-3.0.3/fonts/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'), url('$egBootyBaseURL/bootstrap-3.0.3/fonts/glyphicons-halflings-regular.woff') format('woff'), url('$egBootyBaseURL/bootstrap-3.0.3/fonts/glyphicons-halflings-regular.ttf') format('truetype'), url('$egBootyBaseURL/bootstrap-3.0.3/fonts/glyphicons-halflings-regular.svg#glyphicons-halflingsregular') format('svg');
		}");
		$out->addInlineStyle("@font-face {
		  font-family: 'FontAwesome';
		  src: url('$egBootyBaseURL/font-awesome-4.0.3/fonts/fontawesome-webfont.eot?v=4.0.3');
		  src: url('$egBootyBaseURL/font-awesome-4.0.3/fonts/fontawesome-webfont.eot?#iefix&v=4.0.3') format('embedded-opentype'), url('$egBootyBaseURL/font-awesome-4.0.3/fonts/fontawesome-webfont.woff?v=4.0.3') format('woff'), url('$egBootyBaseURL/font-awesome-4.0.3/fonts/fontawesome-webfont.ttf?v=4.0.3') format('truetype'), url('$egBootyBaseURL/font-awesome-4.0.3/fonts/fontawesome-webfont.svg?v=4.0.3#fontawesomeregular') format('svg');
		  font-weight: normal;
		  font-style: normal;
		}");
		
		//js items will be appended after page load
		$out->addModules( 'bootstrap.js' );
		$out->addModules( 'skin.booty.js' );

		$out->addHeadItem('meta-viewport', '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">');

		parent::initPage( $out );

	}


}

