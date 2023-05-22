<?php
/**
* Load manually Supporter class for data modelling
*/
require_once(SEMEROOT.'app/core/seme_flaglabel.php');

/**
* Wrapper Class for generating view element
*
* @version 1.0.0
*
* @package Core\View
* @since 1.0.0
*/
class Seme_ViewModel
{
    public $forms;

    public function __construct()
    {
        $this->forms = array();
    }

    public function html_form_element()
    {

    }
}

class Seme_Form
{
    public $inputs;

    public function __construct()
    {
        $this->inputs = array();
    }

    public function html()
    {

    }
}

class Seme_Input
{
    public $parent_open;
    public $parent_close;
    public $wrapper_open;
    public $wrapper_close;

    public function __construct()
    {
        $this->parent_open = '';
        $this->parent_close = '';
        $this->wrapper_open = '';
        $this->wrapper_close = '';
    }
}
