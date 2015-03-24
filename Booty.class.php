<?php

class Booty{
	
	/**
	 * Booty is a static singleton, it cannot be instantiated.
	 */
	private function __construct(){}

	public static $skinOptions = array();

	public static $baseURL = '';

	/**
	 * Set up the various hooks needed
	 * 
	 * Handler for Hook: BeforeInit
	 */
	public static function init(){
		global $egBootyBaseURL;

		self::$baseURL = $egBootyBaseURL;
		self::initSkin();
		self::initLayouts();
		//pass options along to skinny
		//Skinny::setOptions($options);
    //self::setOptions($options);

    //$wgHooks['ResourceLoaderRegisterModules'][] = 'Booty::registerResources';

    //$wgExtensionFunctions[] = "Booty::tags";
		return true;
	}

	/**
	 * Init the skin. Give it a chance to define resources etc
	 */
	public static function initSkin(  ){
		SkinBooty::init();
	}

	/**
	 * Initialize layouts from $egBootyLayouts config
	 */
	public static function initLayouts( ){
		global $egBootyLayouts;
		foreach( $egBootyLayouts as $name => $config ){
			Booty::addLayout( $name, $config );
		}
	}



	/**
	 * Convenience methods for SkinBooty
	 */
	public static function setOptions($options, $reset=false){
		if($reset===true){
			self::$skinOptions = array();
		}
	  self::$skinOptions = Skinny::mergeOptionsArrays( self::$skinOptions, $options );
	}
	public static function addLayout( $name, $config ){
		SkinBooty::addLayout( $name, $config );
	}
	public static function extendLayout( $extend, $name, $config ){
		SkinBooty::extendLayout( $extend, $name, $config );
	}
	public static function setLayoutOptions( $layout_name, $options ){
		SkinBooty::setLayoutOptions( $layout_name, $options );
	}
	public static function setLayoutTemplateOptions( $layout_name, $options ){
		SkinBooty::setLayoutTemplateOptions( $layout_name, $options );
	}
	public static function addModules( $modules, $auto=false ){
		SkinBooty::addModules( $modules, $auto );
	}
	public static function loadModules( $modules ){
		SkinBooty::autoloadModules( $modules );
	}
	public static function addModulesToLayout( $layout, $modules ){
		SkinBooty::addModulesToLayout( $layout, $modules );
	}
	public static function addTemplatePath( $path ){
		SkinBooty::addTemplatePath( $path );
	}



}
