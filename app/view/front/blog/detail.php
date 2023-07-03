<style>
	.panel-text a {
		text-decoration: underline;
		color: var(--primary);
	}
</style>
<!-- Detail blog -->
<section class="p-3 p-md-5">
	<div class="row">
		<div class="col-md-12"></div>
		<div class="col-md-8 panel-text">
			<span class="text-accent"><?= $blog->kategori ?></span>
			<h3 class="mb-3"><b><?= $blog->judul ?></b></h3>
			<p class="text-grey"><?= $blog->cdate ?></p>
			<img id="display-gambar" class="w-100" src="<?= base_url($blog->gambar) ?>" data-zoom-image="<?= base_url($blog->gambar) ?>" alt="<?= $blog->judul ?>" style="border-radius:16px;">
			<div class="p-3"><?= $blog->text ?></div>
		</div>
		<div class="col-md-4">
			<?php if (isset($abm_related[0])) : ?>
				<div class="card">
					<div class="p-3">
						<h5>Blog Terkait</h5>
					</div>
					<div class="card-body">
						<?php foreach ($abm_related as $pr) : ?>
							<div class="mb-3" data-kategori-id="<?= $pr->kategori ?>">
								<a href="<?= base_url("blog/") ?><?= $pr->slug ?>" class="row mb-4" data-id="<?= $pr->id ?>" data-kategori-id="<?= $pr->kategori ?>" alt="<?= $pr->judul ?>">
									<div class="col-3">
										<img src="<?= base_url("") ?><?= $pr->gambar ?? '' ?>" alt="<?= $pr->judul ?? '' ?>" aria-describedby="<?= $pr->judul ?? '' ?>" class="img-fluid rounded">
									</div>
									<div class="col-9">
										<span class="text-grey"><?= $pr->cdate ?></span>
										<p class=""><b><?= $pr->judul ?></b></p>
									</div>
								</a>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			<?php endif ?>
			<?php if (isset($recent_post[0])) : ?>
				<div class="card">
					<div class="p-3">
						<h5>Recent Post</h5>
					</div>
					<div class="card-body">
						<?php foreach ($recent_post as $pr) : ?>
							<div class="mb-3" data-kategori-id="<?= $pr->kategori ?>">
								<a href="<?= base_url("blog/") ?><?= $pr->slug ?>" class="row mb-4" data-id="<?= $pr->id ?>" data-kategori-id="<?= $pr->kategori ?>" alt="<?= $pr->judul ?>">
									<div class="col-3">
										<img src="<?= base_url("") ?><?= $pr->gambar ?? '' ?>" alt="<?= $pr->judul ?? '' ?>" aria-describedby="<?= $pr->judul ?? '' ?>" class="img-fluid rounded">
									</div>
									<div class="col-9">
										<span class="text-grey"><?= $pr->cdate ?></span>
										<p class=""><b><?= $pr->judul ?></b></p>
									</div>
								</a>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			<?php endif ?>
		</div>
	</div>
</section>