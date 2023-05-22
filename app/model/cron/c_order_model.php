<?php

namespace Model\Front;

register_namespace(__NAMESPACE__);
/**
 * Scoped `api_front` model for `c_order` table
 *
 * @version 5.4.1
 *
 * @package Model\Front
 * @since 1.0.0
 */
class C_Order_Model extends \Model\C_Order_Concern
{
    public function __construct()
    {
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
        $this->point_of_view = 'cron';
    }

    public function getBookings($udate = "", $limit = "")
    {
        $this->db->select_as("$this->tbl_as.id", 'id', 0);
        $this->db->select_as("$this->tbl_as.kode_tracking", 'kode_tracking', 0);
        $this->db->select_as("$this->tbl_as.no_resi", 'no_resi', 0);
        $this->db->from($this->tbl, $this->tbl_as);
        $this->db->where_as("DATE($this->tbl_as.udate)", 'DATE("' . $udate . '")', "OR", "<", 1, 0);
        $this->db->where_as("$this->tbl_as.udate", 'IS NULL', "AND", "=", 0, 1);
        $this->db->where_as("$this->tbl_as.no_resi", "IS NOT NULL");
        $this->db->where_as("$this->tbl_as.no_resi", "''", "AND", "!=");
        $this->db->where_as("$this->tbl_as.kode_tracking", "D", "AND", "%notlike%");
        $this->db->limit($limit);
        return $this->db->get("object", 0);
    }
}
