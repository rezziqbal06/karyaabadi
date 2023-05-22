<?php
class Forgot_Password extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setTheme('front');
    }
    public function index()
    {
        $data = $this->__init();
        $this->setTitle('Lupa password ' . $this->current_reseller->site_title);
		$this->setDescription('Silakan reset password akun '.$this->current_reseller->nama.' melalui halaman ini');

        $this->putThemeContent("forgot_password/home", $data);
        $this->putThemeContent("forgot_password/home_modal", $data);
        $this->putJsContent("forgot_password/home_bottom", $data);
        $this->loadLayout('login', $data);
        $this->render();
    }
}
