<?php

namespace Model;

register_namespace(__NAMESPACE__);
/**
 * Define all general method(s) and constant(s) for b_user_alamat table,
 *   can be inherited a Concern class also can be reffered as class constants
 *
 * @version 1.0.0
 *
 * @package Model\B_User_alamat
 * @since 1.0.0
 */
class B_User_Alamat_Concern extends \JI_Model
{
    public $tbl = 'b_user_alamat';
    public $tbl_as = 'bua';
    const COLUMNS = [
        'b_user_id',
        'nama',
        'telp',
        'alamat',
        'alamat2',
        'kelurahan',
        'kecamatan',
        'kabkota',
        'provinsi',
        'negara',
        'kodepos',
        'kode_destination',
        'is_default',
        'is_active',
        'is_deleted'
    ];
    const DEFAULTS = [
        'b_user_id',
        'nama',
        'telp',
        'alamat',
        'alamat2',
        'kelurahan',
        'kecamatan',
        'kabkota',
        'provinsi',
        'negara',
        'kodepos',
        'kode_destination',
        'is_default',
        'is_active',
        'is_deleted'
    ];
    const REQUIREDS = [
        'b_user_id',
        'nama',
        'telp',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kabkota',
        'provinsi',
        'negara',
        'kodepos',
        'kode_destination',
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
        $this->datatables['front'] = new \Seme_Datatable([
            ["$this->tbl_as.id", 'id', 'ID'],
            ["$this->tbl_as.nama", 'nama', 'Reseller'],
            ["$this->tbl_as.subdomain", 'subdomain', 'Subdomain'],
            ["$this->tbl_as.domain", 'domain', 'Domain'],
            ["$this->tbl_as.is_active", 'is_active', 'Status']
        ]);
    }
}
