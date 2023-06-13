<section>
    <div class="row">
        <?php $title = ["Produk", "Kustomer", "Order On Proses", "Order Selesai"]; ?>
        <?php $value = [$count_produk, $count_kustomer, $count_order_on_proses, $count_order_done]; ?>
        <?php $icon = ["app", "single-02", "cart", "cart"]; ?>
        <?php $color = ["danger", "warning", "info", "success"]; ?>
        <?php foreach ($title as $k => $v) : ?>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold"><?= $title[$k] ?></p>
                                    <h2 class="font-weight-bolder">
                                        <?= $value[$k] ?>
                                    </h2>
                                    <p class="mb-0 d-none">
                                        <span class="text-success text-sm font-weight-bolder">+55%</span>
                                        since yesterday
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-<?= $color[$k] ?> shadow-primary text-center rounded-circle">
                                    <i class="ni ni-<?= $icon[$k] ?> text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</section>
<section>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    Omset Perbulan
                </div>
                <div class="card-body">
                    <canvas id="line-chart-gradient-omset" class="chart-canvas" height="300px"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Jumlah Order Perbulan
                </div>
                <div class="card-body">
                    <canvas id="line-chart-gradient-jumlah" class="chart-canvas" height="300px"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>