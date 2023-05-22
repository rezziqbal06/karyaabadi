<?php


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
	public $tbl = 'b_user';
	public $tbl_as = 'bu';
	public $tbl2 = 'a_ruangan';
	public $tbl2_as = 'ar';
	public $tbl3 = 'a_jabatan';
	public $tbl3_as = 'aj';

	public function __construct()
	{
		parent::__construct();
		$this->db->from($this->tbl, $this->tbl_as);
		$this->point_of_view = 'front';
	}
	public function auth($username)
	{
		$this->db
			->select_as("$this->tbl_as.*, $this->tbl_as.id", 'id', 0)
			->select_as("$this->tbl3_as.nama", 'profesi', 0);
		$this->db->from($this->tbl, $this->tbl_as);
		$this->db->join($this->tbl3, $this->tbl3_as, "id", $this->tbl_as, "a_jabatan_id", "left");

		$this->db->where_as("$this->tbl_as.is_deleted", $this->db->esc(0), "AND")
			->where_as("$this->tbl_as.email", $this->db->esc($username), "OR", "=", 1, 0)
			->where_as("$this->tbl_as.username", $this->db->esc($username), "OR", "=", 0, 1);
		return $this->db->get_first('object', 0); //
	}

	public function getUserById($id)
	{
		$this->db->select_as("$this->tbl_as.*, $this->tbl_as.id", 'id', 0);
		$this->db->select_as("COALESCE($this->tbl2_as.nama, '')", 'ruangan', 0);
		$this->db->select_as("COALESCE($this->tbl3_as.nama, '')", 'profesi', 0);
		$this->db->join($this->tbl2, $this->tbl2_as, "id", $this->tbl_as, "a_unit_id", "left");
		$this->db->join($this->tbl3, $this->tbl3_as, "id", $this->tbl_as, "a_jabatan_id", "left");
		$this->db->from($this->tbl, $this->tbl_as);
		$this->db->where("bu.id", $id);
		return $this->db->get_first('object', 0);
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

	private function _filter($b_user_id = '', $keyword = '', $is_active = '', $sdate = '', $edate = '')
	{
		if (strlen($b_user_id)) {
			$this->db->where_as("$this->tbl_as.b_user_id", $this->db->esc($b_user_id));
		}
		if (strlen($is_active)) {
			$this->db->where_as("$this->tbl_as.is_active", $this->db->esc($is_active));
		}
		if (strlen($keyword) > 0) {
			$this->db->where_as("$this->tbl_as.fnama", $keyword, "OR", "%like%", 1, 0);
			$this->db->where_as("$this->tbl_as.telp", $keyword, "AND", "%like%", 0, 0);
			$this->db->where_as("$this->tbl_as.email", $keyword, "AND", "%like%", 0, 0);
			$this->db->where_as("$this->tbl_as.alamat", $keyword, "AND", "%like%", 0, 1);
		}
		if (strlen($sdate) == 10 && strlen($edate) == 10) {
			$this->db->between("DATE($this->tbl_as.cdate)", 'DATE("' . $sdate . '")', 'DATE("' . $edate . '")');
		} elseif (strlen($sdate) != 10 && strlen($edate) == 10) {
			$this->db->where_as("DATE($this->tbl_as.cdate)", 'DATE("' . $edate . '")', "AND", '<=');
		} elseif (strlen($sdate) == 10 && strlen($edate) != 10) {
			$this->db->where_as("DATE($this->tbl_as.cdate)", 'DATE("' . $sdate . '")', "AND", '>=');
		}
		return $this;
	}

	public function data($b_user_id = "", $page = 0, $pagesize = 10, $sortCol = "id", $sortDir = "ASC", $keyword = '', $is_active = '', $sdate = '', $edate = '')
	{
		$this->datatables['download']->selections($this->db);
		$this->db->from($this->tbl, $this->tbl_as);
		$this->db->join($this->tbl2, $this->tbl2_as, 'b_user_id', $this->tbl_as, 'id');
		$this->scoped()->_filter($b_user_id, $keyword, $is_active, $sdate, $edate);
		$this->db->order_by($sortCol, $sortDir)->limit($page, $pagesize);
		return $this->db->get("object", 0);
	}
	public function getAll($is_active = 1)
	{
		$this->db->where('is_active', $is_active);
		$this->db->where('is_deleted', $this->db->esc(0));
		return $this->db->get('', 0);
	}

	public function getByApiWeb($api_web_token)
	{
		$this->db->where('api_web_token', $api_web_token);
		$this->db->from($this->tbl, $this->tbl_as);
		return $this->db->get_first('object', 0);
	}
}
