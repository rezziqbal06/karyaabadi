<?php
 /**
 * Data model wrapper for providing data reseller by domain name
 *
 * @version 1.0.0
 *
 * @package ResellerDomain\Model
 * @since 1.0.0
 */
class ResellerDomain_Model extends \JI_Model
{
    private $reseller = 'a_company';
    public $reseller_as;

    public function __construct()
    {
        parent::__construct();
        $this->reseller_as = $this->reseller.'_as';
        $this->db->from($this->reseller, $this->reseller_as);
    }

    private function domain_name()
    {
        return isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
    }

    public function scoped()
    {
        $this->db->where_as('is_deleted', $this->db->esc('0'))->where('is_active', '1');
        $this->db->order_by('id', 'asc');

        return $this;
    }

    private function checkFromSession()
    {
        if (isset($_SESSION['current_reseller_id']) && intval($_SESSION['current_reseller_id']) > 0) {
            return intval($_SESSION['current_reseller_id']);
        }
        return 0;
    }

    private function defaultReseller()
    {
        $this->db->flushQuery();
        return $this->scoped()->db->get_first('', 0);
    }

    public function current()
    {
        $reseller = new \stdClass();
        if ($a_company_id = $this->checkFromSession()) {
            $this->db->flushQuery();
            $reseller = $this->scoped()->db->where('id', $a_company_id)->get_first('', 0);
        } else {
            $domain = $this->domain_name();
            $this->db->where('domain', $domain, 'OR', 'like', 1, 0)->where('subdomain', $domain, 'AND', 'like', 0, 1);
            $reseller = $this->scoped()->db->get_first('', 0);
            if (!isset($reseller->id) && !$this->config->semevar->domain_strict) {
                $reseller = $this->defaultReseller();
            }
        }
        if (!isset($reseller->id) && $this->config->semevar->domain_strict) {
            redir('notfound');
            die();
        }
        
        return $reseller;
    }
}
