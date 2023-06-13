<?php

namespace Model\Admin;

register_namespace(__NAMESPACE__);
/**
 * Scoped `front` model for `C_Order` table
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

	public function getAll()
	{
		$this->db->where('is_active', 1);
		return $this->db->get('');
	}

	public function getByOrder($id)
	{
		$this->db->where('c_order_id', $id);
		return $this->db->get('');
	}


	public function getBulanIni()
	{
		$this->db->select_as("$this->tbl_as.*, $this->tbl_as.id", 'id');
		$this->db->select_as("COALESCE($this->tbl2_as.kode, '')", 'kode');
		$this->db->select_as("COALESCE($this->tbl3_as.nama, '')", 'produk');
		$this->db->select_as("COALESCE($this->tbl5_as.fnama, '')", 'pembeli');
		$this->db->from($this->tbl, $this->tbl_as);
		$this->db->join($this->tbl2, $this->tbl2_as, "id", $this->tbl_as, "c_order_id", "left");
		$this->db->join($this->tbl3, $this->tbl3_as, "id", $this->tbl_as, "b_produk_id", "left");
		$this->db->join($this->tbl5, $this->tbl5_as, "id", $this->tbl2_as, "b_user_id", "left");
		$this->db->where_as("$this->tbl_as.is_active", 1);
		$this->db->where_as("$this->tbl_as.is_deleted", $this->db->esc(0));
		$this->db->where_as("MONTH($this->tbl_as.tgl_pesan)", "MONTH(" . $this->db->esc(date("Y-m-d")) . ")");
		return $this->db->get('');
	}
}
