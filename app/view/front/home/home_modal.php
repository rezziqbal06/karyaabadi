<!-- modal filter -->
<div id="modal_filter" class="modal fade" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Filter</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<form action="" method="POST" id="ffilter_modal">
					<div class="row">
						<div class="form-group">
							<!-- <input type="hidden" name="b_user_id_penilai" value="<?= $sess->user->id ?>" id="ib_user_id_penilai"> -->
							<div id="" class="col-md-12 panel_b_user_id_penilai" style="display:none">
								<label for="im_b_user_id_penilai">Penilai</label>
								<select class="form-control select2" style="width: 100%;" name="b_user_id_penilai" id="im_b_user_id_penilai">
									<option value="">-- Pilih Penilai --</option>
									<?php foreach ($bum as $k => $v) : ?>
										<option value="<?= $v->id ?>"><?= $v->fnama ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div id="" class="col-md-12 panel_b_user_id">
								<label for="im_b_user_id">Nama</label>
								<select class="form-control select2" style="width: 100%;" name="b_user_id" id="im_b_user_id">
									<option value="">-- Pilih Nama --</option>
									<?php foreach ($bum as $k => $v) : ?>
										<option value="<?= $v->id ?>"><?= $v->fnama ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-md-12">
								<label for="im_a_ruangan_id">Ruangan</label>
								<select class="form-control select2" style="width: 100%;" name="a_ruangan_id" id="im_a_ruangan_id">
									<option value="">-- Pilih Ruangan --</option>
									<?php foreach ($arm as $k => $v) : ?>
										<option value="<?= $v->id ?>"><?= $v->nama ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<hr>
							<div class="panel_tgl">
								<div class="col-md-12">
									<label for="im_sdate">Dari Tanggal</label>
									<input type="date" class="form-control date-picker" name="sdate" id="im_sdate">
								</div>
								<div class="col-md-12">
									<label for="im_edate">Sampai Tanggal</label>
									<input type="date" class="form-control date-picker" name="edate" id="im_edate">
								</div>
							</div>
							<div class="panel_bulan">
								<div class="col-md-12">
									<label for="im_edate">Sampai Tanggal</label>
									<select name="bulan" id="im_bulan" class="form-control select2">
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
							</div>

						</div>
					</div>
					<div class="row" style="margin-top: 1em; ">
						<div class="col-xs-12 btn-group-vertical" style="">
							<button type="submit" class="btn btn-primary btn-block text-left" data-dismiss="modal"><i class="fa fa-filter"></i> Filter</button>
							<button id="btn_print_modal" class="btn btn-secondary btn-block text-left"><i class="fa fa-print"></i> Print</button>
						</div>
					</div>
				</form>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>
</div>