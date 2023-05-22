<style>
	.size-profile {
		width: 200px;
		height: 200px;
	}

	.select2-container {
		z-index: 100000;
	}

	.circle {
		border-radius: 200px;
		color: white;
		font-weight: bold;
		display: table;
		width: 100px;
		height: 100px;
		text-align: center;
	}

	.circle p {
		vertical-align: middle;
		display: table-cell;
		font-size: 3em;
		font-family: none;
	}

	@media only screen and (max-width:600px) {
		.size-profile {
			width: 100px;
			height: 100px;
		}

		.profile-root {
			margin: 0px !important;
		}


	}
</style>
<div class="mx-2 profile-root">
	<div class="mt-2">
		<img src="<?= base_url() . "/media/background-profile.jpg" ?>" class="rounded img-fluid" width="100%" alt="...">

	</div>
	<?php //dd($ue); 
	?>
	<div class="d-flex flex-wrap justify-content-between align-items-end px-5">
		<div class="col-md-6">
			<div class="d-flex align-items-center" style="margin-top:1rem;">
				<div style="margin-top: -80px;">
					<div class="circle bg-primary">
						<p><?= $ue->fnama[0] ?? '' ?></p>
					</div>


				</div>
				<div style="margin-left: 1.5rem;">
					<h2 class="text-secondary"><?= $ue->fnama ?></h2>
					<div class="text-primary"><?= $ue->profesi ?></div>
					<div class="text-primary"><?= $ue->ruangan ?></div>
				</div>
			</div>

		</div>
		<div id="edit-button" class="col-md-6 text-end">

			<button class="btn btn-primary bg-primary" id="btn-edit-profile">
				<div class="d-inline-flex">
					<div><span class="fa fa-pencil"></span></div>
					<div style="margin-left: 1rem;">Edit Profile</div>
				</div>
			</button>
			<button class="btn btn-danger " id="btn-logout">
				<div class="d-inline-flex">
					<div><span class="fa fa-door-open"></span></div>
					<div style="margin-left: 1rem;">Logout</div>
				</div>
			</button>
			<!-- <div class="row justify-content-end mt-2">
				<div class="col-md-2">Social Media</div>
				<div class="col-md-1"><img src="<?= base_url() . "/media/instagramm.png" ?>" alt=""></div>
				<div class="col-md-1"><img src="<?= base_url() . "/media/facebook.png" ?>" alt=""></div>
				<div class="col-md-1"><img src="<?= base_url() . "/media/twitter.png" ?>" alt=""></div>
			</div> -->
		</div>

	</div>
	<div class="m-4">
		<div class="row">
			<div class="col-xl-4 my-2">
				<div class="card card-stats">
					<!-- Card body -->
					<div class="card-body">
						<div class="row">
							<div class="col">
								<h5 class="card-title text-uppercase text-muted mb-2">Audit Hand Hygiene</h5>
								<span class="h3 mb-0"><?= $count_hygiene ?></span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-orange text-center text-white rounded-circle shadow">
									<i class="fas fa-pump-medical fa-lg align-top"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
							<span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
							<span class="text-nowrap"></span>
						</p>
					</div>
				</div>
			</div>
			<div class="col-xl-4 my-2">
				<div class="card card-stats">
					<!-- Card body -->
					<div class="card-body">
						<div class="row">
							<div class="col">
								<h5 class="card-title text-uppercase text-muted mb-2">Audit Kepatuhan APD</h5>
								<span class="h3 mb-0"><?= $count_apd ?></span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-blue text-center text-white rounded-circle shadow">
									<i class="fas fa-head-side-mask fa-lg align-top"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
							<span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
							<span class="text-nowrap"></span>
						</p>
					</div>
				</div>
			</div>
			<div class="col-xl-4 my-2">
				<div class="card card-stats">
					<!-- Card body -->
					<div class="card-body">
						<div class="row">
							<div class="col">
								<h5 class="card-title text-uppercase text-muted mb-2">Monitoring Kegiatan Harian Pencegahan Pengendalian Infeksi (PPI)</h5>
								<span class="h3 mb-0"> <?= $count_monev ?></span>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-green text-center text-white rounded-circle shadow">
									<i class="fas fa-notes-medical fa-lg align-top"></i>
								</div>
							</div>
						</div>
						<p class="mt-3 mb-0 text-sm">
							<span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
							<span class="text-nowrap"></span>
						</p>
					</div>
				</div>
			</div>

		</div>

	</div>