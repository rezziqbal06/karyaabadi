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
class C_Order_Model extends \Model\C_Order_Concern
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


	public function countAll($status = "")
	{
		$this->db->select_as("COUNT(*)", 'jumlah', 0);
		$this->db->from($this->tbl, $this->tbl_as);
		$this->db->where_as("$this->tbl_as.is_active", 1, "AND", "=");
		$this->db->where_as("$this->tbl_as.is_deleted", $this->db->esc(0), "AND", "=");
		if (strlen($status)) $this->db->where_as("$this->tbl_as.status", $this->db->esc($status));
		$d = $this->db->get_first("object", 0);
		if (isset($d->jumlah)) {
			return $d->jumlah;
		}
		return 0;
	}

	public function chart($status = "")
	{
		$this->db->select_as("COUNT(*)", 'jumlah', 0);
		$this->db->select_as("DATE_FORMAT($this->tbl_as.tgl_selesai, '%b')", 'bulan', 0);
		$this->db->select_as("SUM($this->tbl_as.total_harga)", 'omset', 0);
		$this->db->from($this->tbl, $this->tbl_as);
		$this->db->where_as("$this->tbl_as.is_active", 1, "AND", "=");
		$this->db->where_as("$this->tbl_as.is_deleted", $this->db->esc(0), "AND", "=");
		$this->db->where_as("YEAR($this->tbl_as.tgl_selesai)", "YEAR(" . $this->db->esc(date("Y-m-d")) . ")");
		if (strlen($status)) $this->db->where_as("$this->tbl_as.status", $this->db->esc($status));
		$this->db->group_by("MONTH($this->tbl_as.tgl_selesai)");
		return $this->db->get("", 0);
	}
}
