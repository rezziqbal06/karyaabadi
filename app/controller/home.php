<?php
class Home extends JI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->setTheme('front');
		$this->current_parent = 'dashboard';
		$this->current_page = 'dashboard';

		$this->load('a_kategori_concern');
		$this->load('b_produk_concern');

		$this->load('front/a_kategori_model', 'akm');
		$this->load('front/b_produk_model', 'bpm');
	}

	public function index()
	{
		$data = $this->__init();
		// if (!$this->user_login) {
		// 	redir(base_url('login'), 0);
		// 	die();
		// }
		$this->setTitle($this->config->semevar->site_suffix);

		$bpm_popular = $this->bpm->getPopular();
		if (isset($bpm_popular[0]->id)) $data['bpm'] = $bpm_popular;

		$data['bpm_popular'] = $bpm_popular;
		unset($bpm_popular);

		// $bum = $this->bum->getAll();
		// if (isset($bum[0]->id)) $data['bum'] = $bum;

		// $data['bum'] = $bum;
		// unset($bum);

		$akm = $this->akm->getAll();
		if (isset($akm[0]->id)) $data['akm'] = $akm;

		$data['akm'] = $akm;
		unset($akm);

		// $data['jp'] = $this->input->request('jp', 2);

		$this->putThemeContent("home/home", $data);
		$this->putThemeContent("home/home_modal", $data);
		$this->putJsContent("home/home_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}
}
