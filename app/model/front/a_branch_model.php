<?php

namespace Model\Admin;

register_namespace(__NAMESPACE__);
/**
 * Scoped `api_front` model for `a_branch` table
 *
 * @version 5.4.1
 *
 * @package Model\Admin
 * @since 1.0.0
 */
class A_Branch_Model extends \Model\A_Branch_Concern
{


    public function __construct()
    {
        parent::__construct();
        $this->db->from($this->tbl, $this->tbl_as);
        $this->point_of_view = 'front';
    }
}
