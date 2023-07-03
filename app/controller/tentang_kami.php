<?php
class Tentang_Kami extends JI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->setTheme('front');
		$this->current_parent = 'dashboard';
		$this->current_page = 'dashboard';

		$this->load('a_kategori_concern');
		$this->load('a_banner_concern');
		$this->load('a_partner_concern');
		$this->load('b_produk_concern');

		$this->load('front/a_kategori_model', 'akm');
		$this->load('front/a_banner_model', 'abm');
		$this->load('front/a_partner_model', 'apm');
		$this->load('front/b_produk_model', 'bpm');
	}

	public function index()
	{
		$data = $this->__init();
		// if (!$this->user_login) {
		// 	redir(base_url('login'), 0);
		// 	die();
		// }
		$this->setTitle("Tentang Kami" . $this->config->semevar->site_suffix);



		$bpm = $this->bpm->getAll();
		if (isset($bpm[0]->id)) $data['bpm'] = $bpm;

		$data['bpm'] = $bpm;
		unset($bpm);



		// $data['jp'] = $this->input->request('jp', 2);

		$this->putThemeContent("tentang_kami/home", $data);
		$this->putJsContent("tentang_kami/home_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}
}
