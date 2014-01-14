		<nav id="related">
		<?php
		foreach( $sections as $boxName => $content ) {
			if ( $content === false )
				continue;

			if ( $boxName == 'TOOLBOX' ) {
				$this->toolbox();
			} elseif ( $boxName == 'LANGUAGES' ) {
				$this->languageBox();
			} else {
				$this->customBox( $boxName, $content );
			}
		}
		?>
		</nav>