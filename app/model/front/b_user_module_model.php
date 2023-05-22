<?php
//front
class B_User_Module_Model extends \Model\B_User_Module_Concern
{
	var $tbl 	= 'b_user_module';
	var $tbl_as = 'bumod';

	public function __construct()
	{
		parent::__construct();
		$this->db->from($this->tbl, $this->tbl_as);
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
