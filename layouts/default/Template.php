<?php
/**
 * @todo document
 * @ingroup Skins
 */

class BootyDefaultTemplate extends BootyTemplate {

	protected $_default_defaults = array(
		'show title'=> true
	);

	public function __construct( $options=array() ){
		//merge in the default settings
		$this->setDefaults( $this->_default_defaults );

		parent::__construct( $options );
		//$this->addTemplatePath( dirname(__FILE__).'/templates' );
	}

}

