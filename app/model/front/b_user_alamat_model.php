<?php

namespace Model\Admin;

register_namespace(__NAMESPACE__);
/**
 * Scoped `front` model for `b_user_alamat` table
 *
 * @version 5.4.1
 *
 * @package Model\Front
 * @since 1.0.0
 */
class B_User_Alamat_Model extends \Model\B_User_Alamat_Concern
{
  public function __construct()
  {
    parent::__construct();
    $this->db->from($this->tbl, $this->tbl_as);
  }
  private function _filter($keyword)
  {
    if (strlen($keyword) > 0) {
      $this->db->where("nama_alamat", $keyword, "OR", "%like%", 1, 0);
      $this->db->where("kelurahan", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("kecamatan", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("kabkota", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("provinsi", $keyword, "OR", "%like%", 0, 1);
    }
  }
  public function getAllByUserId($b_user_id = "", $page = 0, $pagesize = 10, $sortCol = "id", $sortDir = "DESC", $keyword = "")
  {
    if (empty($b_user_id)) return array();
    $this->db->select('id');
    $this->db->select('nama');
    $this->db->select('alamat');
    $this->db->select('kecamatan');
    $this->db->select('kabkota');
    $this->db->select('provinsi');
    $this->db->select('kodepos');
    $this->db->select('kode_destination');
    $this->db->select('is_default');
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->where("b_user_id", $b_user_id);
    $this->scoped()->_filter($keyword);
    $this->db->order_by('is_default', 'desc');
    $this->db->order_by($sortCol, $sortDir)->limit($page, $pagesize);
    return $this->db->get('object', 0);
  }
  public function countAllByUserId($keyword = "", $b_user_id = "")
  {
    if (empty($b_user_id)) return 0;
    $this->db->select_as("COUNT(*)", 'total', 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->where("b_user_id", $b_user_id);
    if (strlen($keyword) > 0) {
      $this->db->where("nama_alamat", $keyword, "OR", "%like%", 1, 0);
      $this->db->where("kelurahan", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("kecamatan", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("kabkota", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("provinsi", $keyword, "OR", "%like%", 0, 1);
    }
    $d = $this->db->get_first('object', 0);
    if (isset($d->total)) return $d->total;
    return 0;
  }
  public function updateByUserId($b_user_id, $b_user_alamat_id, $du)
  {
    $this->db->where("id", $b_user_alamat_id);
    $this->db->where("b_user_id", $b_user_id);
    return $this->db->update($this->tbl, $du, 0);
  }
  public function deleteByIdAndUserId($id, $b_user_id)
  {
    $this->db->where("id", $id);
    $this->db->where("b_user_id", $b_user_id);
    return $this->db->delete($this->tbl);
  }
  public function setDefault($b_user_id, $b_user_alamat_id)
  {
    //set all default to false
    $du = array();
    $du['is_default'] = 0;
    $this->db->where('b_user_id', $b_user_id);
    $this->db->update($this->tbl, $du);

    //set the default one
    $du = array();
    $du['is_default'] = 1;
    $this->db->where('b_user_id', $b_user_id);
    $this->db->where('id', $b_user_alamat_id);
    return $this->db->update($this->tbl, $du);
  }
  public function get($page = 1, $pagesize = 10, $sortCol = "date", $sortDir = "DESC", $keyword = "")
  {
    $this->db->flushQuery();
    $this->db->select_as("id", "id", 1)->select_as("CONCAT(`fname`,' ',`lname`)", "Nama Lengkap", 1)->select_as("nip", "NIP")->select_as("bdate", "Tgl Lahir")->select_as("IF(jk=1,'Laki-laki','Perempuan')", "Jenis Kelamin", 1)->select_as("email", "Email")->select_as("phone", "NO HP");
    //$this->db->select_as("telprmh","Telp Rumah")->select_as("alamat","Alamat");
    $this->db->order_by($sortCol, $sortDir);
    $this->db->from($this->tbl)->order_by("fname", "ASC")->order_by("lname", "ASC")->limit($page, $pagesize);
    $this->db->where("utype", "frontend", "AND", "like");
    $this->scoped()->_filter($keyword);
    return $this->db->get("object", 0);
  }
  public function getByIdAndUserId($id, $b_user_id)
  {
    $this->db->where('id', $id)->where('b_user_id', $b_user_id);
    return $this->db->get_first();
  }
  public function getByUserId($id)
  {
    $this->db->where('b_user_id', $id);
    return $this->db->get_first('object', 0);
  }
}
