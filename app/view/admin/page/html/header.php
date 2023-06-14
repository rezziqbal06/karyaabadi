<?php
$admin_foto = '';
if (isset($sess->admin->foto)) $admin_foto = $sess->admin->foto;
if (empty($admin_foto)) $admin_foto = 'media/pengguna/default.png';
$admin_foto = base_url($admin_foto);
?>
<style>
	.btn-group-vertical button {
		margin-bottom: 0;
	}

	th,
	td {
		font-size: small;
		text-align: start;
	}

	@media screen and (max-width: 480px) {
		.dataTables_length label {
			margin-bottom: 0.5em;
		}

		.dataTables_filter label {
			float: left !important;
		}
	}
</style>
<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
	<div class="container-fluid py-1 px-3">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
				<li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Admin</a></li>
				<li class="breadcrumb-item text-sm text-white active" aria-current="page"><?= $this->current_parent ?></li>
			</ol>
			<h6 class="font-weight-bolder text-white mb-0 text-capitalize"><?= $this->current_page ?></h6>
		</nav>
		<div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
			<div class="ms-md-auto pe-md-3 d-flex align-items-center">
				<div class="input-group d-none">
					<span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
					<input type="text" class="form-control" placeholder="Type here...">
				</div>
			</div>
			<ul class="navbar-nav  justify-content-end">
				<li class="nav-item dropdown pe-2 d-flex align-items-center">
					<a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-user cursor-pointer" aria-hidden="true"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
						<li>
							<a class="dropdown-item border-radius-md" href="<?= base_url_admin("edit") ?>" id="btn_admin">
								<div class="d-flex py-1">
									<?php if (isset($sess->admin->foto) && strlen($sess->admin->foto)) { ?>
										<div class="avatar avatar-sm me-3  my-auto">
											<img src="<?= base_url() . $sess->admin->foto ?>" class="img-fluid" style="border-radius:8px">
										</div>
									<?php } else { ?>
										<div class="avatar avatar-sm bg-gradient-secondary me-3  my-auto">
											<i class="fa fa-user"></i>
										</div>
									<?php } ?>
									<div class="d-flex flex-column justify-content-center">
										<h6 class="text-sm font-weight-normal mb-1 text-primary">
											<?= $sess->admin->nama ?>
										</h6>
										<p class="text-xs text-secondary mb-0">
											<i class="fa fa-pencil me-1" aria-hidden="true"></i>
											edit profil
										</p>
									</div>
								</div>
							</a>
						</li>
					</ul>
				</li>

				<li class="nav-item px-3 d-flex align-items-center d-none">
					<a href="javascript:;" class="nav-link text-white p-0">
						<i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
					</a>
				</li>
				<li class="nav-item d-xl-none ps-3 px-3 d-flex align-items-center">
					<a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
						<div class="sidenav-toggler-inner">
							<i class="sidenav-toggler-line bg-white"></i>
							<i class="sidenav-toggler-line bg-white"></i>
							<i class="sidenav-toggler-line bg-white"></i>
						</div>
					</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
<!-- End Navbar -->