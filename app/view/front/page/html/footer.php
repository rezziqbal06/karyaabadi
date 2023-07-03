<footer class="clearfix bg-primary  text-white">
	<div class="row">
		<div class="col-6 col-md-3 p-4 p-md-5">
			<img class="img-fluid" width="40%" src="<?= base_url() . $this->config->semevar->site_logo->path ?>" alt="<?= $this->config->semevar->site_name ?>" />
			<p><?= $this->config->semevar->site_name ?></p>
			<p><?= $this->config->semevar->site_motto ?></p>
		</div>
		<div class="col-6 col-md-3 p-4 p-md-5">
			<p class="mb-5"><b>Hubungi Kami</b></p>
			<a href="<?= $this->config->semevar->site_map ?>" target="_blank">
				<p><b><?= $this->config->semevar->site_address ?></b></p>
			</a>
			<a href="https://wa.me/<?= $this->config->semevar->site_wa ?>" target="_blank">
				<p><b><?= $this->config->semevar->site_number ?></b></p>
			</a>
		</div>
		<div class="col-6 col-md-3 p-4 p-md-5">
			<p class="mb-5"><b>Follow</b></p>
			<a class="dropdown-link" target="_blank" href="<?= $this->config->semevar->site_ig ?>">Instagram</a>
			<a class="dropdown-link" target="_blank" href="<?= $this->config->semevar->site_fb ?>">Facebook</a>
			<p class="mb-2 mt-2"><b>Marketplace</b></p>
			<a class="dropdown-link" target="_blank" href="<?= $this->config->semevar->site_tokopedia ?>">Tokopedia</a>
		</div>
		<div class="col-6 col-md-3 p-4 p-md-5">
			<p class="mb-5"><b>Menu</b></p>
			<a class="dropdown-link" href="#">Produk</a>
			<a class="dropdown-link" href="<?= base_url("tentang_kami") ?>">Tentang Kami</a>
			<a class="dropdown-link" href="<?= base_url("blog") ?>">Blog</a>
		</div>
	</div>
	<hr class="bg-white">
	<div class="row p-3 text-sm" style="color: rgba(0,0,0,0.4);">
		<div class="col-md-6"><a href="https://qaanii.com" target="_blank" title="Qaanii">Copyright © Qaanii</a></div>
		<div class="col-md-6"><small class="pull-right">Image by <a href="https://www.freepik.com/free-vector/organic-flat-illustration-printing-industry_13176038.htm">Freepik</a></small></div>
	</div>

</footer>