<header id="nav-menu" aria-label="navigation bar">
    <div class="container">
        <div class="nav-center">
            <a class="logo" href="<?= base_url() ?>">
                <img src="<?= base_url() . $this->config->semevar->site_logo->path ?>" width="35" height="35" alt="<?= $this->config->semevar->site_name ?>" />
            </a>
            <nav class="menu">
                <ul class="menu-bar">
                    <li>
                        <button class="nav-link dropdown-btn" data-dropdown="dropdown1" aria-haspopup="true" aria-expanded="false" aria-label="produk">
                            Produk
                            <i class="bx bx-chevron-down" aria-hidden="true"></i>
                        </button>
                        <div id="dropdown1" class="dropdown">
                            <?php if (isset($bpm) && count($bpm)) : ?>
                                <?php $temp_kategori = ""; ?>
                                <?php foreach ($bpm as $k => $v) : ?>
                                    <?php if ($k == 0) : ?>
                                        <?php $temp_kategori = $v->a_kategori_nama; ?>
                                        <ul role="menu" class="border-right">
                                            <li><span class="dropdown-link-title"><?= $v->a_kategori_nama ?></span></li>
                                        <?php else : ?>
                                            <?php if ($temp_kategori != $v->a_kategori_nama) : ?>
                                                <?php $temp_kategori = $v->a_kategori_nama; ?>
                                        </ul>
                                        <ul role="menu" class="<?= ($k == count($bpm) - 1) ? "" : "border-right" ?>">
                                            <li><span class="dropdown-link-title"><?= $v->a_kategori_nama ?></span></li>
                                        <?php endif ?>
                                        <li role="menuitem"><a class="dropdown-link" href="<?= base_url("produk/" . $v->slug) ?>"><?= $v->nama ?></a></li>
                                    <?php endif ?>
                                    <?php if ($k == count($bpm) - 1) : ?>
                                        </ul>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    </li>

                    <li>
                        <button class="nav-link dropdown-btn" data-dropdown="dropdown2" aria-haspopup="true" aria-expanded="false" aria-label="sosmed">
                            Follow
                            <i class="bx bx-chevron-down" aria-hidden="true"></i>
                        </button>
                        <div id="dropdown2" class="dropdown">
                            <ul role="menu" class="">
                                <li role="menuitem"><a class="dropdown-link" target="_blank" href="<?= $this->config->semevar->site_ig ?>">Instagram</a></li>
                                <li role="menuitem"><a class="dropdown-link" target="_blank" href="<?= $this->config->semevar->site_fb ?>">Facebook</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <button class="nav-link dropdown-btn" data-dropdown="dropdown3" aria-haspopup="true" aria-expanded="false" aria-label="sosmed">
                            Marketplace
                            <i class="bx bx-chevron-down" aria-hidden="true"></i>
                        </button>
                        <div id="dropdown3" class="dropdown">
                            <ul role="menu" class="">
                                <li role="menuitem"><a class="dropdown-link" target="_blank" href="<?= $this->config->semevar->site_tokopedia ?>">Tokopedia</a></li>
                                <!-- <li role="menuitem"><a class="dropdown-link" target="_blank" href="<?= $this->config->semevar->site_shopee ?>">Shopee</a></li> -->
                            </ul>
                        </div>
                    </li>
                    <li><a class="nav-link" href="<?= base_url() ?>tentang_kami">Tentang Kami</a></li>
                    <li><a class="nav-link" href="<?= base_url() ?>blog">Blog</a></li>
                </ul>
            </nav>
        </div>

        <div class="nav-end">
            <!-- <div class="right-container">
                <form class="search" role="search">
                    <input type="search" name="search" placeholder="Search" />
                    <i class="bx bx-search" aria-hidden="true"></i>
                </form>
                <a href="#profile">
                    <img src="https://github.com/Evavic44/responsive-navbar-with-dropdown/blob/main/assets/images/user.jpg?raw=true" width="30" height="30" alt="user image" />
                </a>
                <button class="btn btn-primary">Create</button>
            </div> -->

            <button id="hamburger" aria-label="hamburger" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</header>