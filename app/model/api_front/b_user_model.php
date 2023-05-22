<?php

register_namespace(__NAMESPACE__);
/**
 * Scoped `front` model for `b_user` table
 *
 * @version 5.4.1
 *
 * @package Model\Front
 * @since 1.0.0
 */
class B_User_Model extends \Model\B_User_Concern
{
  public $tbl2 = 'a_jabatan';
  public $tbl2_as = 'j';
  public function __construct()
  {
    parent::__construct();
    $this->db->from($this->tbl, $this->tbl_as);
    $this->point_of_view = 'front';
  }

  public function getUserById($id)
  {
    $this->db->select_as("$this->tbl_as.*, $this->tbl_as.id", 'id', 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->where("bu.id", $id);
    return $this->db->get_first('object', 0);
  }

  public function getByEmail($email)
  {
    $this->db->select_as("$this->tbl_as.*, $this->tbl_as.id", 'id', 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->where("bu.email", $email);
    return $this->db->get_first('object', 0);
  }

  private function _filter($b_user_id = '', $keyword = '', $is_active = '')
  {
    if (strlen($b_user_id)) {
      $this->db->where_as("$this->tbl_as.b_user_id", $this->db->esc($b_user_id));
    }
    if (strlen($is_active)) {
      $this->db->where_as("$this->tbl_as.is_active", $this->db->esc($is_active));
    }
    if (strlen($keyword) > 0) {
      $this->db->where_as("$this->tbl_as.fnama", $keyword, "OR", "%like%", 1, 0);
      $this->db->where_as("$this->tbl_as.telp", $keyword, "AND", "%like%", 0, 0);
      $this->db->where_as("$this->tbl_as.email", $keyword, "AND", "%like%", 0, 0);
      $this->db->where_as("$this->tbl_as.alamat", $keyword, "AND", "%like%", 0, 1);
    }
    return $this;
  }

  public function data($b_user_id = "", $page = 0, $pagesize = 10, $sortCol = "id", $sortDir = "ASC", $keyword = '', $is_active = '')
  {
    $this->datatables[$this->point_of_view]->selections($this->db);
    $this->db->from($this->tbl, $this->tbl_as);
    // $this->db->join($this->tbl2, $this->tbl2_as, 'id', $this->tbl_as, 'b_user_id_owner');
    $this->scoped()->_filter($b_user_id, $keyword, $is_active);
    $this->db->order_by($sortCol, $sortDir)->limit($page, $pagesize);
    return $this->db->get("object", 0);
  }

  public function count($b_user_id = '', $keyword = '', $is_active = '')
  {
    $this->db->select_as("COUNT($this->tbl_as.id)", "jumlah", 0);
    $this->db->from($this->tbl, $this->tbl_as);
    // $this->db->join($this->tbl2, $this->tbl2_as, 'id', $this->tbl_as, 'b_user_id_owner');
    $this->scoped()->_filter($b_user_id, $keyword, $is_active);
    $d = $this->db->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }

  public function checkusername($username, $id = 0)
  {
    $this->db->select_as("COUNT(*)", "jumlah", 0);
    $this->db->where("username", $username);
    if (!empty($id)) {
      $this->db->where("id", $id, 'AND', '!=');
    }
    $d = $this->db->from($this->tbl)->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }
  public function checktelp($username, $id = 0)
  {
    $this->db->select_as("COUNT(*)", "jumlah", 0);
    $this->db->where("telp", $username);
    if (!empty($id)) {
      $this->db->where("id", $id, 'AND', '!=');
    }
    $d = $this->db->from($this->tbl)->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }
  public function checkemail($email, $id = 0)
  {
    $this->db->select_as("COUNT(*)", "jumlah", 0);
    $this->db->where("email", $email);
    if (!empty($id)) {
      $this->db->where("id", $id, 'AND', '!=');
    }
    $d = $this->db->from($this->tbl)->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }
  public function checknamaperusahaan($np, $id = 0)
  {
    $this->db->select_as("COUNT(*)", "jumlah", 0);
    $this->db->where("nama_perusahaan", $np);
    if (!empty($id)) {
      $this->db->where("id", $id, 'AND', '!=');
    }
    $d = $this->db->from($this->tbl)->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }
  public function checkKode($id = 0)
  {
    $this->db->select_as("COUNT(*)", "jumlah", 0);
    $this->db->where("id", $id);
    $d = $this->db->from($this->tbl)->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }

  public function getByAgen($agen_id = "", $page = 0, $pagesize = 10, $sortCol = "id", $sortDir = "ASC", $keyword = "", $a_company_id = "", $edate = "")
  {
    $this->db->flushQuery();
    $this->db->select('id')
      ->select('fnama')
      ->select('telp')
      ->select('alamat')
      ->select('provinsi')
      ->select('kabkota')
      ->select('kecamatan')
      ->select('kodepos')
      ->select('is_active');
    $this->db->from($this->tbl, $this->tbl_as);
    if (strlen($agen_id)) $this->db->where("b_user_id", $agen_id);
    if (strlen($keyword) > 1) {
      $this->db->where("telp", $keyword, "OR", "%like%", 1, 0);
      $this->db->where("fnama", $keyword, "OR", "%like%", 0, 1);
    }
    $this->db->order_by($sortCol, $sortDir)->limit($page, $pagesize);
    return $this->db->get("object", 0);
  }
  public function countByAgen($agen_id = "", $keyword = "", $a_company_id = "", $edate = "")
  {
    $this->db->flushQuery();
    $this->db->select_as("COUNT(*)", "jumlah", 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->where("is_karyawan", 0);
    if (strlen($agen_id)) $this->db->where("b_user_id", $agen_id);
    if (strlen($keyword) > 1) {
      $this->db->where("telp", $keyword, "OR", "%like%", 1, 0);
      $this->db->where("fnama", $keyword, "OR", "%like%", 0, 1);
    }
    $d = $this->db->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }
  public function getKaryawan($page = 0, $pagesize = 10, $sortCol = "id", $sortDir = "ASC", $keyword = "", $a_company_id = "", $edate = "")
  {
    $this->db->flushQuery();
    $this->db->select('id')
      ->select('nip')
      ->select('nama')
      ->select('a_jabatan_nama')
      ->select('a_company_nama')
      ->select('karyawan_status')
      ->select('is_active');
    $this->db->from($this->tbl, $this->tbl_as);
    if (strlen($a_company_id)) {
      $this->db->where("a_company_id", $a_company_id);
    }
    if (strlen($keyword) > 0) {
      $this->db->where("username", $keyword, "OR", "%like%", 1, 0);
      $this->db->where("nama", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("a_jabatan_nama", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("a_company_nama", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("email", $keyword, "OR", "%like%", 0, 1);
    }
    $this->db->order_by($sortCol, $sortDir)->limit($page, $pagesize);
    return $this->db->get("object", 0);
  }
  public function countKaryawan($keyword = "", $a_company_id = "", $edate = "")
  {
    $this->db->flushQuery();
    $this->db->select_as("COUNT(*)", "jumlah", 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->where("is_karyawan", 1);
    if (strlen($a_company_id)) {
      $this->db->where("a_company_id", $a_company_id);
    }
    if (strlen($keyword) > 0) {
      $this->db->where("username", $keyword, "OR", "%like%", 1, 0);
      $this->db->where("nama", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("a_jabatan_nama", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("a_company_nama", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("email", $keyword, "OR", "%like%", 0, 1);
    }
    $d = $this->db->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }

  public function cari($keyword = "")
  {
    $this->db->select_as("$this->tbl_as.id", "id", 0);
    $this->db->select_as("CONCAT($this->tbl_as.fnama,' - ', COALESCE($this->tbl2_as.nama, ''))", "text", 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->join($this->tbl2, $this->tbl2_as, 'id', $this->tbl_as, 'a_jabatan_id', 'left');
    if (strlen($keyword) > 0) {
      $this->db->where_as("$this->tbl_as.fnama", ($keyword), "OR", "LIKE%%", 1, 0);
      $this->db->where_as("$this->tbl_as.username", ($keyword), "OR", "LIKE%%", 0, 0);
      $this->db->where_as("$this->tbl_as.email", ($keyword), "OR", "LIKE%%", 0, 1);
    }
    $this->db->order_by("$this->tbl_as.fnama", "asc");
    return $this->db->get('', 0);
  }

  public function getByNameAndTelp($name = "", $telp = "")
  {
    $this->db->flushQuery();
    $this->db->select('id')
      ->select('fnama')
      ->select('telp')
      ->select('alamat')
      ->select('provinsi')
      ->select('kabkota')
      ->select('kecamatan')
      ->select('kodepos')
      ->select('is_active');
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->where("telp", $telp, "OR", "%like%", 1, 0);
    $this->db->where("fnama", $name, "OR", "%like%", 0, 1);
    return $this->db->get_first("", 0);
  }

  public function getByName($name = "")
  {
    $this->db->flushQuery();
    $this->db->select('id')
      ->select('fnama')
      ->select('telp')
      ->select('alamat')
      ->select('provinsi')
      ->select('kabkota')
      ->select('kecamatan')
      ->select('kodepos')
      ->select('is_active');
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->where("fnama", $name);
    return $this->db->get_first("", 0);
  }
  public function cari_alamat($keyword = '')
  {
    $this->db->select_as("CONCAT($this->tbl_as.fnama, ' | ',$this->tbl_as.provinsi,' - ',$this->tbl_as.kabkota,' - ',$this->tbl_as.kecamatan,' - ',$this->tbl_as.kelurahan,' - ',$this->tbl_as.kodepos,' - ',$this->tbl_as.kode_origin)", "text", 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->join($this->tbl2, $this->tbl2_as, 'id', $this->tbl_as, 'b_user_id', 'left');
    if (strlen($keyword)) {
      $this->db->where_as("$this->tbl_as.fnama", $keyword, "OR", "%like%", 1, 0);
      $this->db->where_as("$this->tbl_as.kelurahan", $keyword, "OR", "%like%", 0, 0);
      $this->db->where_as("$this->tbl_as.kecamatan", $keyword, "OR", "%like%", 0, 0);
      $this->db->where_as("$this->tbl_as.kabkota", $keyword, "OR", "%like%", 0, 0);
      $this->db->where_as("$this->tbl_as.provinsi", $keyword, "OR", "%like%", 0, 1);
    }
    $this->db->limit(5);
    return $this->db->get('', 0);
  }

  public function check_apikey($apikey)
  {
    $this->db->select('id');
    $this->db->select('apikey');
    $this->db->where('apikey', $apikey);
    $d = $this->db->get_first('', 0);
    if (isset($d->apikey)) {
      return $d;
    }
    return 0;
  }

  public function getByApikey($apikey)
  {
    $this->db->select('id');
    $this->db->select('apikey');
    $this->db->where('apikey', $apikey);
    $d = $this->db->get_first('', 0);
    if (isset($d->apikey)) {
      return $d;
    }
    return 0;
  }
}
