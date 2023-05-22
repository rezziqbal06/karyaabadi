<?php
class Alamat extends JI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->setTheme('front');
		$this->current_parent = 'pengaturan';
		$this->current_page = 'pengaturan_alamat';
		$this->load("front/b_user_model", 'bum');
		$this->load("front/b_user_alamat_model", 'buam');
	}

	public function index()
	{
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'));
			return false;
		}
		$this->setTitle('Alamat ' . $this->config->semevar->site_suffix);

		$this->putThemeContent("pengaturan/alamat/home_modal", $data);
		$this->putThemeContent("pengaturan/alamat/home", $data);
		$this->putJsContent("pengaturan/alamat/home_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}
	public function baru()
	{
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'));
			return false;
		}
		$this->setTitle('Tambah Alamat ' . $this->config->semevar->site_suffix);

		$this->putThemeContent("pengaturan/alamat/baru_modal", $data);
		$this->putThemeContent("pengaturan/alamat/baru", $data);
		$this->putJsContent("pengaturan/alamat/baru_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}
	public function edit($id)
	{
		$id = (int) $id;
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'));
			return false;
		}
		if ($id <= 0) {
			redir(base_url('pengaturan/alamat/'));
			return false;
		}
		$a_company_id = $data['sess']->user->a_company_id;

		$buam = $this->buam->getById($id, $a_company_id);
		if (!isset($buam->id)) {
			redir(base_url('pengaturan/alamat/'));
			return false;
		}
		if ($buam->b_user_id != $data['sess']->user->id) {
			redir(base_url('pengaturan/alamat/'));
			return false;
		}

		$data['buam'] = $buam;

		$this->setTitle('Edit Alamat ' . $this->config->semevar->site_suffix);
		$this->putThemeContent("pengaturan/alamat/edit_modal", $data);
		$this->putThemeContent("pengaturan/alamat/edit", $data);
		$this->putJsContent("pengaturan/alamat/edit_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}

	public function detail($id)
	{
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'));
			return false;
		}
		$id = (int) $id;
		if (empty($id)) {
			redir(base_url('pengaturan/alamat/'));
			return false;
		}

		$data['buam'] = $this->buam->getById($id);
		if (!isset($data['buam']->id)) {
			redir(base_url('pengaturan/alamat/'));
			return false;
		}
		if ($data['buam']->b_user_id != $data['sess']->user->id) {
			redir(base_url('pengaturan/alamat/'));
			return false;
		}

		$this->setTitle('Detail alamat: #' . $data['buam']->id . ' ' . $this->config->semevar->site_suffix);

		$this->putThemeContent("pengaturan/alamat/detail_modal", $data);
		$this->putThemeContent("pengaturan/alamat/detail", $data);
		$this->putJsContent("pengaturan/alamat/detail_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}
}
