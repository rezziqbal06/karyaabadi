<?php

namespace Model;

register_namespace(__NAMESPACE__);
/**
 * Define all general method(s) and constant(s) for c_asesmen table,
 *   can be inherited a Concern class also can be reffered as class constants
 *
 * @version 1.0.0
 *
 * @package Model\B_User
 * @since 1.0.0
 */
class C_Asesmen_Concern extends \JI_Model
{
    public $tbl = 'c_asesmen';
    public $tbl_as = 'ca';
    public $tbl2 = 'b_user';
    public $tbl2_as = 'bu';
    public $tbl3 = 'b_user';
    public $tbl3_as = 'bu2'; // untuk penilai
    public $tbl4 = 'a_ruangan';
    public $tbl4_as = 'ar';
    public $tbl5 = 'a_jpenilaian';
    public $tbl5_as = 'aj';
    public $tbl6 = 'a_jabatan';
    public $tbl6_as = 'ajb';
    public $tbl7 = 'a_jabatan'; // untuk penilai
    public $tbl7_as = 'ajb2';

    const COLUMNS = [
        'a_jpenilaian_id',
        'b_user_id_penilai',
        'b_user_id',
        'a_ruangan_id',
        'value',
        'nilai',
        'ntype',
        'cdate',
        'stime',
        'etime',
        'durasi',
        'is_active'
    ];
    const DEFAULTS = [
        0,
        0,
        0,
        0,
        '',
        '',
        'angka',
        'NOW()',
        0,
        0,
        0,
        1
    ];
    const REQUIREDS = [
        'stime',
        'a_jpenilaian_id'
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
            ["$this->tbl_as.a_jpenilaian_id", 'a_jpenilaian_id', 'Jenis Penilaian'],
            ["$this->tbl_as.durasi", 'durasi', 'durasi'],
            ["$this->tbl_as.is_active", 'is_active', 'Status']
        ]);

        $this->datatables['front'] = new \Seme_Datatable([
            ["$this->tbl_as.id", 'id', 'ID'],
            ["COALESCE($this->tbl2_as.fnama, '')", 'nama', 'nama'],
            ["COALESCE($this->tbl3_as.fnama, '')", 'nama_penilai', 'Penilai'],
            ["COALESCE($this->tbl7_as.nama, '')", 'jabatan_penilai', 'Jabatan Penilai'],
            ["COALESCE($this->tbl4_as.nama, '')", 'ruangan', 'Ruangan'],
            ["COALESCE($this->tbl5_as.slug, '')", 'slug', 'Slug'],
            ["COALESCE($this->tbl5_as.type_form, '')", 'type_form', 'Tipe Formulir'],
            ["COALESCE($this->tbl6_as.nama, '')", 'profesi', 'Profesi'],
            ["$this->tbl_as.durasi", 'durasi', 'durasi'],
            ["$this->tbl_as.value", 'value', 'value'],
            ["$this->tbl_as.cdate", 'cdate', 'cdate'],
            ["$this->tbl_as.nilai", 'nilai', 'Nilai'],
            ["$this->tbl_as.is_active", 'is_active', 'Status']
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
