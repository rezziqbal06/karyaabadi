<?php

namespace Model;

register_namespace(__NAMESPACE__);
/**
 * Define all general method(s) and constant(s) for B_Produk table,
 *   can be inherited a Concern class also can be reffered as class constants
 *
 * @version 1.0.0
 *
 * @package Model\B_User
 * @since 1.0.0
 */
class C_Order_Produk_Concern extends \JI_Model
{
    public $tbl = 'c_order_produk';
    public $tbl_as = 'cop';
    public $tbl2 = 'c_order';
    public $tbl2_as = 'co';
    public $tbl3 = 'b_produk';
    public $tbl3_as = 'bp';
    public $tbl4 = 'b_produk_harga';
    public $tbl4_as = 'bph';
    public $tbl5 = 'b_user';
    public $tbl5_as = 'bu';

    const COLUMNS = [
        'c_order_id',
        'b_produk_id',
        'b_produk_id_harga',
        'qty',
        'cdate',
        'tgl_pesan',
        'tgl_selesai',
        'status',
        'rating',
        'penilaian',
        'sub_harga',
        'is_active',
        'is_deleted',
    ];
    const DEFAULTS = [
        0,
        0,
        0,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        1,
        0,
    ];
    const REQUIREDS = [
        'b_produk_id',
        'b_produk_id_harga',
        'tgl_pesan'
    ];
    const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    /**
     * Install HTML bootstrap label into certain columns
     *
     * @return object this current object
     */
    private function install_labels()
    {
        $this->labels['is_active'] = new \Seme_Flaglabel();
        $this->labels['is_active']->init_is_active();

        $this->labels['is_deleted'] = new \Seme_Flaglabel();
        $this->labels['is_deleted']->init_is_deleted();

        return $this;
    }

    public function __construct()
    {
        parent::__construct();
        $this->install_labels()->db->from($this->tbl, $this->tbl_as);

        /** dont forget to define point_of_view property on your class model */
        $this->define_columns(self::COLUMNS, self::REQUIREDS, self::DEFAULTS);

        $this->datatables['admin'] = new \Seme_Datatable([
            ["$this->tbl_as.id", 'id', 'ID'],
            ["$this->tbl_as.qty", 'qty', 'qty'],
            ["$this->tbl_as.sub_harga", 'sub_harga', 'sub_harga'],
            ["$this->tbl_as.tgl_pesan", 'tgl_pesan', 'Tgl Pesan'],
            ["$this->tbl_as.tgl_selesai", 'tgl_selesai', 'Tgl Selesai'],
            ["$this->tbl3_as.nama", 'produk', 'Produk'],
            ["$this->tbl4_as.spesifikasi", 'spesifikasi', 'Spesifikasi'],
            ["$this->tbl4_as.harga", 'harga', 'Harga'],
            ["$this->tbl_as.status", 'status', 'Status']
        ]);

        // $this->datatables['download'] = new \Seme_Datatable([
        //     ["$this->tbl_as.fnama", 'fnama', 'Nama'],
        //     ["$this->tbl_as.telp", 'telp', 'Telp'],
        //     ["$this->tbl_as.email", 'email', 'Email'],
        //     ["$this->tbl_as.utype", 'utype', 'Utype'],
        //     ["$this->tbl2_as.provinsi", 'provinsi', 'Provinsi'],
        //     ["$this->tbl2_as.kabkota", 'kabkota', 'Kota'],
        //     ["$this->tbl2_as.kecamatan", 'kecamatan', 'Kecamatan'],
        //     ["$this->tbl2_as.alamat", 'alamat', 'Alamat'],
        //     ["$this->tbl2_as.alamat2", 'alamat2', 'Alamat 2'],
        //     ["$this->tbl2_as.kodepos", 'kodepos', 'Kodepos'],
        //     ["$this->tbl_as.is_active", 'is_active', 'Status']
        // ]);
    }
}
