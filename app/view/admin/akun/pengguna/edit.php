<div id="page-content">
	<!-- Static Layout Header -->
	<div class="content-header">
		<div class="row" style="padding: 0.5em 2em;">
			<div class="col-md-6"></div>
			<div class="col-md-6 d-none">
				<div class="btn-group pull-right">
					<a id="atambah" href="#" class="btn btn-info"><i class="fa fa-plus"></i> Baru</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Content -->
	<div class="card">

		<div class="card-header">
			<h6><strong><?= $this->getTitle() ?></strong></h6>
		</div>

		<div class="card-body">

			<form action="" method="POST" id="fprofil">
				<div class="row">
					<div class="form-group">
						<div class="row">
							<div class="col-md-4 mb-2">
								<label for="iprofil_nama" class="control-label">Nama</label>
								<input id="iprofil_nama" type="text" name="nama" class="form-control" required>
							</div>
							<div class="col-md-4 mb-2">
								<label for="iprofil_username" class="control-label">Username</label>
								<input id="iprofil_username" type="text" name="username" class="form-control" required>
							</div>
							<div class="col-md-4 mb-2">
								<label for="iprofil_email" class="control-label">Email</label>
								<input id="iprofil_email" type="text" name="email" class="form-control">
							</div>
							<div class="col-md-6 mb-2">
								<label for="iprofil_gambar" class="control-label">Gambar</label>
								<input id="iprofil_gambar" type="file" name="gambar" accept=".png,.jpg,.jpeg" class="form-control">
							</div>
							<div class="col-6 mb-2">
								<img id="img-iprofil_gambar" src="" alt="" class="img-fluid rounded">
							</div>

						</div>
						<div class="row mt-3">
							<div class="col-3 col-md-4">
								<hr>
							</div>
							<div class="col-6 col-md-4 text-center">
								<p>Update Password</p>
							</div>
							<div class="col-3 col-md-4">
								<hr>
							</div>
							<div class="col-md-12 mb-2">
								<label for="iprofil_new_password" class="control-label">Password Baru</label>
								<input id="iprofil_new_password" type="password" name="new_password" class="form-control">
							</div>
							<div class="col-md-12 mb-2">
								<label for="iprofil_re_password" class="control-label">Ulang Password</label>
								<input id="iprofil_re_password" type="password" name="re_password" class="form-control">
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
		</div>

	</div>

	<!-- END Content -->
</div>