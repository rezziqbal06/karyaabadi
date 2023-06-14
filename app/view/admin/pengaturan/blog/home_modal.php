<!-- modal option -->
<div id="modal_option" class="modal fade " tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Aksi </h2>
				<h5 id="t"></h5>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 btn-group-vertical">
						<!-- <a id="adetail" href="#" class="btn btn-info btn-left"><i class="fa fa-info"></i> Detail</a> -->
						<a id="aedit" href="#" class="btn btn-primary btn-left"><i class="fa fa-pencil"></i> Edit</a>
						<button id="bhapus" type="button" class="btn btn-danger btn-left btn-submit"><i class="fa fa-trash-o icon-submit"></i> Hapus</button>
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

<!-- modal tambah -->
<div id="modal_tambah" class="modal fade " tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-fullscreen">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Tambah</h2>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<form action="" method="POST" id="ftambah">
					<div class="row">
						<div class="form-group">
							<div class="row">
								<div class="col-md-4 mb-2">
									<label for="ijudul" class="control-label">Judul</label>
									<input id="ijudul" type="text" name="judul" class="form-control" required>
								</div>
								<div class="col-md-4 mb-2">
									<label for="islug" class="control-label">Slug</label>
									<input id="islug" type="text" name="slug" class="form-control" required>
								</div>
								<div class="col-md-4 mb-2">
									<label for="ikategori" class="control-label">Kategori</label>
									<input id="ikategori" type="text" name="kategori" class="form-control" required>
								</div>
								<!-- <div class="col-md-4 mb-2">
									<label for="itype" class="control-label">Tipe</label>
									<select id="itype" type="text" name="type" class="form-control" required>
										<option value="header" selected>header</option>
										<option value="promo">promo</option>
									</select>
								</div> -->
								<div class="col-md-6 mb-2">
									<label for="igambar" class="control-label">Gambar</label>
									<input id="igambar" type="file" name="gambar" class="form-control" required>
								</div>
								<div class="col-md-1 mb-2">
									<img id="img-igambar" src="" alt="" class="img-fluid rounded">
								</div>
								<div class="col-md-12 mb-2">
									<label for="itext" class="control-label">Text</label>
									<textarea name="text" id="itext" class="form-control" cols="30" rows="10"></textarea>
								</div>
								<div class="col-md-2 mb-2">
									<label for="iis_active" class="control-label">Status</label>
									<select name="is_active" id="iis_active" class="form-control">
										<option value="1">Aktif</option>
										<option value="0">Draft</option>
									</select>
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
<div id="modal_edit" class="modal fade " tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-fullscreen">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title">Edit</h2>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<form action="" method="POST" id="fedit">
					<div class="row">
						<div class="form-group">
							<input type="hidden" name="id" id="ieid">
							<div class="row">
								<div class="col-md-4 mb-2">
									<label for="iejudul" class="control-label">Judul</label>
									<input id="iejudul" type="text" name="judul" class="form-control" required>
								</div>
								<div class="col-md-4 mb-2">
									<label for="ieslug" class="control-label">Slug</label>
									<input id="ieslug" type="text" name="slug" class="form-control" required>
								</div>
								<div class="col-md-4 mb-2">
									<label for="iekategori" class="control-label">Kategori</label>
									<input id="iekategori" type="text" name="kategori" class="form-control" required>
								</div>
								<!-- <div class="col-md-4 mb-2">
									<label for="ietype" class="control-label">Tipe</label>
									<select id="ietype" type="text" name="type" class="form-control" required>
										<option value="header" selected>header</option>
										<option value="promo">promo</option>
									</select>
								</div> -->
								<div class="col-md-6 mb-2">
									<label for="iegambar" class="control-label">Gambar</label>
									<input id="iegambar" type="file" name="gambar" class="form-control">
								</div>
								<div class="col-md-1 mb-2">
									<img id="img-iegambar" src="" alt="" class="img-fluid rounded">
								</div>
								<div class="col-md-12 mb-2">
									<label for="ietext" class="control-label">Text</label>
									<textarea name="text" id="ietext" class="form-control" cols="30" rows="10"></textarea>
								</div>
								<div class="col-md-2 mb-2">
									<label for="ieis_active" class="control-label">Status</label>
									<select name="is_active" id="ieis_active" class="form-control">
										<option value="1">Aktif</option>
										<option value="0">Draft</option>
									</select>
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