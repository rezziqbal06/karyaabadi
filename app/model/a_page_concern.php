<?php

namespace Model;

register_namespace(__NAMESPACE__);
/**
 * Define all general method(s) and constant(s) for a_page table,
 *   can be inherited a Concern class also can be reffered as class constants
 *
 * @version 1.0.0
 *
 * @package Model\A_Page
 * @since 1.0.0
 */
class A_Page_Concern extends \JI_Model
{
    public $tbl = 'a_page';
    public $tbl_as = 'ap';
    public $tbl2 = 'b_user';
    public $tbl2_as = 'bu';
    public $tbl3 = 'a_pengguna';
    public $tbl3_as = 'apn';

    const COLUMNS = [
        'a_pengguna_id',
        'b_user_id',
        'tos',
        'faq'
    ];
    const DEFAULTS = [
        0,
        0,
        '',
        '',

    ];

    const REQUIREDS = [];

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
            ["COALESCE($this->tbl2_as.fnama, COALESCE($this->tbl3_as.nama, '-'))", 'nama', 'Reseller'],
            ["$this->tbl_as.is_active", 'is_active', 'Status']
        ]);
    }
}
