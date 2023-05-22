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
class A_Company_Model extends \Model\A_Company_Concern
{
    public function __construct()
    {
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
        $this->point_of_view = 'admin';
    }

    public function getByUserId($id)
    {
        $this->db->where('b_user_id_owner', $id);
        return $this->db->get_first('object', 0);
    }
}
