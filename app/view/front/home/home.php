<section>
	<div class=" mt-7">
		<!-- <h6 class="text-center">Dapatkan Kemudahan Layanan Kami</h6> -->
		<!-- <h2 class="text-center"><b class="text-primary">Percetakan</b> Kustom dengan <b class="text-primary">Mudah</b> dalam Sekali Genggaman</h2> -->

	</div>
</section>
<div id="banner" class="">
	<?php if (isset($abm) && count($abm)) : ?>
		<?php foreach ($abm as $k => $v) : ?>
			<div>
				<img src="<?= base_url("$v->gambar") ?>" class="d-block w-100" alt="<?= $v->slug ?>">
			</div>
		<?php endforeach ?>
	<?php endif ?>
</div>
<div class="carousel-indicators">
	<ul></ul>
</div>
<!-- List Produk Popular -->
<section class="p-3 p-md-5">
	<div class="row mt-5">
		<h4>Produk Populer</h4>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-6 p-3">
					<a href="<?= base_url("produk/") ?><?= $bpm_popular[0]->slug ?? '' ?>" class="kartu" title="<?= $bpm_popular[0]->nama ?? '' ?>">
						<div class="kartu-gambar">
							<img src="<?= base_url("") ?><?= $bpm_popular[0]->gambar ?? '' ?>" alt="<?= $bpm_popular[0]->nama ?? '' ?>" aria-describedby="<?= $bpm_popular[0]->nama ?? '' ?>">
						</div>
						<div class="kartu-caption text-center">
							<div class="kartu-caption-text"><?= $bpm_popular[0]->nama ?? '' ?></div>
						</div>
					</a>
				</div>
				<div class="col-md-6 p-3">
					<a href="<?= base_url("produk/") ?><?= $bpm_popular[1]->slug ?? '' ?>" class="kartu" title="<?= $bpm_popular[1]->nama ?? '' ?>">
						<div class="kartu-gambar">
							<img src="<?= base_url("") ?><?= $bpm_popular[1]->gambar ?? '' ?>" alt="<?= $bpm_popular[1]->nama ?? '' ?>" aria-describedby="<?= $bpm_popular[1]->nama ?? '' ?>">
						</div>
						<div class="kartu-caption text-center">
							<div class="kartu-caption-text"><?= $bpm_popular[1]->nama ?? '' ?></div>
						</div>
					</a>
				</div>
				<div class="col-md-12 p-3">
					<a href="<?= base_url("produk/") ?><?= $bpm_popular[2]->slug ?? '' ?>" class="kartu" title="<?= $bpm_popular[2]->nama ?? '' ?>">
						<div class="kartu-gambar">
							<img src="<?= base_url("") ?><?= $bpm_popular[2]->gambar ?? '' ?>" alt="<?= $bpm_popular[2]->nama ?? '' ?>" aria-describedby="<?= $bpm_popular[2]->nama ?? '' ?>">
						</div>
						<div class="kartu-caption text-center">
							<div class="kartu-caption-text"><?= $bpm_popular[2]->nama ?? '' ?></div>
						</div>
					</a>
				</div>
			</div>

		</div>
		<div class="col-md-6 p-3">
			<a href="<?= base_url("produk/") ?><?= $bpm_popular[3]->slug ?? '' ?>" class="kartu" title="<?= $bpm_popular[3]->nama ?? '' ?>">
				<div class="kartu-gambar">
					<img src="<?= base_url("") ?><?= $bpm_popular[3]->gambar ?? '' ?>" alt="<?= $bpm_popular[3]->nama ?? '' ?>" aria-describedby="<?= $bpm_popular[3]->nama ?? '' ?>">
				</div>
				<div class="kartu-caption text-center">
					<div class="kartu-caption-text"><?= $bpm_popular[3]->nama ?? '' ?></div>
				</div>
			</a>
		</div>
	</div>
</section>
<!-- List Produk -->
<section class="row p-3 p-md-5">
	<div class="col-md-4">&nbsp;</div>
	<div class="col-md-4">
		<div class="row text-center">
			<div class="col"><a href="#" class="btn-kategori text-bold text-primary" data-id="all">Semua</a></div>
			<?php if (isset($akm) && count($akm)) : ?>
				<?php foreach ($akm as $a) : ?>
					<div class="col"><a href="#" class="btn-kategori" data-id="<?= $a->id ?>" alt="<?= $a->nama ?>"><?= $a->nama ?></a></div>
				<?php endforeach ?>
			<?php endif ?>
		</div>
	</div>
	<div class="col-md-4">&nbsp;</div>
	<div class="col-md-12 mt-5">
		<div id="panel_produk" class="row">
			<?php if (isset($bpm) && count($bpm)) : ?>
				<?php foreach ($bpm as $produk) : ?>
					<div class="col-6 col-md-2 p-3 kartu-produk" data-kategori-id="<?= $produk->a_kategori_id ?>">
						<a href="<?= base_url("produk/") ?><?= $produk->slug ?>" class="btn-kategori" data-id="<?= $produk->id ?>" data-kategori-id="<?= $produk->a_kategori_id ?>" alt="<?= $produk->nama ?>">
							<div class="kartu-gambar-produk">
								<img src="<?= base_url("") ?><?= $produk->gambar ?? '' ?>" alt="<?= $produk->nama ?? '' ?>" aria-describedby="<?= $produk->nama ?? '' ?>" class="img-fluid">
							</div>
							<p class="text-center mt-3"><b><?= $produk->nama ?></b></p>
						</a>
					</div>
				<?php endforeach ?>
			<?php endif ?>
		</div>
	</div>
</section>