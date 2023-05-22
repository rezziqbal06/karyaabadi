<?php
/**
* Core class for authentication controller
*   contains authentication purpose methods that nice to have in all controllers
*
* @version 1.0.0
*
* @package Core\Authentication
* @since 1.0.0
*/
class Authentication_Controller extends \JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setTheme('authentication');
        $this->lib('conumtext');
        $this->load('authentication_model', 'auth_model');
        $this->auth_model->table($this->config->semevar->authentication->table);
        $this->send_email = $this->config->semevar->authentication->send_email;
    }
}
