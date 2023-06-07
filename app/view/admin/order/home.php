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
					<button id="atambah" type="button" class="btn btn-info btn-submit"><i class="fa fa-plus icon-submit"></i> Baru</button>
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

			<div class="table-responsive">
				<table id="drTable" class="table table-vcenter table-hover">
					<thead>
						<?= $this->com->datatable()->table_headers() ?>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>

	</div>

</div>