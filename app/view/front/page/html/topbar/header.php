<style>
    .navbar-brand-logo img {
        width: auto;
        max-height: 49px;
    }
</style>
<header class="navbar navbar-default navbar-fixed-top p-05 bg-secondary">

    <!-- Navbar Header -->
    <div class="navbar-header">
        <a class="navbar-brand-logo" href="#" title="rezza iqbal">
            <img alt="<?= $this->current_reseller->nama ?>" src="<?= $this->cdn_url($this->current_reseller->logo_kotak) ?>" alt="Logo <?= $this->current_reseller->nama ?>" onerror="this.null;this.src='<?= $this->cdn_url('media/default-logo.png') ?>';" />
        </a>
        <!-- Horizontal Menu Toggle + Alternative Sidebar Toggle Button, Visible only in small screens (< 768px) -->
        <ul class="nav navbar-nav-custom pull-left visible-xs">
            <li>
                <a href="javascript:void(0)" data-toggle="collapse" data-target="#horizontal-menu-collapse" class="collapsed" aria-expanded="false">
                    <i class="fa fa-bars"></i>
                </a>
            </li>
            <?php $this->getThemeElement('page/html/topbar/menu/user-mobile', $__forward); ?>
        </ul>
        <!-- END Horizontal Menu Toggle + Alternative Sidebar Toggle Button -->
    </div>
    <!-- END Navbar Header -->

    <!-- Alternative Sidebar Toggle Button, Visible only in large screens (> 767px) -->
    <ul class="nav navbar-nav-custom pull-right hidden-xs">
        <?php $this->getThemeElement('page/html/topbar/menu/user', $__forward); ?>
    </ul>
    <!-- END Alternative Sidebar Toggle Button -->

    <!-- Horizontal Menu + Search -->
    <div id="horizontal-menu-collapse" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <?php $this->getThemeElement('page/html/topbar/menu/main', $__forward); ?>
        </ul>
    </div>
    <!-- END Horizontal Menu + Search -->

</header>