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
		$this->point_of_view = 'front';
	}

	public function getAll($is_active = 1, $is_deleted = 0)
	{
		$this->db->select('id')->select('slug')->select('gambar')->select('judul')->select('kategori')->select('cdate');
		$this->db->where('is_active', $is_active);
		$this->db->where('is_deleted', $this->db->esc($is_deleted));
		return $this->db->get('', 0);
	}
}
