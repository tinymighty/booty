<?php
class BootstrapExtension {

	public static function __callStatic($name, $fargs)
	{
		global $wgParser;

		$input = $fargs[0];

		$class = FALSE;
		if(is_array($fargs[1])) {
			if(array_key_exists('class', $fargs[1])) {
				$class = $fargs[1]['class'];
			}
		}

		return '<div class="' . $name . ($class?' '.$class:'') . '">' . $wgParser->recursiveTagParse($input) . '</div>';
	}

}

