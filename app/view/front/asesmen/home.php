<style>
	.panel-card {
		position: relative;
	}

	.panel-card p {
		margin-left: 1.5em;
	}

	.bar {
		position: absolute;
		height: 65%;
		width: 8px;
		border-radius: 8px;
		background-color: var(--accent);
	}
</style>
<div class="container">
	<h3 class="mt-3 text-primary">Asesmen</h3>
	<hr class="mb-3" style="width: 45px;color:var(--secondary);height:3px;margin-top:-0.5rem;">

	<div class="row">
		<?php if (isset($ajm) && count($ajm)) : ?>
			<?php foreach ($ajm as $k => $v) : ?>
				<div class="col-12 col-md-6">
					<a href="<?= base_url('asesmen/' . $v->slug) ?>" class="btn-asesmen">
						<div class="panel-card shadow-sm p-3 mb-5 bg-body rounded">
							<div class="bar"></div>
							<p class=""><b><?= $v->nama ?></b></p>
						</div>
					</a>
				</div>
			<?php endforeach ?>
		<?php else : ?>
			<div class="col-md-12 text-center">
				<img src="<?= base_url("media/take_note.png") ?>" class="img-fluid" alt="">
				<p>Untuk saat ini anda tidak berwenang untuk mengisi penilaian.</p>
			</div>
		<?php endif ?>
	</div>
</div>