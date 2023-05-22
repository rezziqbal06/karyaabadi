<!-- modal tambah -->
<div id="modal_tambah" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Tambah</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<form id="ftambah" action="<?=base_url(); ?>" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered">
					<fieldset>
						<div class="form-group">
							<label class="col-md-4 control-label" for="iusername">Username*</label>
							<div class="col-md-8">
								<input id="iusername" type="text" name="username" class="form-control" minlength="2" maxlength="" placeholder="" required />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="inama">Nama</label>
							<div class="col-md-8">
								<input id="inama" type="text" name="nama" class="form-control" minlength="1" placeholder="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="iemail">Email*</label>
							<div class="col-md-8">
								<input id="iemail" type="text" name="email" class="form-control" minlength="1" placeholder="" required />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="ipassword">Password*</label>
							<div class="col-md-8">
								<input id="ipassword" type="password" name="password" class="form-control" minlength="1" placeholder="" required />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="irepassword">Re-Password*</label>
							<div class="col-md-8">
								<input id="irepassword" type="password" class="form-control" minlength="1" placeholder="" required />
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-4 control-label" for="iis_active">Status*</label>
							<div class="col-md-8">
								<select id="iis_active" name="is_active" class="form-control" required>
									<option value="1">Aktif</option>
									<option value="0">Tidak Aktif</option>
								</select>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="modal-body">
							<label class="col-md-4 control-label" for="iprofil_foto">Foto*</label>
							<div class="col-md-8">
								<input id="iprofil_foto" type="file" name="foto" class="form-control" />
							</div>
						</div>
					</fieldset>
					<div class="form-group form-actions">
						<div class="col-xs-12 text-right">
							<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
							<input id=btambah_submit"" type="submit" value="simpan" class="btn btn-sm btn-primary" />
						</div>
					</div>
				</form>
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>

<!-- modal edit -->
<div id="modal_edit" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Edit</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<form id="fedit" action="<?=base_url(); ?>" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onsubmit="return false;">
					<fieldset>
						<input type="hidden" id="ieid1" name="id" value="" />
						<div class="form-group">
							<label class="col-md-4 control-label" for="ieusername">Username*</label>
							<div class="col-md-8">
								<input id="ieusername" type="text" name="username" class="form-control" minlength="2" maxlength="" placeholder="" required />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="ieemail">Email*</label>
							<div class="col-md-8">
								<input id="ieemail" type="text" name="email" class="form-control" minlength="1" placeholder="" required />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="ienama">Nama</label>
							<div class="col-md-8">
								<input id="ienama" type="text" name="nama" class="form-control" minlength="1" placeholder="" />
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="form-group">
							<label class="col-md-4 control-label" for="ieis_active">Status*</label>
							<div class="col-md-8">
								<select id="ieis_active" name="is_active" class="form-control" required>
									<option value="1">Aktif</option>
									<option value="0">Tidak Aktif</option>
								</select>
							</div>
						</div>
					</fieldset>
					<div class="form-group form-actions">
						<div class="col-xs-12 text-right">
							<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
							<button id="bhapus" type="button" class="btn btn-sm btn-warning">Hapus</button>
							<button type="submit" class="btn btn-sm btn-primary">Simpan Perubahan</button>
						</div>
					</div>
				</form>
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>

<!-- modal edit welcome message -->
<div id="modal_edit_wm" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Edit Welcome Message</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<form id="fedit_wm" action="<?=base_url(); ?>" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onsubmit="return false;">
					<fieldset>
						<input type="hidden" id="ieid2" name="id" value="" />
						<div class="form-group">
							<label class="col-md-4 control-label" for="iewelcome_message">Welcome Message*</label>
							<div class="col-md-8">
								<input id="iewelcome_message" type="text" name="welcome_message" class="form-control" minlength="" maxlength="" placeholder="" required />
							</div>
						</div>
					</fieldset>
					<div class="form-group form-actions">
						<div class="col-xs-12 text-right">
							<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-sm btn-primary">Simpan Perubahan</button>
						</div>
					</div>
				</form>
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>

<!--modal edit password-->
<div id="modal_edit_password" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Edit Password</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<form id="feditpass" action="<?=base_url(); ?>" method="post" enctype="multipart/form-data" class="form-horizontal form-bordered" onsubmit="return false;">
					<fieldset>
						<input type="hidden" id="ieid3" name="id" value="" />
						<div class="form-group">
							<label class="col-md-4 control-label" for="inewpassword">Password*</label>
							<div class="col-md-8">
								<input id="inewpassword" type="password" name="password" class="form-control" minlength="1" placeholder="" required />
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="irepassword">Re-Password*</label>
							<div class="col-md-8">
								<input id="irenewpassword" type="password" class="form-control" minlength="1" placeholder="" required />
							</div>
						</div>
					</fieldset>
					<div class="form-group form-actions">
						<div class="col-xs-12 text-right">
							<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-sm btn-primary">Simpan Perubahan</button>
						</div>
					</div>
				</form>
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>

<!--Modal Option-->
<div id="modal_option" class="modal fade " tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Pilihan</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 btn-group-vertical ">
						<a id="aedit" href="#" class="btn btn-info text-left" style="text-align: left;"><i class="fa fa-pencil"></i> Edit Profil</a>
						<a id="aedit_password" href="#" class="btn btn-info text-left" style="text-align: left;"><i class="fa fa-pencil"></i> Edit Password</a>
						<a id="bprofil_foto" href="#" class="btn btn-info text-left" style="text-align: left;"><i class="fa fa-pencil"></i> Edit Foto</a>
						<a id="aedit_wm" href="#" class="btn btn-info text-left" style="text-align: left;"><i class="fa fa-pencil"></i> Edit Welcome Message</a>
						<a id="ahak_akses" href="#" class="btn btn-info text-left" style="text-align: left;"><i class="fa fa-key"></i> Hak Akses</a>
						<button id="ahapus" type="button" class="btn btn-danger text-left" style="text-align: left;"><i class="fa fa-trash-o"></i> Hapus</button>
					</div>
				</div>
				<div class="row" style="margin-top: 1em; ">
					<div class="col-md-12" style="border-top: 1px #afafaf dashed;">&nbsp;</div>
					<div class="col-xs-12 btn-group-vertical" style="">
						<button type="button" class="btn btn-default btn-block text-left" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
					</div>
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>
</div>

<!--modal foto-->
<div id="modal_profil_foto" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Ganti Foto</h2>
			</div>
			<!-- END Modal Header -->

			<div class="modal-body">
				<form id="fmodal_profil_foto" method="post" enctype="multipart/form-data" action="<?=base_url('akun/pengguna/edit_foto')?>">
					<div class="form-group">
						<input id="ieprofil_foto" type="file" name="foto" class="form-control" required />
					</div>
					<div class="form-group">
						<input type="submit" value="Submit" class="btn btn-primary" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!--modal hak akses-->
<div id="modal_hak_akses" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Hak Akses <span id="nama_access"></span></h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<form id="fmodal_hak_akses" method="post" enctype="multipart/form-data" action="<?=base_url('akun/pengguna/hak_akses/')?>">
					<table width="100%" cellpadding="0" cellspacing="0">
						<?=$access;?>
					</table>
					<input type="hidden" id="id_access" name="a_pengguna_id" />
				</form>
			</div>
			<!-- END Modal Body -->

			<!-- Modal Footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Tutup</button>
				<button type="button" id="btambah_access" class="btn btn-sm btn-primary">Simpan</button>
			</div>
			<!-- END Modal Footer -->
		</div>
	</div>
</div>
