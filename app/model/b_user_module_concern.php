<?php

namespace Model;

register_namespace(__NAMESPACE__);
/**
 * Define all general method(s) and constant(s) for b_user table,
 *   can be inherited a Concern class also can be reffered as class constants
 *
 * @version 1.0.0
 *
 * @package Model\B_User
 * @since 1.0.0
 */
class B_User_Module_Concern extends \JI_Model
{
    public $tbl = 'b_user_module';
    public $tbl_as = 'bum';
    public $tbl2 = 'b_user';
    public $tbl2_as = 'bu';
    public $tbl3 = 'a_jabatan';
    public $tbl3_as = 'aj';
    public $tbl4 = 'a_jpenilaian';
    public $tbl4_as = 'aj';

    const COLUMNS = [
        'a_jabatan_id',
        'b_user_id',
        'a_jpenilaian_id',
        'type',
        'cdate',
        'is_active',
        'is_deleted'
    ];
    const DEFAULTS = [
        0,
        0,
        0,
        'create',
        '',
        1,
        0
    ];
    const REQUIREDS = [
        'a_jpenilaian_id',
        'type'
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
            ["$this->tbl_as.a_jpenilaian_id", 'a_jpenilaian_id', 'a_jpenilaian_id'],
            ["$this->tbl_as.b_user_id", 'b_user_id', 'b_user_id'],
            ["$this->tbl_as.a_jabatan_id", 'a_jabatan_id', 'a_jabatan_id'],
            ["$this->tbl_as.type", 'type', 'type'],
            ["$this->tbl_as.is_active", 'is_active', 'Status']
        ]);
    }

    public function email($email)
    {
        $this->db->where('email', $email);
        return $this->db->get_first();
    }

    public function setToken($id, $token, $kind = "api_web")
    {
        $this->db->where('id', $id);
        return $this->db->update($this->tbl, array(
            $kind . '_token' => $token
        ));
    }

    public function generator_prefix()
    {
        $alphabets = str_split(self::ALPHABET);

        $tgl = (int) date('j');
        $bln = (int) date('n');
        $thn = (int) date('y');

        return $alphabets[$tgl - 1] . $alphabets[$bln - 1] . $thn;
    }

    public function generator_kode()
    {
        $prefix = $this->generator_prefix();

        return $prefix . str_pad($this->last_kode($prefix), 6, '0', \STR_PAD_LEFT);
    }

    public function last_kode($prefix = '')
    {
        $this->db->flushQuery();
        $this->db->select_as('CAST(SUBSTRING(kode, 7) AS UNSIGNED)+1', 'urutan');
        $this->db->from($this->tbl, $this->tbl_as);
        $this->db->order_by('CAST(SUBSTRING(kode, 7) AS UNSIGNED)', 'desc');
        $this->db->where('kode', $prefix, 'AND', 'like%');
        $d = $this->db->get_first('object', 0);
        if (isset($d->urutan)) {
            return (int) $d->urutan;
        }
        return 0;
    }
}
