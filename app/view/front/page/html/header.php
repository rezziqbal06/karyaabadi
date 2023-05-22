<?php
$admin_foto = '';
if (isset($sess->admin->foto)) $admin_foto = $sess->admin->foto;
if (empty($admin_foto)) $admin_foto = 'media/pengguna/default.png';
$admin_foto = base_url($admin_foto);
?>
<header class="navbar navbar-default bg-secondary">
	<!-- Left Header Navigation -->
	<ul class="nav navbar-nav-custom">
		<!-- Main Sidebar Toggle Button -->
		<li>
			<a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
				<i class="fa fa-bars fa-fw"></i>
			</a>
		</li>
		<!-- END Main Sidebar Toggle Button -->

		<!-- Template Options -->
		<!-- Change Options functionality can be found in js/app.js - templateOptions() -->
		<li class="dropdown" style="display:none;">
			<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
				<i class="gi gi-settings"></i>
			</a>
			<ul class="dropdown-menu dropdown-custom dropdown-options">
				<li class="dropdown-header text-center">Header Style</li>
				<li>
					<div class="btn-group btn-group-justified btn-group-sm">
						<a href="javascript:void(0)" class="btn btn-primary" id="options-header-default">Light</a>
						<a href="javascript:void(0)" class="btn btn-primary" id="options-header-inverse">Dark</a>
					</div>
				</li>
				<li class="dropdown-header text-center">Page Style</li>
				<li>
					<div class="btn-group btn-group-justified btn-group-sm">
						<a href="javascript:void(0)" class="btn btn-primary" id="options-main-style">Default</a>
						<a href="javascript:void(0)" class="btn btn-primary" id="options-main-style-alt">Alternative</a>
					</div>
				</li>
			</ul>
		</li>
		<!-- END Template Options -->
	</ul>
	<!-- END Left Header Navigation -->

	<!-- Search Form -->
	<form id="fmenu_cari" action="<?= base_url('cari/'); ?>" method="post" class="navbar-form-custom" onsubmit="return false;">
		<div class="form-group">
			<input id="top-search" type="text" name="keyword" class="form-control" placeholder="Cari menu/modul..">
		</div>
	</form>
	<!-- END Search Form -->

	<!-- Right Header Navigation -->
	<ul class="nav navbar-nav-custom pull-right">
		<!-- Alternative Sidebar Toggle Button -->
		<!-- chat toggle -->
		<li>
			<!-- If you do not want the main sidebar to open when the alternative sidebar is closed, just remove the second parameter: App.sidebar('toggle-sidebar-alt'); -->
			<a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar-alt', 'toggle-other');this.blur();">
				<i class="fa fa-comments"></i>
				<span id="chat-online-count" class="label label-primary label-indicator animation-floating">0</span>
			</a>
		</li>
		<!-- end chat toggle -->

		<!-- User Dropdown -->
		<li class="dropdown">
			<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
				<img src="<?= $admin_foto ?>" alt="avatar" onerror="this.null;this.src='<?= base_url('media/pengguna/default.png') ?>';"> <i class="fa fa-angle-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-custom dropdown-menu-right">
				<li class="dropdown-header text-center">Account</li>
				<li>
					<a href="<?= base_url('profil') ?>" title="Profil">
						<i class="fa fa-user fa-fw pull-right"></i>
						Profil
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="<?= base_url('logout'); ?>"><i class="fa fa-ban fa-fw pull-right"></i> Logout</a>
				</li>
			</ul>
		</li>
		<!-- END User Dropdown -->
	</ul>
	<!-- END Right Header Navigation -->
</header>