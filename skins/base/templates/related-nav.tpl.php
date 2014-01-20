		<nav id="related">
		<?php 

		$this->insert('language variants');
		$this->insert('toolbox');

		wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this, true ) );

		$this->insert('custom navigation');

		?>
		</nav>