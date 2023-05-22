<?php
$user_name = '';
if (isset($sess->user->fnama)) if (strlen($sess->user->fnama) > 1) $user_name = $sess->user->fnama;
if (!isset($this->current_page)) $this->current_page = "";
if (!isset($this->current_parent)) $this->current_parent = "";
$current_page = $this->current_page;
$current_parent = $this->current_parent;
$parent = array();
foreach ($sess->user->menus->left as $key => $v) {
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
$user_foto = '';
if (isset($sess->user->foto)) $user_foto = $sess->user->foto;
if (empty($user_foto)) $user_foto = 'media/pengguna/default.png';
$user_foto = $this->cdn_url($user_foto);
?>
<div id="sidebar">
	<!-- Wrapper for scrolling functionality -->
	<div id="sidebar-scroll">
		<!-- Sidebar Content -->
		<div class="sidebar-content">
			<!-- Brand -->
			<a href="<?= base_url(); ?>" class="sidebar-brand">
				<img src="<?= $this->cdn_url("skin/user/") ?>img/logo.png" />
			</a>
			<!-- END Brand -->

			<!-- User Info -->
			<div class="sidebar-section sidebar-user clearfix sidebar-nav-mini-hide">
				<div class="sidebar-user-avatar">
					<a href="<?= base_url('profil'); ?>">
						<img src="<?= $user_foto ?>" alt="avatar" onerror="this.null;this.src='<?= base_url('media/pengguna/default.png') ?>';" />
					</a>
				</div>
				<div class="sidebar-user-name"><?= $user_name; ?></div>
				<div class="sidebar-user-links">
					<a href="<?= base_url('profil'); ?>" data-toggle="tooltip" data-placement="bottom" title="Profile"><i class="gi gi-user"></i></a>
					<a href="<?= base_url("logout"); ?>" data-toggle="tooltip" data-placement="bottom" title="Logout"><i class="gi gi-exit"></i></a>
				</div>
			</div>
			<!-- END User Info -->

			<!-- Sidebar Navigation -->
			<ul class="sidebar-nav">
				<?php foreach ($sess->user->menus->left as $key => $v) { ?>
					<?php if (count($v->childs) > 0) { ?>
						<li class="<?php if ($parent[$v->identifier] == 1) echo 'active'; ?>">
							<a href="#" class="sidebar-nav-menu ">
								<i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
								<i class="<?= $v->fa_icon; ?> sidebar-nav-icon"></i>
								<span class="sidebar-nav-mini-hide"><?= $v->name; ?></span>
							</a>
							<ul class="">
								<?php foreach ($v->childs as $f) { ?>
									<?php if ($f->utype == "external") { ?>
										<li>
											<a href="<?= $f->path; ?>" class="<?php if ($this->current_page == $f->identifier) echo 'active'; ?>">
												<?= $f->name; ?>
											</a>
										</li>
									<?php } else { ?>
										<li>
											<a href="<?= base_url($f->path); ?>" class="<?php if ($this->current_page == $f->identifier) echo 'active'; ?>">
												<?= $f->name; ?>
											</a>
										</li>
									<?php } ?>
								<?php } ?>
							</ul>
						</li>
					<?php } else { ?>
						<li class="<?php if ($current_page == $key) echo 'active'; ?>"><a href="<?= base_url($v->path); ?>" class="<?php if ($current_page == $key) echo 'active'; ?>"><i class="<?= $v->fa_icon; ?>"></i> <span><?= $v->name; ?></span></a></li>
					<?php } ?>
				<?php } ?>
			</ul>
			<!-- END Sidebar Navigation -->

		</div>
		<!-- END Sidebar Content -->
	</div>
	<!-- END Wrapper for scrolling functionality -->
</div>