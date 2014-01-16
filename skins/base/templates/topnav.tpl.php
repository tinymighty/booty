<header id="top-nav" class="navbar navbar-fixed-top<?php $this->insert('navbar.class') ?>" role="banner">
  <div class="container">

    <div class="navbar-header">
      <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#top-menu">
        <span class="sr-only">Toggle navigation</span>
        <span class="glyphicon glyphicon-arrow-down"></span>
      </button>
      <?php $this->insert('brand') ?>
    </div>

    <nav id="top-menu" role="navigation" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
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