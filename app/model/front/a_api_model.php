<?php

namespace Model\Front;

register_namespace(__NAMESPACE__);
/**
 * Scoped `api_front` model for `a_api` table
 *
 * @version 5.4.1
 *
 * @package Model\Front
 * @since 1.0.0
 */
class A_Api_Model extends \Model\A_Api_Concern
{
    public function __construct()
    {
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
        $this->point_of_view = 'front';
    }

    public function get()
    {
        return $this->db->get('', 0);
    }

    public function getByType($type)
    {
        $this->db->where('type', $type);
        return $this->db->get_first('object', 0);
    }
}
