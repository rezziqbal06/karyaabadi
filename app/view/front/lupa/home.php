<main class="bg-background mt-3 vertical-center">
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3 col-12">
        <div class="main-logo">
        </div>
        <div class="bungkus animate__animated animate__fadeIn animate__delay-1s">
          <h3 class="text-center">Lupa Password</h3>
          <form id="flupa" action="" method="post">
            <div class="row">
              <div class="col">
                <div class="mb-3">
                  <label class="form-label" for="iemail">Masukan Email ketika daftar *</label>
                  <input class="form-control" id="iemail" type="email" name="email" placeholder="cth: fulan@gmail.com" required />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="mb-3">
                  <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-submit">
                      Kirim Email <i class="fa fa-send icon-submit"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="row">
            <div class="col-12">
              <p>
                Link untuk reset password akan dikirimkan melalui email tersebut.
                Proses ini membutuhkan waktu yang bervariasi, pastikan untuk mengecek email di <em>Inbox</em> atau <em>Spam</em> secara berkala.
              </p>
            </div>
          </div>


          <div class="row">
            <div class="col-12">
              <div class="mt-5">
                <div class="d-grid gap-2 text-center">
                  <a href="<?= base_url() ?>login" class="login">ingat password</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>