<?php

namespace Model\Admin;

register_namespace(__NAMESPACE__);
/**
 * Scoped `front` model for `B_Produk` table
 *
 * @version 5.4.1
 *
 * @package Model\Front
 * @since 1.0.0
 */
class B_Produk_Model extends \Model\B_Produk_Concern
{


	public function __construct()
	{
		parent::__construct();
		$this->db->from($this->tbl, $this->tbl_as);
		$this->point_of_view = 'admin';
	}

	public function getAll()
	{
		$this->db->where_as("$this->tbl_as.is_active", 1, "AND", "=");
		$this->db->where_as("$this->tbl_as.is_deleted", $this->db->esc(0), "AND", "=");
		return $this->db->get('', 0);
	}

	public function countAll()
	{
		$this->db->select_as("COUNT(*)", 'jumlah', 0);
		$this->db->where_as("$this->tbl_as.is_active", 1, "AND", "=");
		$this->db->where_as("$this->tbl_as.is_deleted", $this->db->esc(0), "AND", "=");
		$d = $this->db->get_first("object", 0);
		if (isset($d->jumlah)) {
			return $d->jumlah;
		}
		return 0;
	}
}
