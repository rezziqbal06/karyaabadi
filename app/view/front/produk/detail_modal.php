<!-- modal pesan -->
<div id="modal_pesan" class="modal fade " tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title">pesan</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- END Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="" method="POST" id="fpesan">
                    <div class="row">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="inama" class="control-label">Nama*</label>
                                    <input id="inama" type="text" name="nama" class="form-control" required>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label for="ialamat" class="control-label">Alamat</label>
                                    <textarea name="alamat" id="ialamat" class="form-control" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 1em; ">
                        <div class="col-md-12" style="border-top: 1px #afafaf dashed;">&nbsp;</div>
                        <div class="col-xs-12 btn-group-vertical" style="">
                            <button type="submit" class="btn btn-default btn-block text-left" data-dismiss="modal"><i class="fa fa-cart"></i> Pesan</button>
                        </div>
                    </div>
                </form>
                <!-- END Modal Body -->
            </div>
        </div>
    </div>
</div>