<?php
$admin_name = $sess->admin->username;
if (isset($sess->admin->nama)) if (strlen($sess->admin->nama) > 1) $admin_name = $sess->admin->nama;
if (!isset($this->current_page)) $this->current_page = "";
if (!isset($this->current_parent)) $this->current_parent = "";
$current_page = $this->current_page;
$current_parent = $this->current_parent;
$parent = array();
foreach ($sess->admin->menus->left as $key => $v) {
	$parent[$v->identifier] = 0;
	if (count($v->childs) > 0) {
		foreach ($v->childs as $f) {
			if ($current_page == $f->identifier) {
				$current_page = $v->identifier;
				$parent[$v->identifier] = 1;
			}
		}
	}
}
$admin_foto = '';
if (isset($sess->admin->foto)) $admin_foto = $sess->admin->foto;
if (empty($admin_foto)) $admin_foto = 'media/pengguna/default.png';
$admin_foto = $this->cdn_url($admin_foto);
?>
<aside class="sidenav bg-nav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
	<div class="sidenav-header">
		<i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
		<a class="navbar-brand m-0" href="<?= base_url_admin() ?>">
			<img src="<?= $this->cdn_url("media/logo.png") ?>" class="navbar-brand-img h-100" alt="main_logo">
			<span class="ms-1 font-weight-bold"><?= $this->config->semevar->site_name ?></span>
		</a>
	</div>
	<hr class="horizontal dark mt-0">
	<div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link active" href="<?= base_url_admin() ?>">
					<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
					</div>
					<span class="nav-link-text ms-1">Dashboard</span>
				</a>
			</li>
			<li class="nav-item mt-3">
				<h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6"></h6>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="<?= base_url_admin() ?>order">
					<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="ni ni-cart text-primary text-sm opacity-10"></i>
					</div>
					<span class="nav-link-text ms-1">Order</span>
				</a>
			</li>

			<li class="nav-item">
				<a class="nav-link " href="<?= base_url_admin() ?>akun/user">
					<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="ni ni-single-02 text-warning text-sm opacity-10"></i>
					</div>
					<span class="nav-link-text ms-1">Pelanggan</span>
				</a>
			</li>
			<li class="nav-item mt-3">
				<h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Pengaturan</h6>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="<?= base_url_admin() ?>pengaturan/kategori">
					<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="ni ni-app text-info text-sm opacity-10"></i>
					</div>
					<span class="nav-link-text ms-1">Kategori</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="<?= base_url_admin() ?>pengaturan/produk">
					<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="ni ni-app text-danger text-sm opacity-10"></i>
					</div>
					<span class="nav-link-text ms-1">Produk</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="<?= base_url_admin() ?>pengaturan/banner">
					<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="ni ni-world text-success text-sm opacity-10"></i>
					</div>
					<span class="nav-link-text ms-1">Banner / Promotion</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="<?= base_url_admin() ?>pengaturan/partner">
					<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="ni ni-building text-success text-sm opacity-10"></i>
					</div>
					<span class="nav-link-text ms-1">Partner</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " href="<?= base_url_admin() ?>pengaturan/blog">
					<div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
						<i class="ni ni-books text-warning text-sm opacity-10"></i>
					</div>
					<span class="nav-link-text ms-1">Blog</span>
				</a>
			</li>
		</ul>
	</div>
	<div class="sidenav-footer mx-3 vertical-end">
		<div class="card card-plain shadow-none " id="sidenavCard">
			<div class="card-body text-center p-3 w-100 pt-0 d-none">
				<div class="docs-info">
					<h6 class="mb-0">Need help?</h6>
					<p class="text-xs font-weight-bold mb-0">Please check our docs</p>
				</div>
			</div>
		</div>
		<a href="<?= base_url_admin("logout/") ?>" class="btn btn-dark btn-sm w-100 mb-3">Logout</a>
	</div>
</aside>