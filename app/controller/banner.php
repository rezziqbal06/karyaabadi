<?php
class Banner extends JI_Controller
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
		$this->load('b_produk_gambar_concern');

		$this->load('front/a_kategori_model', 'akm');
		$this->load('front/a_banner_model', 'abm');
		$this->load('front/a_partner_model', 'apm');
		$this->load('front/b_produk_model', 'bpm');
		$this->load('front/b_produk_gambar_model', 'bpgm');
	}

	public function index()
	{
		$data = $this->__init();
		// if (!$this->user_login) {
		// 	redir(base_url('login'), 0);
		// 	die();
		// }
		$this->setTitle("Beranda" . $this->config->semevar->site_suffix);

		$bpm_popular = $this->bpm->getPopular();
		if (isset($bpm_popular[0]->id)) $data['bpm'] = $bpm_popular;

		$data['bpm_popular'] = $bpm_popular;
		unset($bpm_popular);

		$bpm = $this->bpm->getAll();
		if (isset($bpm[0]->id)) $data['bpm'] = $bpm;

		$data['bpm'] = $bpm;
		unset($bpm);

		$akm = $this->akm->getAll();
		if (isset($akm[0]->id)) $data['akm'] = $akm;

		$data['akm'] = $akm;
		unset($akm);

		$abm = $this->abm->getAll();
		if (isset($abm[0]->id)) $data['abm'] = $abm;

		$data['abm'] = $abm;
		unset($abm);

		$apm = $this->apm->getAll();
		if (isset($apm[0]->id)) $data['apm'] = $apm;

		$data['apm'] = $apm;
		unset($apm);

		// $data['jp'] = $this->input->request('jp', 2);

		$this->putThemeContent("home/home", $data);
		$this->putThemeContent("home/home_modal", $data);
		$this->putJsContent("home/home_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}

	public function detail($slug)
	{
		$data = $this->__init();
		// if (!$this->user_login) {
		// 	redir(base_url('login'), 0);
		// 	die();
		// }

		// Untuk Header
		$bpm = $this->bpm->getAll();
		if (isset($bpm[0]->id)) $data['bpm'] = $bpm;

		$data['bpm'] = $bpm;

		$banner = $this->abm->getBySlug($slug);
		if (isset($banner->id)) $data['banner'] = $banner;
		if (isset($banner->spesifikasi)) $banner->spesifikasi = json_decode($banner->spesifikasi);

		$banner_lainnya = $this->abm->getLainnya($banner->id);
		$data['banner_lainnya'] = $banner_lainnya;

		$this->setTitle($banner->nama . $this->config->semevar->site_suffix);
		$this->setDescription($this->convertToMetaDescription($banner->deskripsi) . $this->config->semevar->site_suffix);
		$this->setKeyword($banner->meta_keyword ?? '');
		$this->setOGImage(base_url($banner->gambar));

		unset($banner);
		unset($banner_lainnya);
		unset($bpm);

		$this->putThemeContent("banner/detail", $data);
		$this->putThemeContent("banner/detail_modal", $data);
		$this->putJsContent("banner/detail_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}
}
