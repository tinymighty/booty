      <div class="input-group">
        <input type="search" class="form-control" name="search" placeholder="<?php echo $label ?>" id="searchInput">

      	<span class="input-group-btn">
      		<button type="submit" class="btn btn-default" id="searchGoButton"><i class="glyphicon glyphicon-icon-circle-arrow-right" rel="tooltip" title="<?php echo $search_button_label ?>"></i> </button>
      	<?php if ($two_button_search): 
      	?><button class="btn btn-default searchButton" type="submit" id="mw-searchButton" name="search" value="fulltext"><i class="glyphicon glyphicon-search" rel="tooltip" title="<?php echo $fulltext_button_label ?>"></i> </button><?php	
      	endif; ?>
      	</span>

      </div>
