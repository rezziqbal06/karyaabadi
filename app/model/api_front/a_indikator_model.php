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
class A_Indikator_Model extends \Model\A_Indikator_Concern
{
  public $tbl2 = 'a_jabatan';
  public $tbl2_as = 'j';
  public function __construct()
  {
    parent::__construct();
    $this->db->from($this->tbl, $this->tbl_as);
    $this->point_of_view = 'front';
  }

  public function getByPenilaianId($id)
  {
    $this->db->where('a_jpenilaian_id', $id);
    return $this->db->get('', 0);
  }
  public function getByIndikator($id, $jp_id)
  {
    $this->db->select("*");
    $this->db->where_as("$this->tbl_as.a_jpenilaian_id", $jp_id);
    $this->db->where_as("$this->tbl_as.a_ruangan_ids", '"' . $id . '"', "AND", "%like%");
    return $this->db->get('', 0);
  }
  public function getByPenilaian($type, $jp_id)
  {
    $this->db->select("id");
    $this->db->where("a_jpenilaian_id", $jp_id);
    $this->db->where("type", $type);
    return $this->db->get('', 0);
  }
}
