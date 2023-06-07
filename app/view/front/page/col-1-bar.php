<!DOCTYPE html>
<html class="no-js" lang="en">
<?php $this->getThemeElement("page/html/head", $__forward); ?>

<body style="overflow-x: hidden;" class="bg-background">
	<!-- Page Wrapper -->
	<div id="page-wrapper" class="page-loading">


		<div id="page-container" class="header-fixed-top footer-fixed">
			<!-- Main Container -->
			<div id="main-container">
				<!-- Header -->
				<?php $this->getThemeElement("page/html/topbar/header", $__forward); ?>
				<!-- END Header -->


				<?php $this->getThemeContent(); ?>

				<!-- Main Container End -->

				<!-- Footer -->
				<?php $this->getThemeElement("page/html/footer", $__forward); ?>
				<!-- End Footer -->
			</div>
			<!-- End Main Container -->

		</div>
		<!-- End Page Container -->

	</div>
	<!-- End Page Wrapper -->

	<!-- Foot -->
	<?php // $this->getThemeElement("page/html/foot",$__forward); 
	?>
	<!-- End Foot -->

	<div id="modal-preloader" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog slideInDown animated">
			<div class="modal-content" style="background-color: #000;color: #fff;">
				<!-- Modal Header -->
				<div class="modal-header text-center" style="border: none;">
					<h2 class="modal-title"><i class="fa fa-spin fa-refresh"></i> Loading...</h2>
				</div>
				<!-- END Modal Header -->
			</div>
		</div>
	</div>

	<!-- jQuery, Bootstrap.js, jQuery plugins and Custom JS code -->
	<?php $this->getJsFooter(); ?>

	<!-- Load and execute javascript code used only in this page -->
	<script>
		var from_user_id = '';
		var from_user_nama = '';
		var to_user_id = '';
		var to_user_nama = '';
		var chat_active = 1;
		var last_pesan_id = 0;
		var iterator = 1;
		var hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
		var bulan = ['Januari', 'Ferbruari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
		var tahun = Number(new Date().getYear());
		tahun += 1900;

		function topbartimer() {
			$("#topbar_hari_tgl_waktu").html(hari[(new Date().getDay())] + ', ' + (new Date().getDate()) + ' ' + bulan[(new Date().getMonth())] + ' ' + tahun + ' ' + ("0" + (new Date().getHours())).slice(-2) + ':' + ("0" + new Date().getMinutes()).slice(-2));
		}
		$(document).ready(function(e) {
			<?php $this->getJsReady(); ?>
			<?php //$this->getThemeElement('page/html/script',$__forward); 
			?>
		});
		<?php $this->getJsContent(); ?>
	</script>
</body>

</html>