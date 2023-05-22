<div id="page-content">
	<!-- Static Layout Header -->
	<div class="content-header">
		<div class="row">
			<div class="col-md-6">
				<div class="btn-group">
					<a id="" href="<?= base_url_admin('akun/user/') ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i> Kembali</a>
				</div>
			</div>
			<div class="col-md-6">
				<div class="btn-group pull-right">
					<a id="" href="<?= base_url_admin('akun/user/edit/' . $bum->id) ?>" class="btn btn-info"><i class="fa fa-edit"></i> Edit</a>
				</div>
			</div>
		</div>
	</div>
	<ul class="breadcrumb breadcrumb-top">
		<li>Admin</li>
		<li>Akun</li>
		<li><a href="<?= base_url_admin("akun/user/") ?>">Member</a></li>
		<li>Detail #<?= $bum->id ?></li>
	</ul>
	<!-- END Static Layout Header -->

	<div class="block full">
		<div class="block-title">
			<h4><strong>Informasi Detail</strong></h4>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<th class="col-md-2">Nama</th>
							<td class="col-md-1">:</td>
							<td><?= $bum->fnama ?></td>
						</tr>
						<tr>
							<th>Kode</th>
							<td>:</td>
							<td><?= $bum->kode ?></td>
						</tr>
						<tr>
							<th>Alamat</th>
							<td>:</td>
							<td>
								<?= $this->__($buam, 'alamat') ?><br />
								<?= $this->__($buam, 'alamat2') ?><br />
								<?= $this->__($buam, 'kelurahan') ?>
								<?= $this->__($buam, 'kecamatan') ?><br />
								<?= $this->__($buam, 'kabkota') ?>
								<?= $this->__($buam, 'provinsi') ?><br />
								<?= $this->__($buam, 'negara') ?>
								<?= $this->__($buam, 'kodepos') ?>
							</td>
						</tr>
						<tr>
							<th>Kode Origin</th>
							<td>:</td>
							<td><?= $this->__($buam, 'kode_origin') ?></td>
						</tr>
						<tr>
							<th>Kode Destination</th>
							<td>:</td>
							<td><?= $this->__($buam, 'kode_destination') ?></td>
						</tr>
						<tr>
							<th>Email</th>
							<td>:</td>
							<td><?= $this->__($bum, 'email') ?></td>
						</tr>
						<tr>
							<th>Telp</th>
							<td>:</td>
							<td><?= $this->__($bum, 'telp') ?></td>
						</tr>
						<tr>
							<th>Status</th>
							<td>:</td>
							<td><?= !empty($this->__($bum, 'is_active', 0)) ? '<label class="label label-success">Aktif</label>' : '<label class="label label-default">Tidak Aktif</label>' ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>