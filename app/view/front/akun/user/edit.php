<div id="page-content">
	<!-- Static Layout Header -->
	<div class="content-header">
		<div class="row">
			<div class="col-md-12">
				<div class="btn-group">
					<a id="aback" href="<?= base_url_front('akun/user/') ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i> Kembali </a>
				</div>
			</div>
		</div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li>Akun</li>
		<li><a href="<?= base_url_front("akun/user/") ?>">Kustomer</a></li>
		<li>Edit #<?= $bum->id ?></li>
	</ul>
	<!-- END Static Layout Header -->

	<!-- Content -->
	<div class="block full">
		<div class="block-title">
			<h4><strong>Form Edit Data</strong></h4>
		</div>

		<form id="fedit" action="<?= base_url_front() ?>" method="post" enctype="multipart/form-data" class="form-bordered form-horizontal" onsubmit="return false;">
			<div class="form-group">
				<div class="col-md-6">
					<label for="ifnama" class="control-label">Nama Kustomer</label>
					<input type="text" name="fnama" id="ifnama" class="form-control" placeholder="Nama Kustomer">
					<input type="hidden" name="b_user_alamat_id" id="ib_user_alamat_id" class="form-control" value="<?= $buam->id ?? '' ?>">
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3">
					<label for="iis_active" class="control-label">IS Active</label>
					<select id="iis_active" name="is_active" class="form-control">
						<option value="1">Aktif</option>
						<option value="0">Tidak Aktif</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6">
					<label for="ialamat_select" class="control-label">Cari Alamat</label>
					<select id="ialamat_select" class="form-control select2"></select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-4">
					<label for="inegara">Negara *</label>
					<input id="inegara" class="form-control" name="negara" value="INDONESIA" required>
				</div>
				<div class="col-md-4">
					<label for="iprovinsi">Provinsi *</label>
					<input id="iprovinsi" class="form-control" name="provinsi" required>
				</div>
				<div class="col-md-4">
					<label for="ikabkota">Kabupaten / Kota *</label>
					<input id="ikabkota" class="form-control" name="kabkota" required>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-4">
					<label for="ikecamatan">Kecamatan *</label>
					<input id="ikecamatan" class="form-control" name="kecamatan" required>
				</div>
				<div class="col-md-4">
					<label for="ikelurahan">Desa / Kelurahan *</label>
					<input id="ikelurahan" class="form-control" name="kelurahan" required>
				</div>
				<div class="col-md-4">
					<label for="ialamat">Alamat *</label>
					<textarea id="ialamat" class="form-control" name="alamat" maxlength="30" required></textarea>
				</div>
				<div class="col-md-4">
					<label for="ialamat2">Alamat2</label>
					<textarea id="ialamat2" class="form-control" name="alamat2" maxlength="30"></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-4">
					<label for="ikodepos" class="control-label">Kodepos *</label>
					<input id="ikodepos" class="form-control " name="kodepos" placeholder="Kodepos" required>
				</div>
				<div class="col-md-4">
					<label for="ikode_origin" class="control-label">Kode Origin *</label>
					<input id="ikode_origin" class="form-control" name="kode_origin" placeholder="Kode Origin" readonly required>
				</div>
				<div class="col-md-4">
					<label for="ikode_destination" class="control-label">Kode Destination *</label>
					<input id="ikode_destination" class="form-control" name="kode_destination" placeholder="Kode Destination" readonly required>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-4">
					<label for="iitelp" class="control-label">Telepon</label>
					<input id="iitelp" type="number" class="form-control" name="telp" placeholder="Telepon Perusahaan" />
				</div>
				<div class="col-md-4">
					<label for="iemail" class="control-label">Email</label>
					<input id="iemail" type="email" class="form-control" name="email" placeholder="Email Perusahaan" />
				</div>
			</div>
			<div class="form-group form-actions">
				<div class="col-xs-12 text-right">
					<div class="btn-group pull-right">
						<button type="submit" class="btn btn-primary btn-submit">
							Simpan Perubahan <i class="fa fa-save icon-submit"></i>
						</button>
					</div>
				</div>
			</div>

		</form>
	</div>
</div>