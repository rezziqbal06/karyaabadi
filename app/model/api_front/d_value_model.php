<?php

register_namespace(__NAMESPACE__);
/**
 * Scoped `front` model for `d_value` table
 *
 * @version 5.4.1
 *
 * @package Model\Front
 * @since 1.0.0
 */
class D_Value_Model extends \Model\D_Value_Concern
{
  public function __construct()
  {
    parent::__construct();
    $this->db->from($this->tbl, $this->tbl_as);
    $this->point_of_view = 'front';
  }

  private function filters($b_user_id = '', $b_user_id_penilai = '', $a_jpenilaian_id = '', $a_ruangan_id = '', $sdate = '', $edate = '', $keyword = '', $is_active = '')
  {
    if (strlen($b_user_id)) {
      // $this->db->where_as("$this->tbl_as.b_user_id", $this->db->esc($b_user_id));
    }
    if (strlen($b_user_id_penilai)) {
      $this->db->where_as("$this->tbl2_as.b_user_id_penilai", $this->db->esc($b_user_id_penilai));
    }
    if (strlen($a_jpenilaian_id)) {
      $this->db->where_as("$this->tbl2_as.a_jpenilaian_id", $this->db->esc($a_jpenilaian_id));
    }
    if (strlen($a_ruangan_id)) {
      $this->db->where_as("$this->tbl2_as.a_ruangan_id", $this->db->esc($a_ruangan_id));
    }
    if (strlen($is_active)) {
      // $this->db->where_as("$this->tbl_as.is_active", $this->db->esc($is_active));
    }
    if (strlen($sdate) == 10 && strlen($edate) == 10) {
      $this->db->between("DATE($this->tbl2_as.cdate)", 'DATE("' . $sdate . '")', 'DATE("' . $edate . '")');
    } elseif (strlen($sdate) != 10 && strlen($edate) == 10) {
      $this->db->where_as("DATE($this->tbl2_as.cdate)", 'DATE("' . $edate . '")', "AND", '<=');
    } elseif (strlen($sdate) == 10 && strlen($edate) != 10) {
      $this->db->where_as("DATE($this->tbl2_as.cdate)", 'DATE("' . $sdate . '")', "AND", '>=');
    }
    if (strlen($keyword) > 0) {
      // $this->db->where_as("COALESCE($this->tbl2_as.fnama, '')", $keyword, "AND", "%like%", 1, 0);
      // $this->db->where_as("COALESCE($this->tbl3_as.fnama, '')", $keyword, "AND", "%like%", 0, 1);
    }
    return $this;
  }

  private function join_company()
  {
    $this->db->join($this->tbl2, $this->tbl2_as, 'id', $this->tbl_as, 'c_asesmen_id', 'left');
    $this->db->join($this->tbl3, $this->tbl3_as, 'id', $this->tbl_as, 'indikator', 'left');
    $this->db->join($this->tbl5, $this->tbl5_as, 'id', $this->tbl2_as, 'a_jpenilaian_id', 'left');
    $this->db->join($this->tbl6, $this->tbl6_as, 'id', $this->tbl2_as, 'a_ruangan_id', 'left');
    $this->db->join($this->tbl7, $this->tbl7_as, 'id', $this->tbl2_as, 'b_user_id_penilai', 'left');

    return $this;
  }

  private function joins()
  {
    $this->db->from($this->tbl, $this->tbl_as);
    $this->join_company();

    return $this;
  }

  public function data($page = 0, $pagesize = 10, $sortCol = "id", $sortDir = "DESC", $b_user_id = '', $b_user_id_penilai = '', $a_jpenilaian_id = '', $a_ruangan_id = '', $sdate = '', $edate = '', $keyword = '', $is_active = '')
  {
    $this->datatables[$this->point_of_view]->selections($this->db);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->join_company();
    $this->filters($b_user_id, $b_user_id_penilai, $a_jpenilaian_id, $a_ruangan_id, $sdate, $edate, $keyword, $is_active)->scoped();
    $this->db->order_by($sortCol, $sortDir)->limit($page, $pagesize);
    return $this->db->get("object", 0);
  }

  public function count($b_user_id = '', $b_user_id_penilai = '', $a_jpenilaian_id = '', $a_ruangan_id = '', $sdate = '', $edate = '', $keyword = '', $is_active = '')
  {
    $this->db->select_as("COUNT($this->tbl_as.id)", "jumlah", 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->join_company();
    $this->filters($b_user_id, $b_user_id_penilai, $a_jpenilaian_id, $a_ruangan_id, $sdate, $edate, $keyword, $is_active)->scoped();
    $d = $this->db->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }

  public function setMass($dis)
  {
    return $this->db->insert_multi($this->tbl, $dis);
  }

  public function getByFilter($user_id, $penilai_id, $ajm_id, $sdate, $edate)
  {
    $this->db->select_as("$this->tbl_as.id", 'id', 0);
    $this->db->select_as("$this->tbl_as.indikator", 'indikator', 0);
    $this->db->select_as("$this->tbl_as.aksi", 'aksi', 0);
    $this->db->select_as("$this->tbl_as.c_asesmen_id", 'c_asesmen_id', 0);
    $this->db->select_as("COALESCE($this->tbl7_as.fnama,'')", 'penilai', 0);
    $this->db->select_as("COALESCE($this->tbl2_as.b_user_id_penilai,'')", 'b_user_id_penilai', 0);
    $this->db->select_as("COALESCE($this->tbl2_as.cdate,'')", 'cdate', 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->join_company();
    $this->db->where_as("$this->tbl2_as.b_user_id", $this->db->esc($user_id));
    $this->db->where_as("$this->tbl2_as.a_jpenilaian_id", $this->db->esc($ajm_id));
    $this->db->between("DATE($this->tbl2_as.cdate)", "DATE('$sdate')", "DATE('$edate')");
    return $this->db->get('', 0);
  }

  public function getByAsesmenId($id)
  {
    $this->db->where("c_asesmen_id", $id);
    return $this->db->get_first();
  }

  public function delById($id)
  {
    $this->db->where('id', $id);
    return $this->db->delete($this->tbl);
  }

  public function delByAsesmenId($id)
  {
    $this->db->where('c_asesmen_id', $id);
    return $this->db->delete($this->tbl);
  }

  public function print_ppi($page = '', $pagesize = '', $sortCol = "id", $sortDir = "DESC", $b_user_id = '', $b_user_id_penilai = '', $a_jpenilaian_id = '', $a_ruangan_id = '', $sdate = '', $edate = '', $keyword = '', $is_active = '')
  {
    $this->datatables[$this->point_of_view]->selections($this->db);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->join_company();
    $this->filters($b_user_id, $b_user_id_penilai, $a_jpenilaian_id, $a_ruangan_id, $sdate, $edate, $keyword, $is_active)->scoped();
    $this->db->order_by("$this->tbl2_as.a_ruangan_id", 'ASC')->order_by("$this->tbl_as.id", 'ASC')->order_by("$this->tbl2_as.cdate", 'ASC');
    return $this->db->get("object", 0);
  }

  public function calculate_ppi($page = '', $pagesize = '', $sortCol = "id", $sortDir = "DESC", $b_user_id = '', $b_user_id_penilai = '', $a_jpenilaian_id = '', $a_ruangan_id = '', $sdate = '', $edate = '', $keyword = '', $is_active = '')
  {
    $this->db->select_as("$this->tbl6_as.nama", 'ruangan', 0);
    $this->db->select_as("$this->tbl3_as.kategori", 'kategori', 0);
    $this->db->select_as("COUNT(*)", 'jumlah', 0);
    $this->db->select_as("COUNT(CASE WHEN $this->tbl_as.aksi = 'y' THEN 1 END)", 'y', 0);
    $this->db->select_as("COUNT(CASE WHEN $this->tbl_as.aksi = 'n' THEN 1 END)", 'n', 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->join_company();
    $this->filters($b_user_id, $b_user_id_penilai, $a_jpenilaian_id, $a_ruangan_id, $sdate, $edate, $keyword, $is_active)->scoped();
    $this->db->group_by("CONCAT($this->tbl6_as.nama,'-',$this->tbl3_as.kategori)");
    $this->db->order_by("$this->tbl_as.id", 'ASC');
    return $this->db->get("object", 0);
  }
}
