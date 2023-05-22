<?php

namespace Model\Admin\API;

register_namespace(__NAMESPACE__);
/**
 * Scoped `api_front` model for `a_page` table
 *
 * @version 5.4.1
 *
 * @package Model\Admin\API
 * @since 1.0.0
 */
class A_Page_Model extends \Model\A_Page_Concern
{

	public function __construct()
	{
		parent::__construct();
		$this->db->from($this->tbl, $this->tbl_as);
	}
	public function getAll($page = 0, $pagesize = 10, $sortCol = "identifier", $sortDir = "ASC", $keyword = "", $sdate = "", $edate = "")
	{
		$this->db->flushQuery();
		$this->db->select_as('identifier,name,path,children_identifier,level,priority,is_active,is_visible', 'is_visible', 0);
		$this->db->from($this->tbl, $this->tbl_as);

		if (strlen($keyword) > 1) {
			$this->db->where("name", $keyword, "OR", "%like%", 1, 0);
			$this->db->where("path", $keyword, "OR", "%like%", 0, 0);
			$this->db->where("identifier", $keyword, "OR", "%like%", 0, 1);
		}
		$this->db->order_by($sortCol, $sortDir)->limit($page, $pagesize);
		return $this->db->get("object", 0);
	}
	public function countAll($keyword = "", $sdate = "", $edate = "")
	{
		$this->db->flushQuery();
		$this->db->select_as("COUNT(*)", "jumlah", 0);
		$this->db->from($this->tbl, $this->tbl_as);

		if (strlen($keyword) > 1) {
			$this->db->where("name", $keyword, "OR", "%like%", 1, 0);
			$this->db->where("path", $keyword, "OR", "%like%", 0, 0);
			$this->db->where("identifier", $keyword, "OR", "%like%", 0, 1);
		}
		$d = $this->db->get_first("object", 0);
		if (isset($d->jumlah)) return $d->jumlah;
		return 0;
	}

	public function getByUserId($id)
	{
		$this->db->where_as("$this->tbl_as.b_user_id", $this->db->esc($id));
		return $this->db->get_first('object', 0);
	}
}
