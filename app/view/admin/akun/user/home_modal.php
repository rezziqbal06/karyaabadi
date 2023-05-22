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
						<!-- <a id="adetail" href="#" class="btn btn-info btn-left"><i class="fa fa-info-circle"></i> Detail</a> -->
						<a id="aedit" href="#" class="btn btn-primary btn-left"><i class="fa fa-pencil"></i> Edit</a>
						<!-- <a id="amodule" href="#" class="btn btn-warning btn-left"><i class="fa fa-gear"></i> Module</a> -->
						<!-- <a id="aresetpass" href="#" class="btn btn-danger bg-primary btn-left"><i class="fa fa-key"></i> Reset Password</a> -->
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
				<form action="" method="POST" id="fchange-password">
					<div class="row">
						<div class="form-group">
							<input type="hidden" name="id" id="ieid-user" value="<?= $ue->id ?? '' ?>">
							<!-- <div class="col-md-12">
								<label for="old-pass">Password Lama</label>
								<input type="password" name="old_pass" class="form-control" id="old-pass">
							</div> -->
							<div class="row">
								<div class="col-md-6">
									<label for="new-pass" class="control-label">Password Baru</label>
									<input id="new-pass" type="password" name="new_pass" class="form-control" required>
								</div>
								<div class="col-md-6">
									<label for="confirm-new-pass" class="control-label">Confirm Password Baru</label>
									<input id="confirm-new-pass" type="password" name="confirm_new_pass" class="form-control" required>
								</div>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top: 1em; ">
						<div class="col-md-12" style="border-top: 1px #afafaf dashed;">&nbsp;</div>
						<div class="col-xs-12 btn-group-vertical" style="">
							<button type="" id="breset" class="btn btn-dark btn-block text-left" data-dismiss="modal"><i class="fa fa-rotate"></i> Reset</button>
							<button type="submit" class="btn btn-success btn-block text-left" data-dismiss="modal"><i class="fa fa-save"></i> Simpan</button>
						</div>
					</div>
				</form>
				<!-- END Modal Body -->
			</div>
		</div>
	</div>
</div>