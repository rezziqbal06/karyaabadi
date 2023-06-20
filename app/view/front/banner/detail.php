<style>
	a {
		color: var(--accent);
		text-decoration: dotted;
	}

	a:hover {
		color: var(--accent);
		text-decoration: dotted;
	}
</style>
<!-- List banner Popular -->
<section class="p-3 p-md-5">
	<div class="row">
		<div class="col-md-5 flex text-center">
			<img id="display-gambar" class="w-100" src="<?= base_url($banner->gambar) ?>" data-zoom-image="<?= base_url($banner->gambar) ?>" alt="<?= $banner->nama ?>" style="border-radius:16px;">
		</div>
		<div class="col-md-7">
			<form method="POST" id="fhitung">
				<h3><b><?= $banner->nama ?></b></h3>
				<hr>
				<p class="text-grey" style="text-align:justify"><?= $banner->deskripsi ?></p>
				<input type="hidden" name="id" value="<?= $banner->id ?>" />
			</form>
		</div>
	</div>
</section>

<section>
	<div id="" class="row p-5">
		<h3>Lainnya</h3>
		<?php if (isset($banner_lainnya) && count($banner_lainnya)) : ?>
			<?php foreach ($banner_lainnya as $pr) : ?>
				<div class="col-6 col-md-3 p-3 kartu-banner">
					<a href="<?= base_url("banner/") ?><?= $pr->slug ?>" class="" data-id="<?= $pr->id ?>" alt="<?= $pr->nama ?>">
						<div class="kartu-gambar-banner">
							<img src="<?= base_url("") ?><?= $pr->gambar ?? '' ?>" alt="<?= $pr->nama ?? '' ?>" aria-describedby="<?= $pr->nama ?? '' ?>" class="img-fluid rounded">
						</div>
						<p class="text-center mt-3"><b><?= $pr->nama ?></b></p>
					</a>
				</div>
			<?php endforeach ?>
		<?php endif ?>
	</div>
</section>