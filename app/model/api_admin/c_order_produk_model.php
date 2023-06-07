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
class C_Order_Produk_Model extends \Model\C_Order_Produk_Concern
{
  public function __construct()
  {
    parent::__construct();
    $this->db->from($this->tbl, $this->tbl_as);
    $this->point_of_view = 'admin';
  }

  private function filters($keyword = '', $is_active = '')
  {
    // if (strlen($b_user_id)) {
    //   $this->db->where_as("$this->tbl_as.b_user_id", $this->db->esc($b_user_id));
    // }
    if (strlen($is_active)) {
      $this->db->where_as("$this->tbl_as.is_active", $this->db->esc($is_active));
    }
    if (strlen($keyword) > 0) {
      $this->db->where_as("$this->tbl_as.kode", $keyword, "OR", "%like%", 1, 0);
      $this->db->where_as("$this->tbl_as.total_harga", $keyword, "AND", "%like%", 0, 0);
      $this->db->where_as("$this->tbl5_as.fnama", $keyword, "AND", "%like%", 0, 0);
      $this->db->where_as("$this->tbl3_as.nama", $keyword, "AND", "%like%", 0, 1);
    }
    return $this;
  }

  private function join_company()
  {
    $this->db->join($this->tbl2, $this->tbl2_as, 'c_order_id', $this->tbl_as, 'id', 'left');
    $this->db->join($this->tbl3, $this->tbl3_as, 'id', $this->tbl2_as, 'b_produk_id', 'left');
    $this->db->join($this->tbl4, $this->tbl4_as, 'id', $this->tbl2_as, 'b_produk_id_harga', 'left');
    $this->db->join($this->tbl5, $this->tbl5_as, 'id', $this->tbl_as, 'b_user_id', 'left');
    return $this;
  }



  public function data($page = 0, $pagesize = 10, $sortCol = "id", $sortDir = "ASC", $keyword = '', $is_active = '')
  {
    $this->datatables[$this->point_of_view]->selections($this->db);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->join_company();
    $this->filters($keyword, $is_active)->scoped();
    $this->db->order_by($sortCol, $sortDir)->limit($page, $pagesize);
    return $this->db->get("object", 0);
  }

  public function count($b_user_id = '', $keyword = '', $is_active = '')
  {
    $this->db->select_as("COUNT($this->tbl_as.id)", "jumlah", 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->join_company();
    $this->filters($keyword, $is_active)->scoped();
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

  public function delByOrder($id)
  {
    $this->db->where('c_order_id', $id);
    return $this->db->delete($this->tbl);
  }
}
