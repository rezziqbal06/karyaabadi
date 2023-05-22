<?php
class Notfound extends \JI_Controller
{
    public function index()
    {
        $data = $this->__init();
        $this->setTheme('admin');
        header("HTTP/1.0 404 Not Found");

        $this->setTitle("Tidak ditemukan ".$this->config->semevar->sales_site_suffix);

        $this->loadLayout('notfound', $data);
        $this->render();
    }
}
