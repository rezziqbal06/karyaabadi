<?php
//api_front
class B_User_Module_Model extends \Model\B_User_Module_Concern
{
	var $tbl 	= 'b_user_module';
	var $tbl_as = 'bumod';

	public function __construct()
	{
		parent::__construct();
		$this->db->from($this->tbl, $this->tbl_as);
	}

	public function setMass($dis)
	{
		return $this->db->insert_multi($this->tbl, $dis);
	}

	public function getByUserId($b_user_id)
	{
		$this->db->select();
		$this->db->from($this->tbl, $this->tbl_as);
		$this->db->where("b_user_id", $b_user_id);
		return $this->db->get("", 0);
	}


	public function updateByUserId($du, $b_user_id, $identifier = "")
	{
		if (!is_array($du)) return 0;
		$this->db->where("b_user_id", $b_user_id);
		return $this->db->update($this->tbl, $du, 0);
	}

	public function delByUserId($b_user_id)
	{
		$this->db->where("b_user_id", $b_user_id);
		return $this->db->delete($this->tbl);
	}

	public function delByPenilaianDanJabatan($a_jpenilaian_id = [], $a_jabatan_id = "")
	{
		$this->db->where_in("a_jpenilaian_id", $a_jpenilaian_id);
		$this->db->where("a_jabatan_id", $a_jabatan_id);
		return $this->db->delete($this->tbl);
	}

	public function delByPenilaianDanUser($a_jpenilaian_id = [], $b_user_id = "")
	{
		$this->db->where_in("a_jpenilaian_id", $a_jpenilaian_id);
		$this->db->where("b_user_id", $b_user_id);
		return $this->db->delete($this->tbl);
	}
}
