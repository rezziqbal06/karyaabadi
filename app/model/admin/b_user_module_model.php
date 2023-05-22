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
class B_User_Module_Model extends \Model\B_User_Module_Concern
{


	public function __construct()
	{
		parent::__construct();
		$this->db->from($this->tbl, $this->tbl_as);
		$this->point_of_view = 'admin';
	}

	public function getAll($is_active = 1)
	{
		$this->db->where('is_active', $is_active);
		return $this->db->get('', 0);
	}

	public function getByJabatanAndUser($jabatan_id = '', $user_id = '')
	{
		if (strlen($jabatan_id)) $this->db->where('a_jabatan_id', $jabatan_id);
		if (strlen($user_id)) $this->db->where('b_user_id', $user_id);
		return $this->db->get('', 0);
	}
}
