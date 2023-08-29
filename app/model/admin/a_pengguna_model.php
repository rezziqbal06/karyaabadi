<?php

namespace Model\Admin;

register_namespace(__NAMESPACE__);
class A_Pengguna_Model extends  \Model\A_Pengguna_Concern
{
	var $tbl = 'a_pengguna';
	var $tbl_as = 'ap';
	var $tbl3 = 'c_produk';
	var $tbl3_as = 'cp';
	var $tbl4 = 'd_order';
	var $tbl4_as = 'dor';
	var $tbl5 = 'd_order_detail';
	var $tbl5_as = 'dod';
	var $tbl6 = 'b_kategori';
	var $tbl6_as = 'bk';
	var $tbl7 = 'd_redeem_produk';
	var $tbl7_as = 'drp';
	var $tbl8 = 'd_redeem';
	var $tbl8_as = 'dr';

	var $tbl9 = 'a_company';
	var $tbl9_as = 'ac';
	var $tbl10 = 'a_jabatan';
	var $tbl10_as = 'aj';

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
			->where_as("email", $this->db->esc($username), "OR", "=", 1, 0)
			->where_as("username", $this->db->esc($username), "OR", "=", 0, 1);
		return $this->db->get_first('object', 0); //
	}
	public function checkToken($token, $kind = "api_web")
	{
		$dt = $this->db->where($kind . '_token', $token)->get();
		if (count($dt) > 1) {
			foreach ($dt as $d) {
				$this->setToken($kind, "NULL", $d->id);
			}
			return false;
		} else if (count($dt) == 1) {
			return true;
		} else {
			return false;
		}
	}
	public function checkemail($email, $id = 0)
	{
		$this->db->select_as("COUNT(*)", "jumlah", 0);
		$this->db->where("email", $email);
		if (!empty($id)) {
			$this->db->where("id", $id, 'AND', '!=');
		}
		$d = $this->db->from($this->tbl)->get_first("object", 0);
		if (isset($d->jumlah)) {
			return $d->jumlah;
		}
		return 0;
	}
	public function checknamaperusahaan($np, $id = 0)
	{
		$this->db->select_as("COUNT(*)", "jumlah", 0);
		$this->db->where("nama_perusahaan", $np);
		if (!empty($id)) {
			$this->db->where("id", $id, 'AND', '!=');
		}
		$d = $this->db->from($this->tbl)->get_first("object", 0);
		if (isset($d->jumlah)) {
			return $d->jumlah;
		}
		return 0;
	}
	public function setToken($token, $id, $kind = "api_web")
	{
		$du = array($kind . '_token' => $token);
		return $this->db->where("id", $id)->update($this->tbl, $du);
	}
	public function setAgree($id)
	{
		$du = array('is_agree' => '1');
		return $this->db->where("id", $id)->update($this->tbl, $du);
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

	public function downloadXLS($a_company_id = "")
	{
		$this->db->select_as("$this->tbl_as.id", 'id', 0);
		$this->db->select_as("$this->tbl_as.nama", 'nama', 0);
		$this->db->select_as("$this->tbl_as.nip", 'nip', 0);
		$this->db->select_as("COALESCE($this->tbl9_as.nama,'-')", 'penempatan', 0);
		$this->db->select_as("COALESCE($this->tbl10_as.nama,'-')", 'jabatan', 0);
		$this->db->from($this->tbl, $this->tbl_as);
		$this->db->join($this->tbl9, $this->tbl9_as, "id", $this->tbl_as, 'a_company_id', '');
		$this->db->join($this->tbl10, $this->tbl10_as, "id", $this->tbl_as, 'a_jabatan_id', '');
		$this->db->order_by("$this->tbl_as.nama", "ASC");
		$this->db->where_as("$this->tbl_as.is_active", $this->db->esc("1"));
		if (strlen($a_company_id)) $this->db->where_as("$this->tbl_as.a_company_id", $this->db->esc($a_company_id));
		return $this->db->get('', 0);
	}
	public function getKaryawanAktif()
	{
		$this->db->where('is_active', 1);
		$this->db->order_by('nama', 'asc');
		return $this->db->get();
	}
}
