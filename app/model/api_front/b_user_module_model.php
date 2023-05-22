<?php
//api_front
class B_User_Module_Model extends SENE_Model
{
	var $tbl 	= 'b_user_module';
	var $tbl_as = 'bumod';

	public function __construct()
	{
		parent::__construct();
		$this->db->from($this->tbl, $this->tbl_as);
	}

	public function checkByUserId($b_user_id, $identifier)
	{
		$this->db->select_as("COUNT(*)", "jumlah", 0);
		$this->db->where("b_user_id", $b_user_id);
		$this->db->where("a_modules_identifier", $identifier);
		$d = $this->db->from($this->tbl)->get_first("object", 0);
		if (isset($d->jumlah)) return $d->jumlah;
		return 0;
	}

	public function getByUserId($b_user_id)
	{
		$this->db->select();
		$this->db->from($this->tbl, $this->tbl_as);
		$this->db->where("b_user_id", $b_user_id);
		$this->db->where("rule", "allowed_except", "AND", "!=");
		return $this->db->get("", 0);
	}

	public function set($di)
	{
		if (!is_array($di)) return 0;
		$this->db->insert($this->tbl, $di, 0, 0);
		return $this->db->last_id;
	}

	public function update($id, $du, $filter = "")
	{
		if (!is_array($du)) return 0;
		if (empty($filter)) {
			$this->db->where("id", $id);
		} else {
			foreach ($filter as $flt => $flt_val) {
				$this->db->where($flt, $flt_val);
			}
		}
		return $this->db->update($this->tbl, $du, 0);
	}

	public function del($id, $filter = "")
	{
		if (empty($filter)) {
			$this->db->where("id", $id);
		} else {
			foreach ($filter as $flt => $flt_val) {
				$this->db->where($flt, $flt_val);
			}
		}
		return $this->db->delete($this->tbl);
	}

	public function updateByUserId($du, $b_user_id, $identifier = "")
	{
		if (!is_array($du)) return 0;
		$this->db->where("b_user_id", $b_user_id);
		if (!empty($identifier)) $this->db->where("a_modules_identifier", $identifier);
		$this->db->where("rule", "allowed_except", "AND", "!=");
		return $this->db->update($this->tbl, $du, 0);
	}

	public function delByUserId($b_user_id)
	{
		$this->db->where("b_user_id", $b_user_id);
		$this->db->where("tmp_active", "N");
		$this->db->where("rule", "allowed_except", "AND", "!=");
		return $this->db->delete($this->tbl);
	}
	public function getUserModules($b_user_id)
	{
		$sql = "SELECT *, COALESCE(`a_modules_identifier`,'') AS module FROM $this->tbl WHERE `b_user_id` = " . $this->db->esc($b_user_id) . " ORDER BY a_modules_identifier ASC";
		return $this->db->query($sql);
	}

	public function setMass($ds)
	{
		return $this->db->insert($this->tbl, $ds, 1, 0);
	}

	public function getPermission($a_jpenilaian_id = "", $type = "create", $a_jabatan_id = "", $b_user_id = "")
	{
		$this->db->where("a_jpenilaian_id", $a_jpenilaian_id);
		$this->db->where("type", $type);
		$this->db->where("a_jabatan_id", $a_jabatan_id, "OR", "=", 1, 0);
		$this->db->where("b_user_id", $b_user_id, "OR", "=", 0, 1);
		$this->db->group_by("type");
		$d = $this->db->get_first($this->tbl);
		if (isset($d->id)) {
			return 1;
		}
		return 0;
	}
}
