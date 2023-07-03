<style>
	.header-bg {
		background-image: url('media/header_bg.png');
		background-repeat: no-repeat;
		background-size: cover;
	}

	.map {
		width: 1080px;
		height: 450px;
	}

	@media only screen and (max-width:750px) {
		.map {
			width: 300px;
			height: 450px;
		}
	}
</style>
<section>
	<div class="mt-7">
		<div class="header-bg p-5 text-center">
			<h2><b>Tentang Kami</b></h2>
		</div>
	</div>
	<h2 class="mt-5 text-center"><?= $this->config->semevar->site_motto ?></h2>
	<p class="p-5 text-center"><?= $this->config->semevar->site_description ?></p>
	<div class="p-3 row">
		<div class="col-md-12 text-center">
			<iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.119495824827!2d107.54387491477267!3d-6.876283795031033!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e446f355b753%3A0xfb9ff6e50f8dfce1!2sKarya%20Abadi%20Printing!5e0!3m2!1sen!2sid!4v1688371172180!5m2!1sen!2sid" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		</div>
	</div>
</section>