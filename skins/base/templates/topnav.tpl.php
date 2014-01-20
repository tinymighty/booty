<header id="top-nav" class="navbar navbar-fixed-top<?php $this->insert('navbar.class') ?>" role="banner">
  <div class="container">

    <div class="navbar-header">
      <?php $this->insert('brand') ?>

      <div class="navbar-search">
        <?php echo $this->insert('inline search'); ?>
      </div>

      <div class="navbar-menu-toggle">
        <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#top-menu">
          <span class="sr-only">Toggle navigation</span>
          <span class="glyphicon glyphicon-arrow-down"></span>
        </button>
      </div>
    </div>

    <div class="navbar-search">
      <?php echo $this->insert('inline search'); ?>
    </div>

    <nav id="top-menu" role="navigation" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <?php $this->insert('primary nav menus') ?>
      </ul>
    </nav>



  </div>
</header>