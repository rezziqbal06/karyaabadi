<style>
	.blog-item {
		border-radius: 32px;
		position: relative;
	}

	.blog-tgl {
		position: absolute;
		z-index: 4;
		background-color: var(--secondary);
		color: white;
		padding: 8px;
		margin-top: 16px;
		margin-left: 16px;
		border-radius: 16px;
	}
</style>

<!-- List Produk -->
<section class="row p-3 p-md-5">
	<?php if (isset($abm) && count($abm)) : ?>
		<?php foreach ($abm as $a) : ?>
			<div class="col-md-4">
				<a href="<?= base_url('blog/' . $a->slug) ?>" class="" alt="<?= $a->judul ?>">
					<div class="blog-tgl"><b><?= $a->cdate ?></b></div>
					<img src="<?= base_url($a->gambar) ?>" alt="<?= $a->judul ?>" class="blog-item img-fluid">
					<div class="blog-desc p-3">
						<span class="text-primary"><?= $a->kategori ?></span>
						<h3><?= $a->judul ?></h3>
					</div>

				</a>
			</div>
		<?php endforeach ?>
	<?php endif ?>

</section>