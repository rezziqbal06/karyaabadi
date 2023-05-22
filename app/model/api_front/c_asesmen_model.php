<?php

register_namespace(__NAMESPACE__);
/**
 * Scoped `front` model for `c_asesmen` table
 *
 * @version 5.4.1
 *
 * @package Model\Front
 * @since 1.0.0
 */
class C_Asesmen_Model extends \Model\C_Asesmen_Concern
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
      $this->db->where_as("$this->tbl_as.b_user_id", $this->db->esc($b_user_id));
    }
    if (strlen($b_user_id_penilai)) {
      $this->db->where_as("$this->tbl_as.b_user_id_penilai", $this->db->esc($b_user_id_penilai));
    }
    if (strlen($a_jpenilaian_id)) {
      $this->db->where_as("$this->tbl_as.a_jpenilaian_id", $this->db->esc($a_jpenilaian_id));
    }
    if (strlen($a_ruangan_id)) {
      $this->db->where_as("$this->tbl_as.a_ruangan_id", $this->db->esc($a_ruangan_id));
    }
    if (strlen($is_active)) {
      $this->db->where_as("$this->tbl_as.is_active", $this->db->esc($is_active));
    }
    if (strlen($sdate) == 10 && strlen($edate) == 10) {
      $this->db->between("DATE($this->tbl_as.cdate)", 'DATE("' . $sdate . '")', 'DATE("' . $edate . '")');
    } elseif (strlen($sdate) != 10 && strlen($edate) == 10) {
      $this->db->where_as("DATE($this->tbl_as.cdate)", 'DATE("' . $edate . '")', "AND", '<=');
    } elseif (strlen($sdate) == 10 && strlen($edate) != 10) {
      $this->db->where_as("DATE($this->tbl_as.cdate)", 'DATE("' . $sdate . '")', "AND", '>=');
    }
    if (strlen($keyword) > 0) {
      $this->db->where_as("COALESCE($this->tbl2_as.fnama, '')", $keyword, "AND", "%like%", 1, 0);
      $this->db->where_as("COALESCE($this->tbl3_as.fnama, '')", $keyword, "AND", "%like%", 0, 1);
    }
    return $this;
  }

  private function join_company()
  {
    $this->db->join($this->tbl2, $this->tbl2_as, 'id', $this->tbl_as, 'b_user_id', 'left');
    $this->db->join($this->tbl3, $this->tbl3_as, 'id', $this->tbl_as, 'b_user_id_penilai', 'left');
    $this->db->join($this->tbl4, $this->tbl4_as, 'id', $this->tbl_as, 'a_ruangan_id', 'left');
    $this->db->join($this->tbl5, $this->tbl5_as, 'id', $this->tbl_as, 'a_jpenilaian_id', 'left');
    $this->db->join($this->tbl6, $this->tbl6_as, 'id', $this->tbl2_as, 'a_jabatan_id', 'left');
    $this->db->join($this->tbl7, $this->tbl7_as, 'id', $this->tbl3_as, 'a_jabatan_id', 'left');

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
    $this->db->order_by($sortCol, $sortDir)->page($page, $pagesize);
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

  public function datasets($b_user_id = '', $b_user_id_penilai = '', $a_jpenilaian_id = '', $a_ruangan_id = '', $sdate = '', $edate = '', $keyword = '', $is_active = '')
  {
    $this->db->select_as("$this->tbl2_as.fnama", "nama", 0);
    $this->db->select_as("SUM($this->tbl_as.nilai)", "nilai", 0);
    $this->db->select_as("COUNT($this->tbl_as.nilai)*10", "jumlah", 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->join_company();
    $this->filters($b_user_id, $b_user_id_penilai, $a_jpenilaian_id, $a_ruangan_id, $sdate, $edate, $keyword, $is_active)->scoped();
    $this->db->group_by("$this->tbl_as.b_user_id");
    return $this->db->get();
  }

  public function asesmen_series($penilai_id, $jenis_penilaian)
  {
    $this->db->select_as("DAY($this->tbl_as.cdate)", "day", 0);
    $this->db->select_as("SUM($this->tbl_as.nilai)", "nilai", 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->where_as("$this->tbl_as.b_user_id_penilai", $penilai_id);
    $this->db->where_as("$this->tbl_as.a_jpenilaian_id", $jenis_penilaian);
    $this->db->group_by("day");
    return $this->db->get();
  }

  public function chart_series($jenis_penilaian)
  {
    $this->db->select_as("MONTH($this->tbl_as.cdate)", "month", 0);
    $this->db->select_as("SUM($this->tbl_as.nilai) / COUNT($this->tbl_as.nilai)", "nilai", 0);
    $this->db->select_as("$this->tbl_as.a_ruangan_id", "a_ruangan_id", 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->where_as("$this->tbl_as.a_jpenilaian_id", $jenis_penilaian);
    $this->db->where_as("MONTH($this->tbl_as.cdate)", date('m'));
    $this->db->group_by("$this->tbl_as.a_ruangan_id, month");
    return $this->db->get();
  }

  public function setMass($dis)
  {
    return $this->db->insert_multi($this->tbl, $dis);
  }

  public function getByFilter($user_id, $penilai_id, $ajm_id, $sdate, $edate)
  {
    $this->db->where('b_user_id', $user_id)->where('b_user_id_penilai', $penilai_id);
    $this->db->where('a_jpenilaian_id', $ajm_id);
    $this->db->between("DATE($this->tbl_as.cdate)", "DATE('$sdate')", "DATE('$edate')");
    return $this->db->get('', 0);
  }

  public function print($page = '', $pagesize = '', $sortCol = "id", $sortDir = "ASC", $b_user_id = '', $b_user_id_penilai = '', $a_jpenilaian_id = '', $a_ruangan_id = '', $sdate = '', $edate = '', $keyword = '', $is_active = '')
  {
    $this->datatables[$this->point_of_view]->selections($this->db);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->join_company();
    $this->filters($b_user_id, $b_user_id_penilai, $a_jpenilaian_id, $a_ruangan_id, $sdate, $edate, $keyword, $is_active)->scoped();
    $this->db->order_by("$this->tbl_as.cdate", "ASC")->order_by("$this->tbl_as.b_user_id", "ASC");
    if (strlen($page) && strlen($pagesize)) $this->db->limit($page, $pagesize);
    return $this->db->get("object", 0);
  }

  public function print_ppi($page = '', $pagesize = '', $sortCol = "id", $sortDir = "ASC", $b_user_id = '', $b_user_id_penilai = '', $a_jpenilaian_id = '', $a_ruangan_id = '', $sdate = '', $edate = '', $keyword = '', $is_active = '')
  {
    $this->datatables[$this->point_of_view]->selections($this->db);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->join_company();
    $this->filters($b_user_id, $b_user_id_penilai, $a_jpenilaian_id, $a_ruangan_id, $sdate, $edate, $keyword, $is_active)->scoped();
    $this->db->order_by('a_ruangan_id', 'ASC')->order_by('cdate', 'ASC');
    if (strlen($page) && strlen($pagesize)) $this->db->limit($page, $pagesize);
    return $this->db->get("object", 0);
  }

  public function delById($id)
  {
    $this->db->where('id', $id);
    return $this->db->delete($this->tbl);
  }

  public function getByDateAndUser($ajm_id, $sdate, $penilai_id, $b_user_id = '', $a_ruangan_id = '')
  {
    $this->db->where('b_user_id_penilai', $penilai_id);
    $this->db->where('a_jpenilaian_id', $ajm_id);
    if (strlen($b_user_id)) $this->db->where('b_user_id', $b_user_id);
    if (strlen($a_ruangan_id)) $this->db->where('a_ruangan_id', $a_ruangan_id);
    $this->db->where_as("DATE($this->tbl_as.cdate)", "DATE('$sdate')");
    return $this->db->get_first('', 0);
  }
}
