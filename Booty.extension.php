<?php
class BootyExtension {


	public static function __callStatic($name, $fargs)
	{
		$wgParser = $GLOBALS['wgParser'];

		$input = $fargs[0];

		$class = FALSE;
		if(is_array($fargs[1])) {
			if(array_key_exists('class', $fargs[1])) {
				$class = $fargs[1]['class'];
			}
		}

		return '<div class="' . $name . ($class?' '.$class:'') . '">' . $wgParser->recursiveTagParse($input) . '</div>';
	}

	public static function heroUnit($parser){
		$args = func_get_args();
		array_shift($args);//unshift parser from start of argument list
		$content = array_pop($args); //pop content argument from end of argument list
		$opts = array(
			'class'=>'',
			'id'=>''
		);
		//run through any remaining arguments and explode any key=val strings into options
		if(count($args) > 0){
			foreach($args as $arg){
				$parts = explode('=', $arg);
				if(count($parts)===2 && isset($opts[$parts[0]])){
					$opts[$parts[0]] = $parts[1];
				}
			}
		}
		return '<div class="hero-unit '.$opts['class'].'" id="'.$opts['id'].'">'.$content.'</div>';
	}


	public static function setSkin($parser, $skin){
		/* @todo: in order to work with parsercache this needs to cache the value in wikitext and retreive it
		before the skin is initialized */
		Bootstrap::$pageSkin = $skin;
		return true;
	}

}

