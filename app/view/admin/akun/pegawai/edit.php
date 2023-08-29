<div id="page-content">
	<!-- Static Layout Header -->
	<div class="content-header">
		<div class="row" style="">
			<div class="col-md-6">
				<div class="btn-group">
					<button type="button" onclick="history.back()" class="btn btn-info btn-submit"><i class="fa fa-arrow-left icon-submit"></i> Kembali</button>
				</div>
			</div>
			<div class="col-md-6">

			</div>
		</div>
	</div>

	<!-- Content -->
	<div class="card">

		<div class="card-header">
			<h6><strong><?= $this->getTitle() ?></strong></h6>
		</div>

		<div class="card-body">

			<form id="fedit" action="<?= base_url_admin() ?>" method="post" enctype="multipart/form-data" class="form-bordered form-horizontal" onsubmit="return false;">
				<div class="form-group row">

					<div class="col-md-4">
						<label for="ieis_active" class="control-label">Aktif?</label>
						<select id="ieis_active" name="is_active" class="form-control">
							<option value="1">Ya</option>
							<option value="0">Tidak</option>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-4">
						<label for="ienama" class="control-label">Nama Lengkap*</label>
						<input type="text" name="nama" id="ienama" class="form-control" placeholder="Nama" required>
					</div>
					<?php if (isset($jabatans) && count($jabatans)) { ?>
						<div class="col-md-4">
							<label for="iea_jabatan_id" class="control-label">Profesi</label>
							<select name="a_jabatan_id" id="iea_jabatan_id" class="form-control select2" required>
								<?php foreach ($jabatans as $jb) { ?>
									<option value="<?= $jb->id ?>"><?= $jb->nama ?></option>
								<?php } ?>
							</select>
						</div>
					<?php } ?>
					<div class="col-md-4">
						<label for="iea_jabatan_nama" class="control-label">Profesi*</label>
						<select name="a_jabatan_nama" id="iea_jabatan_nama" class="form-control select2" required>
							<option value="Sales">Sales</option>
						</select>
					</div>
					<div class="col-md-4">
						<label for="iekaryawan_status" class="control-label">Status Karyawan*</label>
						<select name="karyawan_status" id="iekaryawan_status" class="form-control select2" required>
							<option value="Kontrak">Kontrak</option>
							<option value="Tetap">Tetap</option>
							<option value="Magang">Magang</option>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-4">
						<label for="ietelp_hp" class="control-label">Telepon*</label>
						<input id="ietelp_hp" type="number" class="form-control" name="telp_hp" placeholder="Telepon" require />
					</div>
					<div class="col-md-4">
						<label for="iependidikan_terakhir" class="control-label">Pendidikan Terakhir</label>
						<select name="pendidikan_terakhir" id="iependidikan_terakhir" class="form-control select2">
							<option value="S1">S1</option>
							<option value="SMA">SMA</option>
							<option value="SMP">SMP</option>
							<option value="SD">SD</option>
						</select>
					</div>
					<div class="col-md-4">
						<label for="ietgl_kerja_mulai" class="control-label">Tanggal Mulai Kerja</label>
						<input id="ietgl_kerja_mulai" type="text" class="form-control datepicker" name="tgl_kerja_mulai" placeholder="Mulai Kerja" />
					</div>
					<!-- <div class="col-md-4">
                        <label for="ieemail" class="control-label">Email</label>
                        <input id="ieemail" type="email" class="form-control" name="email" placeholder="Email" />
                    </div> -->
					<!-- <div class="col-md-4">
                        <label for="ieusername" class="control-label">Username</label>
                        <input id="ieusername" type="username" class="form-control" name="username" placeholder="Username" />
                    </div> -->
					<!-- <div class="col-md-4">
                        <label for="iepassword" class="control-label">Password</label>
                        <input id="iepassword" type="password" class="form-control" name="password" value="123456" placeholder="password" />
                    </div> -->
				</div>

				<div class="form-group row">
					<div class="col-md-4">
						<label for="iebank_rekening_nomor" class="control-label">Nomor Rekening</label>
						<input type="text" name="bank_rekening_nomor" id="iebank_rekening_nomor" class="form-control" placeholder="Nomor Rekening">
					</div>
					<div class="col-md-4">
						<label for="iebank_rekening_nama" class="control-label">Rekening Atas Nama</label>
						<input type="text" name="bank_rekening_nama" id="iebank_rekening_nama" class="form-control" placeholder="Rekening Atas Nama">
					</div>
					<div class="col-md-4">
						<label for="iebank_nama" class="control-label">Nama Bank</label>
						<input type="text" name="bank_nama" id="iebank_nama" class="form-control" placeholder="Ex: BSI">
					</div>
				</div>

				<!-- <div class="form-group row">
                    <div class="col-md-6">
                        <label for="iealamat_select" class="control-label">Cari Alamat</label>
                        <select id="iealamat_select" class="form-control select2"></select>
                    </div>
                </div> -->
				<!-- <div class="form-group row">
                    <div class="col-md-4">
                        <label for="ieprovinsi">Provinsi</label>
                        <select id="ieprovinsi" class="form-control" name="provinsi"></select>
                    </div>
                    <div class="col-md-4">
                        <label for="iekabkota">Kabupaten / Kota</label>
                        <select id="iekabkota" class="form-control" name="kabkota"></select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="iekecamatan">Kecamatan</label>
                        <select id="iekecamatan" class="form-control" name="kecamatan"></select>
                    </div>
                    <div class="col-md-4">
                        <label for="iekelurahan">Desa / Kelurahan</label>
                        <select id="iekelurahan" class="form-control" name="kelurahan"></select>
                    </div>
                    <div class="col-md-4">
                        <label for="iekodepos" class="control-label">Kodepos</label>
                        <input id="iekodepos" class="form-control " name="kodepos" placeholder="Kodepos">
                    </div>
                    <div class="col-md-6">
                        <label for="iealamat">Alamat</label>
                        <textarea id="iealamat" class="form-control" name="alamat" maxlength="30"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="iealamat2">Alamat2</label>
                        <textarea id="iealamat2" class="form-control" name="alamat2" maxlength="30"></textarea>
                    </div>
                </div>
                <div class="form-group row">

                </div> -->
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

</div>