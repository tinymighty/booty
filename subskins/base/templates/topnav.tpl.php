<header id="top-nav" class="navbar navbar-fixed-top<?php $this->insert('navbar.class') ?>" role="banner">
  <div class="container">
      <div class="navbar-menu-toggle">
        <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#top-nav-menu">
          <span class="sr-only">Toggle navigation</span>
          <span class="glyphicon glyphicon-arrow-down"></span>
        </button>
      </div>

      <?php $this->insert('brand'); ?>
  
      <?php $this->insert('primary nav search'); ?>

      <nav id="top-nav-menu" role="navigation" class="navbar-menu collapse">
        <ul class="nav navbar-nav navbar-right">
          <?php $this->insert('primary nav menus') ?>
        </ul>
      </nav>



  </div>
</header>