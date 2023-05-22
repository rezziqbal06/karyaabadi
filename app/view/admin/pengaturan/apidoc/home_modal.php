<!-- modal option -->
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
					<div class="col-xs-12 btn-group-vertical">
						<a id="aedit" href="#" class="btn btn-info btn-left"><i class="fa fa-pencil"></i> Edit</a>
						<button id="bhapus" type="button" class="btn btn-danger btn-left btn-submit"><i class="fa fa-trash-o icon-submit"></i> Hapus</button>
					</div>
				</div>
				<div class="row" style="margin-top: 1em; ">
					<div class="col-md-12" style="border-top: 1px #afafaf dashed;">&nbsp;</div>
					<div class="col-xs-12 btn-group-vertical" style="">
						<button type="button" class="btn btn-default btn-block text-left" data-dismiss="modal"><i class="fa fa-trash"></i> Tutup</button>
					</div>
				</div>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>
</div>

<!-- modal tambah -->
<div id="modal_tambah" class="modal fade " tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Tambah Dokumentasi API</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<form action="" method="POST" id="ftambah">
					<div class="row">
						<div class="form-group">
							<div class="col-md-4">
								<label for="inama" class="control-label">Nama</label>
								<input id="inama" type="text" name="nama" class="form-control" required>
							</div>
							<div class="col-md-4">
								<label for="ivendor" class="control-label">Vendor</label>
								<input id="ivendor" type="text" name="vendor" placeholder="ex: jne" class="form-control" required>
							</div>
							<div class="col-md-4">
								<label for="itype" class="control-label">Tipe</label>
								<input id="itype" type="text" name="type" placeholder="Untuk URL Dokumentasi" class="form-control">
							</div>
							<label for="url"></label>
							<hr>
							<div class="col-md-6">
								<label for="iurl_sandbox" class="control-label">Sandbox</label>
								<input id="iurl_sandbox" type="text" name="url_sandbox" class="form-control">
							</div>
							<div class="col-md-6">
								<label for="iurl_live" class="control-label">Live</label>
								<input id="iurl_live" type="text" name="url_live" class="form-control">
							</div>
							<div class="col-md-12">
								<label for="iheader" class="control-label">Header</label>
								<textarea id="iheader" type="text" name="header" class="form-control json-value" rows="5"></textarea>
							</div>
							<div class="col-md-12">
								<label for="ibody" class="control-label">Body</label>
								<textarea id="ibody" type="text" name="body" class="form-control json-value" rows="15"></textarea>
							</div>
							<div class="col-md-6">
								<label for="iresponse_ok" class="control-label">Response OK</label>
								<textarea id="iresponse_ok" type="text" name="response_ok" class="form-control json-value" rows="10"></textarea>
							</div>
							<div class="col-md-6">
								<label for="iresponse_error" class="control-label">Response Error</label>
								<textarea id="iresponse_error" type="text" name="response_error" class="form-control json-value" rows="10"></textarea>
							</div>
							<div class="col-md-6">
								<label for="iis_active" class="control-label">Status</label>
								<select id="iis_active" type="text" name="is_active" class="form-control" rows="5">
									<option value="1">Aktif</option>
									<option value="0">Draft</option>
								</select>
							</div>
							<div class="col-md-6">
								<label for="btn_prettying" class="control-label">Action</label>
								<input class="btn btn-info btn_prettying form-control" value="Format JSON">
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
<div id="modal_edit" class="modal fade " tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Edit Dokumentasi API</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<form action="" method="POST" id="fedit">
					<div class="row">
						<div class="form-group">
							<div class="col-md-4">
								<label for="ienama" class="control-label">Nama</label>
								<input id="ienama" type="text" name="nama" class="form-control" required>
							</div>
							<div class="col-md-4">
								<label for="ievendor" class="control-label">Vendor</label>
								<input id="ievendor" type="text" name="vendor" placeholder="ex: jne" class="form-control" required>
							</div>
							<div class="col-md-4">
								<label for="ietype" class="control-label">Tipe</label>
								<input id="ietype" type="text" name="type" placeholder="Untuk URL Dokumentasi" class="form-control">
							</div>
							<label for="url"></label>
							<hr>
							<div class="col-md-6">
								<label for="ieurl_sandbox" class="control-label">Sandbox</label>
								<input id="ieurl_sandbox" type="text" name="url_sandbox" class="form-control">
							</div>
							<div class="col-md-6">
								<label for="ieurl_live" class="control-label">Live</label>
								<input id="ieurl_live" type="text" name="url_live" class="form-control">
							</div>
							<div class="col-md-12">
								<label for="ieheader" class="control-label">Header</label>
								<textarea id="ieheader" type="text" name="header" class="form-control json-value" rows="5"></textarea>
							</div>
							<div class="col-md-12">
								<label for="iebody" class="control-label">Body</label>
								<textarea id="iebody" type="text" name="body" class="form-control json-value" rows="15"></textarea>
							</div>
							<div class="col-md-6">
								<label for="ieresponse_ok" class="control-label">Response OK</label>
								<textarea id="ieresponse_ok" type="text" name="response_ok" class="form-control json-value" rows="10"></textarea>
							</div>
							<div class="col-md-6">
								<label for="ieresponse_error" class="control-label">Response Error</label>
								<textarea id="ieresponse_error" type="text" name="response_error" class="form-control json-value" rows="10"></textarea>
							</div>
							<div class="col-md-6">
								<label for="ieis_active" class="control-label">Status</label>
								<select id="ieis_active" type="text" name="is_active" class="form-control" rows="5">
									<option value="1">Aktif</option>
									<option value="0">Draft</option>
								</select>
							</div>
							<div class="col-md-6">
								<label for="btn_prettying" class="control-label">Action</label>
								<input class="btn btn-info btn_prettying form-control" value="Format JSON">
							</div>
						</div>
					</div>
					<div class="row" style="margin-top: 1em; ">
						<div class="col-md-12" style="border-top: 1px #afafaf dashed;">&nbsp;</div>
						<div class="col-xs-12 btn-group-vertical" style="">
							<button type="submit" class="btn btn-default btn-block text-left"><i class="fa fa-save"></i> Edit</button>
						</div>
					</div>
				</form>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>
</div>