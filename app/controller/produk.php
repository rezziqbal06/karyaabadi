<?php
class Produk extends JI_Controller
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

		$produk = $this->bpm->getBySlug($slug);
		if (isset($produk->id)) $data['produk'] = $produk;
		if (isset($produk->spesifikasi)) $produk->spesifikasi = json_decode($produk->spesifikasi);
		$bpm_related = $this->bpm->getByKategori($produk->a_kategori_id, $produk->id);
		if (isset($bpm_related[0]->id)) $data['bpm_related'] = $bpm_related;

		$data['bpm_related'] = $bpm_related;
		unset($bpm_related);

		$akm = $this->akm->id($produk->a_kategori_id);
		if (isset($akm->id)) $data['akm'] = $akm;

		$data['akm'] = $akm;

		$bpgm = $this->bpgm->getByProduk($produk->id);
		if (isset($bpgm[0]->id)) $data['bpgm'] = $bpgm;

		$data['bpgm'] = $bpgm;

		$this->setTitle($produk->nama . $this->config->semevar->site_suffix);
		$this->setDescription($this->convertToMetaDescription($produk->deskripsi) . $this->config->semevar->site_suffix);
		$this->setKeyword($produk->meta_keyword ?? '');
		$this->setOGImage(base_url($produk->gambar));

		unset($produk);
		unset($bpm);
		unset($bpm_related);
		unset($akm);
		$this->putThemeContent("produk/detail", $data);
		$this->putThemeContent("produk/detail_modal", $data);
		$this->putJsContent("produk/detail_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}
}
