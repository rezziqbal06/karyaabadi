<!-- modal option -->
<div id="modal_option" class="modal fade " tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Aksi </h2>
				<h5 id="tvjabatan"></h5>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 btn-group-vertical">
						<!-- <a id="adetail" href="#" class="btn btn-info btn-left"><i class="fa fa-info-circle"></i> Detail</a> -->
						<a id="editprofil" href="#" class="btn btn-info bg-secondary btn-left"><i class="fa fa-pencil"></i> Edit Profil</a>
						<!-- <a id="areseller" href="#" class="btn btn-warning btn-left"><i class="fa fa-user"></i> Jadikan Reseller</a> -->
						<a id="changepass" href="#" class="btn btn-danger bg-primary btn-left"><i class="fa fa-key"></i> Ubah Password</a>
					</div>
				</div>
				<div class="row" style="margin-top: 1em; ">
					<div class="col-md-12" style="border-top: 1px #afafaf dashed;">&nbsp;</div>
					<div class="col-xs-12 btn-group-vertical" style="">
						<button type="button" class="btn btn-default btn-block text-left" data-dismiss="modal" id="btn_close_modal"><i class="fa fa-close"></i> Tutup</button>
					</div>
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>
</div>

<!-- modal edit -->
<div id="modal_edit_password" class="modal fade " tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Ubah Password</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<form action="" method="POST" id="fedit">
					<div class="row">
						<div class="form-group">
							<input type="hidden" name="id" id="ieid">
							<div class="col-md-12">
								<label for="old-pass">Password Lama</label>
								<input type="password" name="old_pass" class="form-control" id="old-pass">
							</div>
							<div class="row">
								<div class="col-md-6">
									<label for="ienama" class="control-label">Password Baru</label>
									<input id="ienama" type="password" name="nama" class="form-control" required>
								</div>
								<div class="col-md-6">
									<label for="ie_kd_ruangan" class="control-label">Confirm Password Baru</label>
									<input id="iekd_ruangan" type="password" name="kd_ruangan" class="form-control" required>
								</div>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top: 1em; ">
						<div class="col-md-12" style="border-top: 1px #afafaf dashed;">&nbsp;</div>
						<div class="col-xs-12 btn-group-vertical" style="">
							<button type="submit" class="btn btn-default btn-block text-left" data-dismiss="modal"><i class="fa fa-save"></i> Simpan</button>
						</div>
					</div>
				</form>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>
</div>

<!-- modal edit -->
<div id="modal_edit_profil" class="modal fade " tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Edit Profil</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<form action="" method="POST" id="fedit">
					<div class="row">
						<div class="form-group">
							<input type="hidden" name="id" id="ieid">
							<div class="row">
								<div class="col-md-6">
									<label for="ienama" class="control-label">Nama Depan</label>
									<input id="ienama" type="text" name="nama" class="form-control" required>
								</div>
								<div class="col-md-6">
									<label for="ie_kd_ruangan" class="control-label">Nama Belakang</label>
									<input id="iekd_ruangan" type="text" name="kd_ruangan" class="form-control" required>
								</div>
								
							</div>
							<div class="col-md-12">
								<label for="iedeskripsi" class="control-label">Deskripsi</label>
								<textarea name="deskripsi" id="iedeskripsi" class="form-control" cols="30" rows="10"></textarea>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top: 1em; ">
						<div class="col-md-12" style="border-top: 1px #afafaf dashed;">&nbsp;</div>
						<div class="col-xs-12 btn-group-vertical" style="">
							<button type="submit" class="btn btn-default btn-block text-left" data-dismiss="modal"><i class="fa fa-save"></i> Simpan</button>
						</div>
					</div>
				</form>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>
</div>