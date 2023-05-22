<?php

namespace Model\Front\API;

register_namespace(__NAMESPACE__);
/**
 * Scoped `api_front` model for `a_trackstat_jne` table
 *
 * @version 5.4.1
 *
 * @package Model\Front\API
 * @since 1.0.0
 */
class A_Trackstat_Jne_Model extends \Model\A_Trackstat_Jne_Concern
{

	public function __construct()
	{
		parent::__construct();
		$this->db->from($this->tbl, $this->tbl_as);
	}

	public function getByCode($code)
	{
		$this->db->where('pod_code', $code);
		return $this->db->get_first('object', 0);
	}
}
