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
            <h6><strong>Daftar User</strong></h6>
        </div>

        <div class="card-body">

            <form id="ftambah" action="<?= base_url_admin() ?>" method="post" enctype="multipart/form-data" class="form-bordered form-horizontal" onsubmit="return false;">

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="inama" class="control-label">Nama</label>
                            <input id="inama" type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="islug" class="control-label">Slug</label>
                            <input id="islug" type="text" name="slug" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="ia_kategori_id" class="control-label">Kategori</label>
                            <select id="ia_kategori_id" type="text" name="a_kategori_id" class="form-control select2" required>
                                <?php if (isset($akm[0]->id)) : ?>
                                    <?php foreach ($akm as $k => $v) : ?>
                                        <option value="<?= $v->id ?>"><?= $v->nama ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="igambar" class="control-label">Gambar</label>
                            <input id="igambar" type="file" name="gambar" class="form-control" required>
                        </div>
                        <div class="col-md-1 mb-2">
                            <img id="img-igambar" src="" alt="" class="img-fluid rounded">
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="ideskripsi" class="control-label">Deskripsi</label>
                            <textarea name="deskripsi" id="ideskripsi" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="form-group">
                    <h5>Spesifikasi</h5>
                    <div class="row mb-3">
                        <div class="col-12">
                            <button id="btn_add_spec" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Spesifikasi</button>
                        </div>
                    </div>
                    <div>
                        <div id="panel_qty" class="rounded border border-warning p-3">
                            <div id="panel_spesifikasi">

                            </div>
                            <div id="ps_qty" class="row">
                                <div class="col-md-4">
                                    <div class="input-group mb-3">
                                        <input type="text" id="ispec_qty" name="spec[]" class="form-control" placeholder="Ex: Warna" value="QTY" readonly>
                                        <input type="hidden" id="icount_spec_qty" name="count_spec[]" value="qty" class="form-control" placeholder="Ex: Warna" value="qty" readonly>
                                        <button class="btn btn-danger btn-remove-spec d-none" type="button" data-count="qty"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary btn-add-spec-qty-detail" type="button" data-count="qty"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div id="psd_qty">
                                        <div id="sd_qty_0" class="input-group mb-3">
                                            <input type="number" id="ispec_detail_from_qty_0" name="spec_detail_from_qty[]" class="form-control" data-count="qty" data-count-detail="0" readonly placeholder="">
                                            <select name="spec_detail_operator_qty[]" class="bg-dark text-white form-select input-group-text" id="ispec_detail_operator_qty_0" data-count="qty" data-count-detail="0">
                                                <option value="<">
                                                    < </option>
                                                <option value="-"> - </option>
                                                <option value=">"> > </option>
                                            </select>
                                            <input type="number" id="ispec_detail_to_qty_0" name="spec_detail_to_qty[]" class="form-control pe-1" data-count="qty" data-count-detail="0" placeholder="">
                                            <button class="btn btn-danger btn-remove-spec-detail" type="button" data-count="qty" data-count-detail="0"><i class="fa fa-minus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3 mt-3">
                        <div class="col-12">
                            <button id="btn_price_setting" class="btn btn-warning pull-right"><i class="fa fa-calculator"></i> Setting Harga</button>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div id="panel_spec"></div>
                        <div id="panel_price" class="col-md-12" style="overflow-x: scroll;"></div>
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