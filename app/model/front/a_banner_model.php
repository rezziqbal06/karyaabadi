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
class A_Banner_Model extends \Model\A_Banner_Concern
{

	public function __construct()
	{
		parent::__construct();
		$this->db->from($this->tbl, $this->tbl_as);
		$this->point_of_view = 'front';
	}

	public function getAll($is_active = 1, $is_deleted = 0)
	{
		$this->db->where('is_active', $is_active);
		$this->db->where('is_deleted', $this->db->esc($is_deleted));
		return $this->db->get('', 0);
	}

	public function getBySlug($slug = '')
	{
		$this->db->select('id')->select('nama')->select('slug')->select('deskripsi')->select('gambar');
		if (strlen($slug)) $this->db->where('slug', $slug);
		return $this->db->get_first('', 0);
	}

	public function getLainnya($id = '')
	{
		$this->db->select('id')->select('nama')->select('slug')->select('gambar');
		if (strlen($id)) $this->db->where('id', $id, 'AND', '<>');
		$this->db->where('is_active', 1);
		$this->db->where('is_deleted', $this->db->esc(0));
		return $this->db->get('', 0);
	}
}
