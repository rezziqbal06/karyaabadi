<style>
	.select2 {
		width: 100% !important;
	}

	.multiple-select {
		border-radius: 4px;
	}

	/* .choices__list--multiple .choices__item {
		background-color: #ffc107;
		border: 1px solid #ffc107;
	} */

	.choices[data-type*=select-multiple] .choices__button,
	.choices[data-type*=text] .choices__button {
		border-left: 1px solid white;
	}
</style>
<div id="page-content">
	<!-- Static Layout Header -->
	<div class="content-header">
		<div class="row" style="">
			<div class="col-md-6"></div>
			<div class="col-md-6">
				<div class="btn-group pull-right">
					<a id="" type="button" href="history.back()" class="btn btn-primary btn-submit">Kembali</a>
				</div>
			</div>
		</div>
	</div>

	<form method="POST" id="ftambah">
		<!-- Content -->
		<div class="card">

			<div class="card-header">
				<h6><strong>Module - Jabatan: <?= $bum->fnama ?></strong></h6>
			</div>
			<div class="card-body">

				<input type="hidden" name="b_user_id" value="<?= $bum->id ?>">
				<?php if (isset($ajpm) && count($ajpm)) {
					foreach ($ajpm as $k => $v) { ?>
						<div class="row">
							<div class="col-md-8">
								<input type="hidden" name="a_jpenilaian_id[]" value="<?= $v->id ?>">
								<p><?= ($k + 1) ?>. <?= $v->nama ?></p>
							</div>
							<div class="col-md-4">
								<div class="form-check">
									<input class="form-check-input btn-all" type="checkbox" value="" id="all_<?= $v->id ?>" data-id="<?= $v->id ?>">
									<label class="form-check-label" for="all_<?= $v->id ?>">
										<b>all</b>
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input btn-module-<?= $v->id ?>" type="checkbox" value="read" name="type_<?= $v->id ?>[]" id="read_<?= $v->id ?>" data-id="<?= $v->id ?>" <?= isset($bumm["$v->id-read"]) ? 'checked' : '' ?>>
									<label class="form-check-label" for="read_<?= $v->id ?>">
										read
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input btn-module-<?= $v->id ?>" type="checkbox" value="create" name="type_<?= $v->id ?>[]" id="create_<?= $v->id ?>" data-id="<?= $v->id ?>" <?= isset($bumm["$v->id-create"]) ? 'checked' : '' ?>>
									<label class="form-check-label" for="create_<?= $v->id ?>">
										create
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input btn-module-<?= $v->id ?>" type="checkbox" value="edit" name="type_<?= $v->id ?>[]" id="edit_<?= $v->id ?>" data-id="<?= $v->id ?>" <?= isset($bumm["$v->id-edit"]) ? 'checked' : '' ?>>
									<label class="form-check-label" for="edit_<?= $v->id ?>">
										edit
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input btn-module-<?= $v->id ?>" type="checkbox" value="delete" name="type_<?= $v->id ?>[]" id="delete_<?= $v->id ?>" data-id="<?= $v->id ?>" <?= isset($bumm["$v->id-delete"]) ? 'checked' : '' ?>>
									<label class="form-check-label" for="delete_<?= $v->id ?>">
										delete
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input btn-module-<?= $v->id ?>" type="checkbox" value="chart" name="type_<?= $v->id ?>[]" id="chart_<?= $v->id ?>" data-id="<?= $v->id ?>" <?= isset($bumm["$v->id-chart"]) ? 'checked' : '' ?>>
									<label class="form-check-label" for="chart_<?= $v->id ?>">
										chart
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input btn-module-<?= $v->id ?>" type="checkbox" value="export" name="type_<?= $v->id ?>[]" id="export_<?= $v->id ?>" data-id="<?= $v->id ?>" <?= isset($bumm["$v->id-export"]) ? 'checked' : '' ?>>
									<label class="form-check-label" for="export_<?= $v->id ?>">
										export
									</label>
								</div>
							</div>
						</div>
						<hr>
				<?php }
				} ?>
				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn btn-success float-end">Simpan</button>
					</div>
				</div>
			</div>

		</div>
	</form>

</div>