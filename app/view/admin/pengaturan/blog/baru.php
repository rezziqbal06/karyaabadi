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

                <div class="row">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="ijudul" class="control-label">Judul</label>
                                <input id="ijudul" type="text" name="judul" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="islug" class="control-label">Slug</label>
                                <input id="islug" type="text" name="slug" class="form-control" required>
                            </div>
                            <!-- <div class="col-md-4 mb-2">
									<label for="itype" class="control-label">Tipe</label>
									<select id="itype" type="text" name="type" class="form-control" required>
										<option value="header" selected>header</option>
										<option value="promo">promo</option>
									</select>
								</div> -->
                            <div class="col-md-6 mb-2">
                                <label for="igambar" class="control-label">Gambar</label>
                                <input id="igambar" type="file" name="gambar" accept=".jpg, .jpeg" class="form-control" required>
                            </div>
                            <div class="col-md-1 mb-2">
                                <img id="img-igambar" src="" alt="" class="img-fluid rounded">
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="itext" class="control-label">Text</label>
                                <textarea name="text" id="itext" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="iis_active" class="control-label">Status</label>
                                <select name="is_active" id="iis_active" class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="0">Draft</option>
                                </select>
                            </div>
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