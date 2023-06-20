<!-- List Produk Popular -->
<section class="p-3 p-md-5">
	<div class="row">
		<div class="col-md-5 flex">
			<img id="display-gambar" class="w-100" src="<?= base_url($produk->gambar) ?>" data-zoom-image="<?= base_url($produk->gambar) ?>" alt="<?= $produk->nama ?>" style="border-radius:16px;">
			<?php if (isset($bpgm)) : ?>
				<div class=" mt-3 d-flex flex-row">
					<?php $i = 0; ?>
					<?php foreach ($bpgm as $k => $v) : ?>
						<a href="#" class="image-selected p-2" data-count="<?= $k ?>" class="p-2"><img id="gambar-item-<?= $k ?>" src="<?= base_url() . $v->gambar ?>" alt="Gambar <?= $produk->nama ?> <?= ($i + 1) ?>" height="100px" class="gambar-item rounded <?= $v->gambar == $produk->gambar ? 'selected' : '' ?>"></a>
						<?php $i++ ?>
					<?php endforeach ?>
				</div>
			<?php endif ?>
		</div>
		<div class="col-md-7">
			<form method="POST" id="fhitung">
				<p class="text-accent"><?= $akm->nama ?></p>
				<h3><b><?= $produk->nama ?></b></h3>
				<hr>
				<p class="text-grey" style="text-align:justify"><?= $produk->deskripsi ?></p>
				<input type="hidden" name="id" value="<?= $produk->id ?>" />
				<div class="row">
					<?php if (isset($produk->spesifikasi)) : ?>
						<?php $i = 0; ?>
						<?php foreach ($produk->spesifikasi as $k => $v) : ?>
							<?php if ($i != count((array)$produk->spesifikasi) - 1) : ?>
								<div class="col-md-3 mb-3 align-middle">
									<label for="" class="form-label "><?= $k ?></label>
								</div>
								<div class="col-md-9 mb-3">
									<select name="specs[]" id="spec<?= $i ?>" <?= count((array)$produk->spesifikasi) == 1 ? 'readonly' : '' ?> class="form-control hitung-spec kartu bg-light">
										<?php foreach ($v as $k2 => $v2) : ?>
											<option value="<?= $v2 ?>"><?= $v2 ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<?php $i++ ?>
							<?php endif ?>
						<?php endforeach ?>
					<?php endif ?>
				</div>

				<div class="row">
					<div class="col-12 mb-2">
						<h6 id="harga_peritem"></h6>
						<h3 id="harga_total" class="text-primary"></h3>
					</div>
					<div class="col-4">
						<div class="input-group">
							<a href="#" id="kurang" class="btn bg-secondary ">-</a>
							<input type="number" name="qty" min="1" class="form-control text-center" value="1">
							<a href="#" id="tambah" class="btn bg-secondary ">+</a>
						</div>
					</div>
					<div class="col-8 col-md-4 d-grid">
						<button type="submit" id="hitung" class="btn bg-success">Hitung</button>
					</div>
					<div class="col-md-4 d-grid">
						<button id="pesan" class="btn bg-accent" disabled>Pesan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

<section>
	<div id="" class="row p-5">
		<h3>Produk Terkait</h3>
		<?php if (isset($bpm_related) && count($bpm_related)) : ?>
			<?php foreach ($bpm_related as $pr) : ?>
				<div class="col-6 col-md-3 p-3 kartu-produk" data-kategori-id="<?= $pr->a_kategori_id ?>">
					<a href="<?= base_url("produk/") ?><?= $pr->slug ?>" class="" data-id="<?= $pr->id ?>" data-kategori-id="<?= $pr->a_kategori_id ?>" alt="<?= $pr->nama ?>">
						<div class="kartu-gambar-produk">
							<img src="<?= base_url("") ?><?= $pr->gambar ?? '' ?>" alt="<?= $pr->nama ?? '' ?>" aria-describedby="<?= $pr->nama ?? '' ?>" class="img-fluid">
						</div>
						<p class="text-center mt-3"><b><?= $pr->nama ?></b></p>
					</a>
				</div>
			<?php endforeach ?>
		<?php endif ?>
	</div>
</section>