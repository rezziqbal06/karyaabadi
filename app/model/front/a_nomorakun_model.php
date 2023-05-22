<?php

namespace Model\Front;

register_namespace(__NAMESPACE__);
/**
 * Scoped `api_front` model for `a_nomorakun` table
 *
 * @version 5.4.1
 *
 * @package Model\Admin
 * @since 1.0.0
 */
class A_Nomorakun_Model extends \Model\A_Nomorakun_Concern
{


    public function __construct()
    {
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
        $this->point_of_view = 'front';
    }

    public function get()
    {
        $this->active();
        return $this->db->get('', 0);
    }
}
