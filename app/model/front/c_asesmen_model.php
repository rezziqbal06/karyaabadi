<?php


register_namespace(__NAMESPACE__);
/**
 * Scoped `front` model for `b_user` table
 *
 * @version 5.4.1
 *
 * @package Model\Front
 * @since 1.0.0
 */
class C_Asesmen_Model extends \Model\C_Asesmen_Concern
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

	public function getByUserPenilaiId($user_id,$jenis_penilaian)
	{
		$this->db->select_as("COUNT($this->tbl_as.id)","count",0);
		$this->db->from($this->tbl, $this->tbl_as);
		$this->db->where_as("$this->tbl_as.b_user_id_penilai",$user_id);
		$this->db->where_as("$this->tbl_as.a_jpenilaian_id",$jenis_penilaian);
		return $this->db->get_first();
	}
}
