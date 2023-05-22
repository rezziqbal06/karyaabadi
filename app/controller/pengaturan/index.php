<?php
class Pengaturan extends JI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->setTheme('front');
		$this->current_parent = 'pengaturan';
		$this->current_page = 'pengaturan';
	}

	public function index()
	{
		$this->current_parent = 'pengaturan_user';
		$this->current_page = 'pengaturan_user';
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'), 0);
			die();
		}

		redir(base_url('pengaturan/user'));
	}

	public function user()
	{
		$this->current_parent = 'pengaturan';
		$this->current_page = 'pengaturan_user';
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'), 0);
			die();
		}

		$this->setTitle('Pengaturan - User ' . $this->config->semevar->site_suffix);

		//$this->putJsFooter($this->cdn_url('skin/admin/').'js/helpers/gmaps.min',0);
		$this->putJsFooter($this->cdn_url('skin/admin/') . 'js/pages/index');

		$this->putThemeContent("pengaturan/user/home", $data);
		$this->putThemeContent("pengaturan/user/home_modal", $data);
		$this->putJsContent("pengaturan/user/home_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}

	public function perusahaan()
	{
		$this->current_parent = 'pengaturan';
		$this->current_page = 'pengaturan_perusahaan';
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'), 0);
			die();
		}

		$this->setTitle('Pengaturan - Perusahaan ' . $this->config->semevar->site_suffix);

		//$this->putJsFooter($this->cdn_url('skin/admin/').'js/helpers/gmaps.min',0);
		$this->putJsFooter($this->cdn_url('skin/admin/') . 'js/pages/index');

		$this->putThemeContent("pengaturan/perusahaan/home", $data);
		$this->putJsContent("pengaturan/perusahaan/home_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}
}
