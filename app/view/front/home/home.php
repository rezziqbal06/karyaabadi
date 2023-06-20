<section>
	<div class=" mt-7">

	</div>
</section>
<div id="banner" class="">
	<?php if (isset($abm) && count($abm)) : ?>
		<?php foreach ($abm as $k => $v) : ?>
			<a href="<?= base_url('banner/') . $v->slug ?>">
				<img src="<?= base_url("$v->gambar") ?>" class="d-block w-100" alt="<?= $v->nama ?>">
			</a>
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
<!-- List Kustomer -->
<section class="row p-3 p-md-5">
	<h4>Kustomer Kami</h4>
	<div id="kustomer" class="text-center align-middle">
		<?php if (isset($apm) && count($apm)) : ?>
			<?php foreach ($apm as $k => $v) : ?>
				<div class="m-2 text-center">
					<div class="kartu-partner">
						<img src="<?= base_url("$v->gambar") ?>" class="kartu-partner-gambar" alt="<?= $v->nama ?>">
					</div>
				</div>
			<?php endforeach ?>
		<?php endif ?>
	</div>
</section>
<!-- Fitur -->
<section class="row p-3 p-md-5">
	<div class="col-md-7 mb-3">
		<img src="<?= base_url("media/printing.png") ?>" class="img-fluid" alt="<?= $this->config->semevar->site_name ?>">
	</div>
	<div class="col-md-5 mb-3">
		<h6 class="">Dapatkan Kemudahan Layanan Kami</h6>
		<h2 class=""><b class="text-primary">Percetakan</b> Kustom dengan <b class="text-primary">Mudah</b> dalam Sekali Genggaman</h2>
		<p style="color:grey; text-justify: inter-word; text-align: justify">Percetakan Karya Abadi adalah sebuah perusahaan percetakan yang berpengalaman dan terpercaya, yang menyediakan layanan cetak berkualitas tinggi untuk kebutuhan bisnis dan personal.
			Dengan tim profesional yang ahli dalam desain grafis dan teknologi cetak modern,
			Percetakan Karya Abadi mampu menghasilkan berbagai produk dengan akurasi dan detail yang sempurna. Mereka menawarkan solusi cetak yang fleksibel, menyesuaikan dengan preferensi klien,
			serta memberikan pelayanan yang cepat, handal, dan tepat waktu.</p>
	</div>
	<div class="col-md-12 mb-3 mt-3">
		<?php $gambar_fitur = ["quality.png", "clock.png", "custom.png", "delivery.png", "calculator.png", "package.png"]; ?>
		<?php $text_fitur = ["Kualitas Produk Bersaing", "Waktu Produksi Cepat", "Desain Sesuai Keinginanmu", "Pengiriman Cepat dan Tepat", "Harga Transparan", "Kemasan Berkualitas"]; ?>
		<div class="row">
			<?php foreach ($gambar_fitur as $k => $v) : ?>
				<div class="text-center scale-up col-6 col-md-2 mb-3">
					<img src="<?= base_url("media/$v") ?>" alt="<?= $text_fitur[$k] ?>" width="30%" class="img-fluid">
					<p><?= $text_fitur[$k] ?></p>
				</div>
			<?php endforeach ?>
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