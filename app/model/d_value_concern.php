<?php

namespace Model;

register_namespace(__NAMESPACE__);
/**
 * Define all general method(s) and constant(s) for d_value table,
 *   can be inherited a Concern class also can be reffered as class constants
 *
 * @version 1.0.0
 *
 * @package Model\B_User
 * @since 1.0.0
 */
class D_Value_Concern extends \JI_Model
{
    public $tbl = 'd_value';
    public $tbl_as = 'dv';
    public $tbl2 = 'c_asesmen';
    public $tbl2_as = 'ca';
    public $tbl3 = 'a_indikator';
    public $tbl3_as = 'ai'; // indikator
    public $tbl4 = 'a_indikator';
    public $tbl4_as = 'ai2'; // aksi
    public $tbl5 = 'a_jpenilaian';
    public $tbl5_as = 'aj';
    public $tbl6 = 'a_ruangan';
    public $tbl6_as = 'ar';
    public $tbl7 = 'b_user';
    public $tbl7_as = 'bu';

    const COLUMNS = [
        'c_asesmen_id',
        'b_user_id',
        'indikator',
        'aksi',
    ];
    const DEFAULTS = [
        0,
        0,
        0,
        0,
    ];
    const REQUIREDS = [
        'c_asesmen_id',
        'indikator',
        'aksi',
    ];
    const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';



    public function __construct()
    {
        parent::__construct();

        /** dont forget to define point_of_view property on your class model */
        $this->define_columns(self::COLUMNS, self::REQUIREDS, self::DEFAULTS);

        $this->datatables['admin'] = new \Seme_Datatable([
            ["$this->tbl_as.id", 'id', 'ID'],
            ["$this->tbl_as.a_jpenilaian_id", 'a_jpenilaian_id', 'Jenis Penilaian'],
            ["$this->tbl_as.durasi", 'durasi', 'durasi'],
            ["$this->tbl_as.is_active", 'is_active', 'Status']
        ]);

        $this->datatables['front'] = new \Seme_Datatable([
            ["$this->tbl_as.id", 'id', 'ID'],
            ["COALESCE($this->tbl2_as.id, '')", 'c_asesmen_id', 'c_asesmen_id'],
            ["COALESCE($this->tbl2_as.cdate, '')", 'cdate', 'cdate'],
            ["COALESCE($this->tbl3_as.nama, '')", 'indikator_nama', 'Indikator'],
            ["COALESCE($this->tbl3_as.kategori, '')", 'indikator_kategori', 'Indikator Kategori'],
            ["COALESCE($this->tbl3_as.subkategori, '')", 'indikator_subkategori', 'Indikator Subkategori'],
            ["COALESCE($this->tbl3_as.type, '')", 'indikator_type', 'Indikator type'],
            ["COALESCE($this->tbl6_as.nama, '')", 'ruangan', 'Ruangan'],
            ["COALESCE($this->tbl5_as.slug, '')", 'slug', 'Slug'],
            ["$this->tbl_as.indikator", 'indikator', 'indikator'],
            ["$this->tbl_as.aksi", 'aksi', 'aksi']
        ]);
    }
}
