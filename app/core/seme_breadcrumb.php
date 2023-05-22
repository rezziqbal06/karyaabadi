<?php
/**
* Wrapper Class for generating main breadcrumb
*
* @version 1.0.0
*
* @package Core\View
* @since 1.0.0
*/
class Seme_BreadCrumb
{
    public $wrapper_open = '<ul class="breadcrumb breadcrumb-top">';
    public $wrapper_close = '</ul>';
    public $contents;

    public function __construct()
    {
        $this->contents = array();
    }

    public function add($content = \Seme_BreadCrumbItem)
    {
        $this->contents[] = $content;
    }

    public function html()
    {
        $content = '';
        foreach ($this->contents as $c) {
            $content .= $c->html();
        }
        return $this->wrapper_open.' '.$content.' '.$this->wrapper_close;
    }
}

class Seme_BreadCrumbItem
{
    public $wrapper_open = '<li>';
    public $wrapper_close = '</li>';
    public $content = '';

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function html()
    {
        return $this->wrapper_open.' '.$this->content.' '.$this->wrapper_close;
    }
}
