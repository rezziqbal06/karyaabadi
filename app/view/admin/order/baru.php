<style>
    .pe-1 {
        padding-left: 1rem !important;
    }
</style>
<div id="page-content">
    <!-- Static Layout Header -->
    <div class="content-header">
        <div class="row" style="">
            <div class="col-md-6">
                <div class="btn-group">
                    <button type="button" onclick="history.back()" class="btn btn-info btn-submit"><i class="fa fa-arrow-left icon-submit"></i> Kembali</button>
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="card">

        <div class="card-header">
            <h6><strong><?= $this->getTitle() ?></strong></h6>
        </div>

        <div class="card-body">

            <form id="ftambah" action="<?= base_url_admin() ?>" method="post" enctype="multipart/form-data" class="form-bordered form-horizontal" onsubmit="return false;">

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label for="ib_user_id_cari" class="control-label">Cari Pembeli</label>
                            <select id="ib_user_id_cari" class="form-control select2"></select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="ib_user_nama" class="control-label">Pembeli</label>
                            <input id="ib_user_nama" type="text" name="b_user_nama" class="form-control" required>
                            <input type="hidden" id="ib_user_id" name="b_user_id">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="itgl_pesan" class="control-label">Tanggal Pesan</label>
                            <input id="itgl_pesan" type="text" name="tgl_pesan" class="form-control datepicker" value="<?= date('Y-m-d') ?>" required />
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="itgl_selesai" class="control-label">Tanggal Selesai</label>
                            <input id="itgl_selesai" type="text" name="tgl_selesai" class="form-control datepicker" value="" />
                        </div>
                    </div>
                </div>

                <hr>
                <div class="form-group">
                    <h5>Produk</h5>
                    <div class="row mb-3">
                        <div class="col-12">
                            <button id="btn_add_produk" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Produk</button>
                        </div>
                    </div>
                    <div>
                        <div id="panel_qty" class="rounded border border-warning p-3">
                            <div id="panel_produk">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-8">&nbsp;</div>
                        <div class="col-md-4">
                            <label for="itotal_harga">Total</label>
                            <input type="text" id="itotal_harga" class="form-control text-end text-bold" name="total_harga" readonly required>
                        </div>
                    </div>
                </div>

                <div class="form-group form-actions">
                    <div class="col-xs-12 text-right">
                        <div class="btn-group pull-right">
                            <button type="submit" class="btn btn-primary btn-submit">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>

</div>