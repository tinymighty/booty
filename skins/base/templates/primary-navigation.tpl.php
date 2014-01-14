<header id="top-nav" class="navbar navbar-fixed-top" role="banner">
  <div class="container">

    <div class="navbar-header">
      <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#top-menu">
        <span class="sr-only">Toggle navigation</span>
        <span class="glyphicon glyphicon-arrow-down"></span>
      </button>
      <a class="navbar-brand" id="topnav-name" href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ) ?>">
        <span id="topnav-logo" role="banner" style="background-image: url(<?php $this->text( 'logopath' ) ?>);"></span>
        <?php $this->html('sitename') ?>
      </a>
    </div>

    <nav id="top-menu" role="navigation" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <?php $this->insert('primary nav menus') ?>
      </ul>
    </nav>
    <div id="top-search">
      <form role="search" class="navbar-form">
      <?php echo $this->inlineSearchElements(); ?>
      </form>
    </div>

  </div>
</header>