<?php
class Blog extends JI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->setTheme('front');
		$this->current_parent = 'dashboard';
		$this->current_page = 'dashboard';

		$this->load('a_kategori_concern');
		$this->load('a_blog_concern');
		$this->load('a_partner_concern');
		$this->load('b_produk_concern');
		$this->load('b_produk_gambar_concern');

		$this->load('front/a_kategori_model', 'akm');
		$this->load('front/a_blog_model', 'abm');
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
		$this->setTitle("Blog" . $this->config->semevar->site_suffix);

		$bpm = $this->bpm->getAll();
		if (isset($bpm[0]->id)) $data['bpm'] = $bpm;

		$data['bpm'] = $bpm;
		unset($bpm);

		$abm = $this->abm->getAll();
		foreach ($abm as $a) {
			$a->cdate = date("d M", strtotime($a->cdate));
		}
		$data['abm'] = $abm;
		unset($abm);


		$this->putThemeContent("blog/home", $data);
		$this->putThemeContent("blog/home_modal", $data);
		$this->putJsContent("blog/home_bottom", $data);
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

		$blog = $this->abm->getBySlug($slug);
		$recent_post = $this->abm->getRecent();
		if (isset($blog->cdate)) $blog->cdate = $this->__dateIndonesia($blog->cdate);
		if (isset($blog->id)) $data['blog'] = $blog;
		$abm_related = $this->abm->getByKategori($blog->kategori, $blog->id);
		foreach ($abm_related as $rp) {
			if (isset($rp->cdate)) $rp->cdate = $this->__dateIndonesia($rp->cdate);
		}

		$data['abm_related'] = $abm_related;
		unset($abm_related);

		foreach ($recent_post as $rp) {
			if (isset($rp->cdate)) $rp->cdate = $this->__dateIndonesia($rp->cdate);
		}
		$data['recent_post'] = $recent_post;
		unset($recent_post);

		$this->setTitle($blog->judul . $this->config->semevar->site_suffix);
		$this->setDescription($this->convertToMetaDescription($blog->text) . $this->config->semevar->site_suffix);
		$this->setKeyword($blog->meta_keyword ?? '');
		$this->setOGImage(base_url($blog->gambar));

		unset($blog);
		unset($bpm);
		unset($abm_related);
		$this->putThemeContent("blog/detail", $data);
		$this->putThemeContent("blog/detail_modal", $data);
		$this->putJsContent("blog/detail_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}
}
