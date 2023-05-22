<?php

namespace Model\Front;

register_namespace(__NAMESPACE__);
/**
 * Scoped `api_front` model for `a_company` table
 *
 * @version 5.4.1
 *
 * @package Model\Front
 * @since 1.0.0
 */
class A_Partner_Model extends \Model\A_Partner_Concern
{


	public function __construct()
	{
		parent::__construct();
		$this->db->from($this->tbl, $this->tbl_as);
		$this->point_of_view = 'front';
	}

	public function getAll($is_active = 1)
	{
		$this->db->where('is_active', $is_active);
		return $this->db->get('', 0);
	}

	public function get()
	{
		$this->db->where('is_active', '1');
		return $this->db->get();
	}

	public function getByUserId($id)
	{
		$this->db->where('b_user_id_owner', $id);
		return $this->db->get_first('object', 0);
	}
}
