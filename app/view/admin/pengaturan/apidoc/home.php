<div id="page-content">
	<!-- Static Layout Header -->
	<div class="content-header">
		<div class="row">
			<div class="col-md-6">&nbsp;</div>
			<div class="col-md-6">
				<div class="btn-group pull-right">
					<a id="atambah" href="" class="btn btn-info"><i class="fa fa-plus"></i> Baru</a>
				</div>
			</div>
		</div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li>Admin</li>
		<li>Pengaturan</li>
		<li>Dokumentasi API</li>
	</ul>
	<!-- END Static Layout Header -->

	<!-- Content -->
	<div class="block full">
		<div class="block-title">
			<h4><strong>Data Dokumentasi API</strong></h4>
		</div>

		<div class="row row-filter">
			<div class="col-md-8">
				&nbsp;
			</div>
			<div class="col-md-2">
				<label>Status</label>
				<select id="fl_is_active" class="form-control">
					<option value="">-- Semua --</option>
					<option value="1">Aktif</option>
					<option value="0">Tidak Aktif</option>
				</select>
			</div>
			<div class="col-md-2">
				<br />
				<div class="btn-group">
					<?php $this->getThemeElement('page/components/filter_button', $__forward); ?>
				</div>
			</div>
		</div>

		<div class="table-responsive">
			<table id="drTable" class="table table-vcenter table-condensed table-bordered">
				<thead>
					<?= $this->aam->datatable()->table_headers() ?>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>

	</div>
	<!-- END Content -->
</div>