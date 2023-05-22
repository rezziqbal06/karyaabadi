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
class A_kategori_Model extends \Model\A_kategori_Concern
{


	public function __construct()
	{
		parent::__construct();
		$this->db->from($this->tbl, $this->tbl_as);
		$this->point_of_view = 'admin';
	}

	public function getAll($is_active = 1)
	{
		$this->db->select('id')->select('nama')->select('slug')->select('type_form');
		$this->db->where('is_active', $is_active);
		return $this->db->get('', 0);
	}

	public function getBySlug($slug = '')
	{
		$this->db->select('id')->select('nama')->select('slug')->select('type_form')->select('deskripsi');
		if (strlen($slug)) $this->db->where('slug', $slug);
		return $this->db->get_first('', 0);
	}


	public function getAllPermit($a_jabatan_id, $b_user_id, $type = "create")
	{
		$this->db->select_as("$this->tbl_as.*, $this->tbl_as.id", 'id', 0);
		$this->db->from($this->tbl, $this->tbl_as);
		$this->db->join($this->tbl2, $this->tbl2_as, "a_kategori_id", $this->tbl_as, "id");
		$this->db->where("$this->tbl2_as.type", $type);
		$this->db->where_as("$this->tbl2_as.a_jabatan_id", $a_jabatan_id, 'OR', '=', 1, 0);
		$this->db->where_as("$this->tbl2_as.b_user_id", $b_user_id, 'OR', '=', 0, 1);
		$this->db->group_by("$this->tbl_as.id");
		return $this->db->get('', 0);
	}
}
