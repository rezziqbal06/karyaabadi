<?php

namespace Model;

register_namespace(__NAMESPACE__);
/**
 * Define all general method(s) and constant(s) for a_pengguna table,
 *   can be inherited a Concern class also can be reffered as class constants
 *
 * @version 1.0.0
 *
 * @package Model\a_pengguna
 * @since 1.0.0
 */
class A_Pengguna_Concern extends \JI_Model
{
    public $tbl = 'a_pengguna';
    public $tbl_as = 'ap';
    public $tbl2 = 'b_user';
    public $tbl2_as = 'bu';

    const COLUMNS = [
        'a_company_nama',
        'a_jabatan_nama',
        'nama',
        'username',
        'password',
        'foto',
        'telp_hp',
        'karyawan_status',
        'bank_rekening_nomor',
        'bank_rekening_nama',
        'bank_nama',
        'npwp',
        'pendidikan_terakhir',
        'tgl_kerja_mulai',
        'tgl_kerja_akhir',
        'is_active',
        'is_deleted'
    ];
    const DEFAULTS = [
        'Almaas98',
        '',
        '',
        '',
        NULL,
        '',
        '',
        'Kontrak',
        '',
        '',
        '',
        '',
        '',
        NULL,
        NULL,
        1,
        0

    ];

    const REQUIREDS = [
        'nama',
        'a_jabatan_nama'
    ];

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
            ["$this->tbl_as.nama", 'nama', 'Nama'],
            ["$this->tbl_as.telp_hp", 'telp_hp', 'Telp'],
            ["$this->tbl_as.a_jabatan_nama", 'a_jabatan_nama', 'Jabatan'],
            ["$this->tbl_as.karyawan_status", 'karyawan_status', 'Status Karyawan'],
            ["$this->tbl_as.is_active", 'is_active', 'Status']
        ]);

        $this->datatables['front'] = new \Seme_Datatable([
            ["$this->tbl_as.id", 'id', 'ID'],
            ["$this->tbl_as.fnama", 'fnama', 'Nama'],
            ["$this->tbl_as.telp", 'telp', 'Telp'],
            ["$this->tbl_as.email", 'email', 'Email'],
            ["$this->tbl_as.utype", 'utype', 'Utype'],
            ["$this->tbl_as.is_active", 'is_active', 'Status']
        ]);

        $this->datatables['download'] = new \Seme_Datatable([
            ["$this->tbl_as.fnama", 'fnama', 'Nama'],
            ["$this->tbl_as.telp", 'telp', 'Telp'],
            ["$this->tbl_as.email", 'email', 'Email'],
            ["$this->tbl_as.utype", 'utype', 'Utype'],
            ["$this->tbl2_as.provinsi", 'provinsi', 'Provinsi'],
            ["$this->tbl2_as.kabkota", 'kabkota', 'Kota'],
            ["$this->tbl2_as.kecamatan", 'kecamatan', 'Kecamatan'],
            ["$this->tbl2_as.alamat", 'alamat', 'Alamat'],
            ["$this->tbl2_as.alamat2", 'alamat2', 'Alamat 2'],
            ["$this->tbl2_as.kodepos", 'kodepos', 'Kodepos'],
            ["$this->tbl_as.is_active", 'is_active', 'Status']
        ]);
    }
}
