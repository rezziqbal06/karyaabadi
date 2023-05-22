<style>
	.card {
		box-shadow: none;
		border: solid 1px #121212;
	}

	.pill {
		padding: 5px;
		border-radius: 8px;
		font-size: small;
		color: white;
	}

	.pill-warning {
		color: white;
		background-color: var(--accent);
	}

	.select2 {
		width: 100% !important;
	}

	.date-picker {
		z-index: 1600 !important;
		/* has to be larger than 1050 */
	}
</style>
<div class="mb-5">
	<div class="container">
		<div class="row gradient-primary p-5" style="border-bottom-left-radius: 16px;border-bottom-right-radius: 16px;">
			<h6 class="text-white">Statistik</h6>
			<h3 class="text-white">Asesmen RS Bina Sehat</h3>
		</div>
		<div class="row">
			<div class="col-md-12"></div>
		</div>
		<div class="input-group p-3 mt-n5">
			<select name="" id="jenis_penilaian" class="form-control">
				<?php if (isset($ajm) && count($ajm)) : ?>
					<?php foreach ($ajm as $k => $v) : ?>
						<option value="<?= $v->id ?>" data-type-form="<?= $v->type_form ?>"><?= $v->nama ?></option>
					<?php endforeach ?>
				<?php endif ?>
			</select>
			<!-- <a href="#" class="btn btn-secondary bg-accent" id="btn_filter"><i class="fa fa-sliders"></i></a> -->
			<!-- <button class="btn btn-secondary bg-accent"><i class="fa fa-search"></i></button> -->
		</div>
		<div class="panel-filter row" style="display: none;">
			<div class="col-md-1">
			</div>
		</div>
		<div class="panel-statistik mb-5">
			<div class="card col-md-6 p-3 mx-auto d-none">
				<h4 class="mb-5">Grafik Penilaian Kumulatif</h4>
				<select name="" id="asesor" class="form-control select2">
					<?php if (isset($bum) && count($bum)) : ?>
						<?php foreach ($bum as $k => $v) : ?>
							<option value="<?= $v->id ?>"><?= $v->fnama ?></option>
						<?php endforeach ?>
					<?php endif ?>
				</select>
				<div class="p-4" style="width: 100%">
					<div id="asesmenChart">
					</div>
				</div>
			</div>
			<div class="row justify-content-evenly">
				<div class="card col-md-12 p-3" id="card-hygiene-chart">
					<h5 class="mx-5 mt-4"><i class="fas fa-chart-area"></i> Grafik Nilai Audit Hand Hygiene</h5>
					<div class="p-4" style="width: 100%">
						<div id="hygieneChart" class="qaanii-apex-chart">
						</div>
					</div>
				</div>
				<div class="card col-md-12 p-3" id="card-apd-chart">
					<h5 class="mx-5 mt-4"><i class="fas fa-chart-area"></i> Grafik Nilai Audit Kepatuhan APD</h5>
					<div class="p-4" style="width: 100%">
						<div id="apdChart" class="qaanii-apex-chart">
						</div>
					</div>
				</div>
				<div class="card col-md-12 p-3" id="card-monev-chart">
					<h5 class="mx-5 mt-4"><i class="fas fa-chart-area"></i> Grafik Nilai Monitoring Kegiatan Harian Pencegahan Pengendalian Infeksi (PPI)</h5>
					<div class="p-4" style="width: 100%">
						<div id="monevChart" class="qaanii-apex-chart">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<main id="filter" class="sticky-top p-3 bg-background mb-3 card-filter">
		<div class="d-none d-md-block">
			<form id="ffilter" class="row">
				<div id="" class="col-md-3 panel_b_user_id_penilai" style="display:none">
					<label for="ib_user_id_penilai">Penilai</label>
					<select class="form-control select2" style="width: 100%;" name="b_user_id_penilai" id="ib_user_id_penilai">
						<option value="">-- Pilih Penilai --</option>
						<?php foreach ($bum as $k => $v) : ?>
							<option value="<?= $v->id ?>"><?= $v->fnama ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div id="" class="col-md-3 panel_b_user_id">
					<label for="ib_user_id">Nama</label>
					<select class="form-control select2" style="width: 100%;" name="b_user_id" id="ib_user_id">
						<option value="">-- Pilih Nama --</option>
						<?php foreach ($bum as $k => $v) : ?>
							<option value="<?= $v->id ?>"><?= $v->fnama ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-3 panel_tgl">
					<label for="isdate">Dari Tanggal</label>
					<input type="date" class="form-control date-picker" name="sdate" id="isdate">
				</div>
				<div class="col-md-3 panel_tgl">
					<label for="iedate">Sampai Tanggal</label>
					<input type="date" class="form-control date-picker" name="edate" id="iedate">
				</div>
				<div class="col-md-3 panel_bulan">
					<label for="iedate">Sampai Tanggal</label>
					<select name="bulan" id="ibulan" class="form-control select2">
						<option value="">-- pilih bulan --</option>
						<option value="<?= date('Y') ?>-01-01">Januari</option>
						<option value="<?= date('Y') ?>-02-01">Februari</option>
						<option value="<?= date('Y') ?>-03-01">Maret</option>
						<option value="<?= date('Y') ?>-04-01">April</option>
						<option value="<?= date('Y') ?>-05-01">Mei</option>
						<option value="<?= date('Y') ?>-06-01">Juni</option>
						<option value="<?= date('Y') ?>-07-01">Juli</option>
						<option value="<?= date('Y') ?>-08-01">Agustus</option>
						<option value="<?= date('Y') ?>-09-01">September</option>
						<option value="<?= date('Y') ?>-12-01">Oktober</option>
						<option value="<?= date('Y') ?>-11-01">November</option>
						<option value="<?= date('Y') ?>-13-01">Desember</option>
					</select>
				</div>
				<div class="col-md-3">
					<label for="ia_ruangan_id">Ruangan</label>
					<select class="form-control select2" style="width: 100%;" name="a_ruangan_id" id="ia_ruangan_id">
						<option value="">-- Pilih Ruangan --</option>
						<?php foreach ($arm as $k => $v) : ?>
							<option value="<?= $v->id ?>"><?= $v->nama ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-4">
					<label for="">Aksi</label>
					<div class="form-group">

						<button type="submit" class="btn btn-primary text-left" data-dismiss="modal"><i class="fa fa-filter"></i> Filter</button>
						<button id="btn_print" class="btn btn-secondary text-left"><i class="fa fa-print"></i> Print</button>
					</div>
				</div>
			</form>
		</div>
		<div class="row d-md-none p-2">
			<div class="col-9">&nbsp;</div>
			<button id="btn_filter" class="btn btn-outline-warning col-3"><i class="fa fa-filter"></i></button>
		</div>
	</main>
	<div class="container">
		<div class="panel-list p-2" style="display: none; ">
		</div>
		<div class="panel-pagination p-2 d-flex justify-content-center" style="display: none; ">
		</div>
		<div class="panel-loading mt-3">
			<p class="placeholder-glow">
				<span class="placeholder col-12"></span>
				<span class="placeholder col-6"></span>
				<span class="placeholder col-4"></span>
				<span class="placeholder col-2"></span>
				<span class="placeholder col-12"></span>
				<span class="placeholder col-4"></span>
				<span class="placeholder col-7"></span>
				<span class="placeholder col-12"></span>
				<span class="placeholder col-12"></span>
				<span class="placeholder col-12"></span>
			</p>
		</div>
		<div class="panel-empty row" style="display: none;">
			<div class="col-md-12 text-center">
				<img src="<?= base_url('media/empty.png') ?>" class="img-fluid mb-n5" alt="">
				<h5>Penilaian masih kosong</h5>
			</div>
		</div>
	</div>


</div>