<?php

/**
* Load manually Generic class for data proxying
*/
require_once(SEMEROOT.'app/core/current_reseller.php');

/**
* Abstract Core class for authentication controller
*   contains reseller by domain purpose methods that nice to have in all controllers
*
* @version 1.0.0
*
* @package ResellerDomain\Core
* @since 1.0.0
*/
abstract class ResellerDomain_Controller extends \SENE_Controller
{
    public $current_reseller;
    public $current_year;

    public function __construct()
    {
        parent::__construct();
        $this->load('resellerdomain_model', 'resellerdomain_model');

        $this->current_reseller = new \Current_Reseller($this->resellerdomain_model->current(), $this->config);
        $this->current_year = date('Y');
        $this->current_reseller_modifier();
    }
    private function current_reseller_modifier()
    {
        $this->current_reseller->site_suffix = $this->current_reseller->site_title_suffix;
    }
    public function current_base_url($another_url='')
    {
        if (isset($this->current_reseller->domain) && strlen($this->current_reseller->domain) > 4) {
            return '//'.$this->current_reseller->domain.'/'.$another_url;
        } else {
            return base_url($another_url);
        }
    }
    public function base_url_reseller($another_url='')
    {
        if (isset($this->current_reseller->domain) && strlen($this->current_reseller->domain) > 4) {
            return '//'.$this->current_reseller->domain.'/'.$another_url;
        } else {
            return base_url_reseller($another_url);
        }
    }
    public function setResellerIdSession($a_company_id)
    {
        $_SESSION[CURRENT_RESELLER_SESSION_KEY] = $a_company_id;

        return $this;
    }
    public function unsetResellerIdSession($a_company_id)
    {
        if (isset($_SESSION[CURRENT_RESELLER_SESSION_KEY])) {
            unset($_SESSION[CURRENT_RESELLER_SESSION_KEY]);
        }

        return $this;
    }
}
