<?php

namespace Model\Admin;

register_namespace(__NAMESPACE__);
/**
 * Scoped `front` model for `b_user` table
 *
 * @version 5.4.1
 *
 * @package Model\Front
 * @since 1.0.0
 */
class A_Blog_Model extends \Model\A_Blog_Concern
{
  public function __construct()
  {
    parent::__construct();
    $this->db->from($this->tbl, $this->tbl_as);
    $this->point_of_view = 'admin';
  }

  private function filters($b_user_id = '', $keyword = '', $is_active = '', $a_unit_id = '')
  {
    // if (strlen($b_user_id)) {
    //   $this->db->where_as("$this->tbl_as.b_user_id", $this->db->esc($b_user_id));
    // }
    if (strlen($is_active)) {
      $this->db->where_as("$this->tbl_as.is_active", $this->db->esc($is_active));
    }
    // if (strlen($a_unit_id)) {
    //   $this->db->where_as("$this->tbl_as.a_unit_id", $this->db->esc($a_unit_id));
    // }
    if (strlen($keyword) > 0) {
      $this->db->where_as("$this->tbl_as.judul", $keyword, "OR", "%like%", 1, 0);
      $this->db->where_as("$this->tbl_as.text", $keyword, "AND", "%like%", 0, 1);
    }
    return $this;
  }



  public function data($b_user_id = "", $page = 0, $pagesize = 10, $sortCol = "id", $sortDir = "ASC", $keyword = '', $is_active = '', $a_unit_id = '')
  {
    $this->datatables[$this->point_of_view]->selections($this->db);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->filters($b_user_id, $keyword, $is_active, $a_unit_id)->scoped();
    $this->db->order_by($sortCol, $sortDir)->limit($page, $pagesize);
    return $this->db->get("object", 0);
  }

  public function count($b_user_id = '', $keyword = '', $is_active = '', $a_unit_id = '')
  {
    $this->db->select_as("COUNT($this->tbl_as.id)", "jumlah", 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->filters($b_user_id, $keyword, $is_active, $a_unit_id)->scoped();
    $d = $this->db->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }


  public function cari($keyword = "")
  {
    $this->db->select_as("$this->tbl_as.id", "id", 0);
    $this->db->select_as("CONCAT($this->tbl_as.fjudul,' - ', $this->tbl_as.email)", "text", 0);
    $this->db->from($this->tbl, $this->tbl_as);
    if (strlen($keyword) > 0) {
      $this->db->where_as("$this->tbl_as.fjudul", ($keyword), "OR", "LIKE%%", 1, 0);
      $this->db->where_as("$this->tbl_as.username", ($keyword), "OR", "LIKE%%", 0, 0);
      $this->db->where_as("$this->tbl_as.email", ($keyword), "OR", "LIKE%%", 0, 1);
    }
    $this->db->order_by("$this->tbl_as.fjudul", "asc");
    return $this->db->get('', 0);
  }
}
