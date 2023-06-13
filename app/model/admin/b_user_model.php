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
class B_User_Model extends \Model\B_User_Concern
{


	public function __construct()
	{
		parent::__construct();
		$this->db->from($this->tbl, $this->tbl_as);
		$this->point_of_view = 'admin';
	}
	public function auth($username)
	{
		$this->db
			->select("*")
			->where_as("email", $this->db->esc($username), "OR")
			->where_as("username", $this->db->esc($username), "OR");
		return $this->db->get_first('object', 0); //
	}

	public function getByCompanyId($company_id, $mindate, $maxdate)
	{
		$this->db->select_as("$this->tbl9_as.nama", 'penempatan', 0);
		$this->db->select_as("$this->tbl10_as.nama", 'jabatan', 0);
		$this->db->select_as("$this->tbl_as.nip", 'nip', 0);
		$this->db->select_as("$this->tbl_as.nama", 'nama', 0);
		$this->db->from($this->tbl, $this->tbl_as);
		$this->db->join($this->tbl9, $this->tbl9_as, 'id', $this->tbl_as, 'a_company_id', 'left');
		$this->db->join($this->tbl10, $this->tbl10_as, 'id', $this->tbl_as, 'a_jabatan_id', 'left');
		if (strlen($company_id) > 0) $this->db->where_as("$this->tbl_as.a_company_id", $this->db->esc($company_id));

		if (strlen($mindate) == 10 && strlen($maxdate) == 10) {
			$this->db->between("DATE($this->tbl_as.cdate)", 'DATE("' . $mindate . '")', 'DATE("' . $maxdate . '")');
		} elseif (strlen($mindate) != 10 && strlen($maxdate) == 10) {
			$this->db->where_as("DATE($this->tbl_as.cdate)", 'DATE("' . $maxdate . '")', "AND", '<=');
		} elseif (strlen($mindate) == 10 && strlen($maxdate) != 10) {
			$this->db->where_as("DATE($this->tbl_as.cdate)", 'DATE("' . $mindate . '")', "AND", '>=');
		}
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
