<footer class="clearfix bg-primary  text-white">
	<div class="row">
		<div class="col-6 col-md-3 p-4 p-md-5">
			<img class="img-fluid" width="40%" src="<?= $this->config->semevar->site_logo->path ?>" />
			<p><?= $this->config->semevar->site_name ?></p>
			<p><?= $this->config->semevar->site_description ?></p>
		</div>
		<div class="col-6 col-md-3 p-4 p-md-5">
			<p class="mb-5"><b>Hubungi Kami</b></p>
			<p><?= $this->config->semevar->site_address ?></p>
			<a href="https://wa.me/<?= $this->config->semevar->site_wa ?>" target="_blank"><b><?= $this->config->semevar->site_number ?></b></a>
		</div>
	</div>
	<hr class="bg-white">
	<div class="row p-2">
		<div class="col-md-12"><?= $this->config->semevar->site_version ?> <a href="https://qaanii.com" target="_blank" title="Qaanii" style="color: rgba(0,0,0,0.4);">Qaanii</a></div>
	</div>

</footer>