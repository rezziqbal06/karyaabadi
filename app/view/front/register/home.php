<!-- Register Container -->
<div id="login-container" class="animation-fadeIn" style="top: 10px;">
	<!-- Register Title -->
	<div class="login-title text-center">
		<img src="<?= $this->cdn_url($this->current_reseller->logo()->path) ?>" class="img-responsive" />
	</div>
	<!-- END Register Title -->

	<!-- Login Block -->
	<div class="block push-bit">
		<?php if($this->status != 200){
			?>
			<div id="form_info" class="alert alert-danger" role="alert">
				Gagal: [<?=$this->status?>] <?=$this->message?>
			</div>
			<?php
		}
		?>
		<!-- Register Form -->
		<form id="form-register" action="<?=base_url('register/proses/')?>" method="post" class="form-horizontal form-bordered form-control-borderless">
			<div class="form-group">
				<div class="col-md-12">
					<h1 >Form Pendaftaran</h1>
					<p style="margin: 0; line-height: 1;">Daftarkan diri anda sebagai member di <?=$this->current_reseller->nama?> dengan melengkapi form data dibawah ini.</p>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-7 col-sm-12 col-xs-12">
					<label for="register-name">Nama *</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="gi gi-user"></i></span>
						<input type="text" id="register-name" name="fnama" class="form-control input-lg" placeholder="Nama Lengkap" minlength="1" required>
					</div>
				</div>
				<div class="col-md-5 col-sm-12 col-xs-12">
					<label for="register-phone">Telp *</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone"></i></span>
						<input type="text" id="register-phone" name="telp" class="form-control input-lg" placeholder="No Telp" minlength="6" required>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<label for="register-email">Email *</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="gi gi-envelope"></i></span>
						<input id="register-email" type="email" name="email" class="form-control input-lg" placeholder="Email" minlength="6" required>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12">
					<label for="register-password">Password *</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
						<input type="password" id="register-password" name="password" class="form-control input-lg" placeholder="Password" required>
					</div>
				</div>
			</div>
            <div class="form-group">

                <div class="col-xs-12">
                    <label for="ialamat">Alamat Baris 1*</label>
                    <textarea id="ialamat" class="form-control" name="alamat" maxlength="30" required></textarea>
                </div>
                <div class="col-xs-12">
                    <label for="ialamat2">Alamat Baris 2</label>
                    <textarea id="ialamat2" class="form-control" name="alamat2" maxlength="30"></textarea>
                </div>
                <div class="col-xs-12">
                    <label for="ialamat_select" class="control-label">Pilihan Alamat (<small><i>origin</i></small>)</label>
                    <select id="ialamat_select" class="form-control select2"></select>
                </div>
                <div class="col-md-4 hidden">
                    <label for="inegara">Negara *</label>
                    <input id="inegara" class="form-control" name="negara" value="INDONESIA" required>
                </div>
                <div class="col-md-4 hidden">
                    <label for="iprovinsi">Provinsi *</label>
                    <input id="iprovinsi" class="form-control" name="provinsi" required>
                </div>
                <div class="col-md-4 hidden">
                    <label for="ikabkota">Kabupaten / Kota *</label>
                    <input id="ikabkota" class="form-control" name="kabkota" required>
                </div>
                <div class="col-md-4 hidden">
                    <label for="ikecamatan">Kecamatan *</label>
                    <input id="ikecamatan" class="form-control" name="kecamatan" required>
                </div>
                <div class="col-md-4 hidden">
                    <label for="ikelurahan">Desa / Kelurahan *</label>
                    <input id="ikelurahan" class="form-control" name="kelurahan" required>
                </div>
                <div class="col-md-4 hidden">
                    <label for="ikodepos" class="control-label">Kodepos *</label>
                    <input id="ikodepos" class="form-control " name="kodepos" placeholder="Kodepos" required>
                </div>
                <div class="col-md-4 hidden">
                    <label for="ikode_origin" class="control-label">Kode Origin *</label>
                    <input id="ikode_origin" class="form-control" name="kode_origin" placeholder="Kode Origin" readonly required>
                </div>
                <div class="col-md-4 hidden">
                    <label for="ikode_destination" class="control-label">Kode Destination *</label>
                    <input id="ikode_destination" class="form-control" name="kode_destination" placeholder="Kode Destination" readonly required>
                </div>
            </div>

			<div class="form-group">
				<div class="col-xs-12">
					<a href="#modal-terms" data-toggle="modal" class="register-terms" title="Syarat dan ketentuan">Setujui Syarat &amp; Ketentuan</a>
					<label class="switch switch-primary" data-toggle="tooltip" title="Setujui Syarat dan Ketentuan">
						<input type="checkbox" id="register-terms" name="register-terms">
						<span></span>
					</label>
				</div>
			</div>

			<div class="form-group">
				<div class="col-xs-12">
					<button type="submit" class="btn btn-block btn-primary btn-submit">Daftar <i class="fa fa-angle-right icon-submit"></i></button>
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-12 text-center">
					<small>Sudah menjadi member?</small> <a href="<?=base_url('login')?>" id="link-register"><small>Login</small></a>
				</div>
			</div>
		</form>
		<!-- END Register Form -->
	</div>
	<!-- END Register Block -->
    <?php $this->getThemeElement('page/html/footer_login', $__forward); ?>
</div>
<!-- END Register Container -->
