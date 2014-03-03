        <?php $this->insert('before:navbar-right-menu') ?>
        <nav role="navigation" id="top-nav-menus" class="navbar-menu navbar-menus last collapse">
          <ul class="nav navbar-nav navbar-right">
            <?php $this->attach('navbar-right-menu') ?>
          </ul>
        </nav>
        <?php $this->after('navbar-right-menu') ?>