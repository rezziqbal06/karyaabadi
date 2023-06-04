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
class B_Produk_Gambar_Concern extends \JI_Model
{
    public $tbl = 'b_produk_gambar';
    public $tbl_as = 'bpg';
    public $tbl2 = 'b_produk';
    public $tbl2_as = 'bp';
    // public $tbl3 = 'a_company';
    // public $tbl3_as = 'ac';

    const COLUMNS = [
        'b_produk_id',
        'gambar',
        'ke',
        'deskripsi',
        'is_cover',
        'is_active',
        'is_deleted',
    ];
    const DEFAULTS = [
        0,
        '',
        1,
        '',
        0,
        1,
        0,
    ];
    const REQUIREDS = [
        'b_produk_id',
        'gambar'
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
            ["$this->tbl_as.nama", 'nama', 'Produk'],
            ["$this->tbl2_as.nama", 'kategori', 'Kategori'],
            ["$this->tbl_as.slug", 'slug', 'Slug'],
            ["$this->tbl_as.gambar", 'gambar', 'Gambar'],
            ["$this->tbl_as.is_active", 'is_active', 'Status']
        ]);

        // $this->datatables['front'] = new \Seme_Datatable([
        //     ["$this->tbl_as.id", 'id', 'ID'],
        //     ["$this->tbl_as.fnama", 'fnama', 'Nama'],
        //     ["$this->tbl_as.telp", 'telp', 'Telp'],
        //     ["$this->tbl_as.email", 'email', 'Email'],
        //     ["$this->tbl_as.utype", 'utype', 'Utype'],
        //     ["$this->tbl_as.is_active", 'is_active', 'Status']
        // ]);

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
