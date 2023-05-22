<style>
	.panel-header {
		background-color: var(--background);
	}

	.border {
		border-width: 5px !important;
	}

	.transition {
		transition-timing-function: ease-in;
		transition: 0.3s;
	}

	.nomor {
		border-radius: 50%;
		background-color: var(--secondary);
		padding: 2px;
		width: 30px;
		height: 30px;
		color: white;
		text-align: center;
		float: right;
	}

	.switch {
	display: inline-block;
	height: 34px;
	position: relative;
	width: 60px;
	}

	.switch input {
	display:none;
	}

	.slider {
	background-color: #ccc;
	bottom: 0;
	cursor: pointer;
	left: 0;
	position: absolute;
	right: 0;
	top: 0;
	transition: .4s;
	}

	.slider:before {
	background-color: #fff;
	bottom: 3.2px;
	content: "";
	height: 26px;
	left: 4px;
	position: absolute;
	transition: .4s;
	width: 26px;
	}

	.switch h5 {
	width: 200px;
	position: absolute;
	top: -5px;
	left: 55px;
	font-size: 15px;
	text-align: justify;
	margin: 0.75rem;
	}

	input:checked + .slider {
	background-color: #66bb6a;
	}

	input:checked + .slider:before {
	transform: translateX(26px);
	}

	.slider.round {
	border-radius: 34px;
	}

	.slider.round:before {
	border-radius: 50%;
	}
</style>
<form method="POST" id="ftambah">
	<div class="panel-header p-3 shadow-sm">
		<button id="btn_back" class="btn btn-outline-primary mb-3"><i class="fa fa-arrow-left"></i> Kembali</button>
		<h6 class="text-primary">Asesmen</h6>
		<h3 class="mt-n2"><?= $ajm->nama ?></h3>
		<div class="progress" style="display: none;">
			<div class="progress-bar" role="progressbar" aria-label="Example with label" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		<div class="form-group row">
			<input type="hidden" name="a_jpenilaian_id" id="ia_jpenilaian_id" value="<?= $ajm->id ?>">
			<input type="hidden" name="stime" id="istime" value="<?= $stime ?? '' ?>">
			<!-- <input type="hidden" name="etime" id="ietime"> -->
			<?php if($type_form != 2) { ?>
				<div class="col-md-4">
					<label for="iuser">Nama</label>
					<input type="hidden" name="b_user_id" id="ib_user_id" value="<?= $cam->b_user_id ?? '' ?>">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Nama" aria-label="Nama" id="iuser" name="user" value="<?= $cam->b_user_name ?? '' ?>">
						<button class="btn btn-secondary" type="button" id="btn_cari_user">Cari</button>
					</div>
				</div>
			<?php } ?>
			<div class="col-md-4">
				<label for="ijabatan">Profesi</label>
				<div class="input-group">
					<select type="text" class="form-control select2" placeholder="Nama" id="ia_jabatan_id" name="a_jabatan_id">
						<?php if (isset($ajbm) && count($ajbm)) : ?>
							<?php foreach ($ajbm as $k => $v) : ?>
								<option value="<?= $v->id ?>" <?= isset($user->a_jabatan_id) && $v->id == $user->a_jabatan_id ? 'selected' : '' ?>><?= $v->nama ?></option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<label for="ia_ruangan_id">Ruangan/Unit</label>
				<select type="text" class="form-control select2" placeholder="Nama" id="ia_ruangan_id" name="a_ruangan_id">
					<?php if (isset($arm) && count($arm)) : ?>
						<?php foreach ($arm as $k => $v) : ?>
							<option value="<?= $v->id ?>" <?= isset($cam->a_ruangan_id) && $v->id == $cam->a_ruangan_id ? 'selected' : '' ?>><?= $v->nama ?></option>
						<?php endforeach ?>
					<?php endif ?>
				</select>
			</div>
			<div class="col-md-12">
				<label for="tgl_asesmen">Tanggal Asesmen</label>
				<input type="text" class="form-control" readonly placeholder="Tanggal Asesmen" value="<?= isset($cam->cdate) ? $cam->cdate : ''?>" name="cdate" id="tgl_asesmen">
			</div>
		</div>
	</div>

	<div class="panel-body p-3 row mb-5">
		<?php if ($type_form == 1) { ?>
			<?php for ($i = 0; $i < 10; $i++) : ?>
				<div class="col-md-1">
					<p class="nomor float-end"><?= $i + 1 ?></p>
				</div>
				<div class="col-md-11 row">
					<div class="col-md-6">
						<label for="iindikator">Indikator</label>
						<select type="text" class="form-control select2" placeholder="Indikator" id="ia_indikator_id_<?= $i ?>" name="a_indikator_id[]">
							<?php if (isset($aim) && count($aim)) : ?>
								<?php foreach ($aim as $k => $v) : ?>
									<?php if ($v->type == 'indikator') : ?>
										<option value="<?= $v->id ?>" <?= isset($value[$i]->indikator) && is_array($value) &&  $v->id == $value[$i]->indikator ? 'selected' : '' ?>><?= $v->nama ?></option>
									<?php endif ?>
								<?php endforeach ?>
							<?php endif ?>
						</select>
					</div>
					<div class="col-md-6">
						<label for="iindikator">Aksi</label>
						<?php if (isset($aim) && count($aim)) : ?>
							<?php foreach ($aim as $k => $v) : ?>
								<?php if ($v->type == 'aksi') : ?>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="a_aksi_id_<?= $i ?>" value="<?= $v->id ?>" id="ia_aksi_id_<?= $i ?>_<?= $v->id ?>" <?= isset($value[$i]->aksi) && is_array($value) &&  $v->id == $value[$i]->aksi ? 'checked' : '' ?>>
										<label class="form-check-label" for="ia_aksi_id_<?= $i ?>_<?= $v->id ?>">
											<?= $v->nama ?>
										</label>
									</div>
								<?php endif ?>
							<?php endforeach ?>
						<?php endif ?>
					</div>
				</div>
				<hr>
			<?php endfor ?>
		<?php } else if ($type_form == 2) { ?>
			<div class="col-md-12 transition">
				<div class="row">
					<div class="col-md-12 text-left" id="panel-judul">
						<h3>Indikator</h3>
					</div>
					<div class="d-flex justify-content-end" id="panel-filter"></div>

				</div>
				<div id="panel-form-2"></div>
				<?php if (isset($aim) && count($aim)) : ?>
					<?php //foreach($aim as $k => $v) : 
					?>
					<!-- <div class="card p-5 my-3 " >
							<h2><?php // $k 
								?></h2>
							<div class="d-flex flex-wrap">
								<?php //foreach($v as $k1 => $v1) : 
								?>
									<div class="card p-3 m-2 choice transition" data-id="<?php // $v1->id 
																							?>" id="<?php // $v1->id 
																									?>">
										<input type="hidden" id="aksi-<?php //$v1->id 
																		?>" name="">
										<h5><?php // $v1->nama 
											?></h5>
									</div>
								<?php // endforeach 
								?>
							</div>
						</div> -->
					<?php // endforeach 
					?>
				<?php endif ?>
			</div>
		<?php } else if($type_form == 3){?>
			<div class="col-md-12" id="panel-3">
				<?php //dd($aim); ?>
				<?php foreach ($aim as $k => $v) : ?>
					<?php if($v->type == "indikator") : ?>
						<div class="card p-3 mb-5" data-container="<?= $v->id ?>" id="card-data-<?= $v->id ?>">
								<div class="col-md-10 row">
									<div class="col-md-6  text-center">
										<h5><?= $v->nama ?></h5>
										
									</div>
									<div class="col-md-6">
										<label for="iindikator">Aksi</label>
										<?php if (isset($aim) && count($aim)) : ?>
											<?php foreach ($aim as $k1 => $v1) : ?>
												<?php if ($v1->type == 'aksi') : ?>
													<div class="row">
														<div class="form-group">
															<label class="switch" for="checkbox_<?= $v1->id ?>_<?= $v->id ?>">
															<h5><?= $v1->nama ?></h5>
																	<input type="checkbox" name="a_indikator_id[<?= $v->id ?>][<?= $v1->id ?>]" id="checkbox_<?= $v1->id ?>_<?= $v->id ?>" />
																	<div class="slider round"></div>
															</label>
														</div>
													</div>
												<?php endif ?>
											<?php endforeach ?>
										<?php endif ?>
									</div>
								</div>
						</div>
					<?php endif ?>
				<?php endforeach ?>
			</div>
		<?php } ?>
	</div>

	<div class="fixed-bottom row">
		<button type="submit" class="btn btn-success bg-accent float-end btn-submit"><i class="icon-submit"></i> <?= isset($id) ? 'Edit' : 'Simpan' ?></button>
	</div>

</form>