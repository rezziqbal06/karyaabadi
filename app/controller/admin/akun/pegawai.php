<?php


register_namespace(__NAMESPACE__);

/**
 * Main Controller Class for pegawai Modul
 *
 * Mostly for this controller will resulting HTTP Body Content in HTML format
 *
 * @version 1.0.0
 *
 * @package Partner\pegawai
 * @since 1.0.0
 */
class Pegawai extends \JI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->setTheme('admin');
		$this->lib("seme_purifier");
		$this->load("a_pengguna_concern");
		$this->load("admin/a_pengguna_model", "apm");
		$this->current_parent = 'akun';
		$this->current_page = 'pegawai';
	}
	public function index()
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url_admin('login'));
			die();
		}


		$this->setTitle('Pegawai ' . $this->config_semevar('admin_site_suffix', ''));

		$this->putThemeContent("akun/pegawai/home_modal", $data);
		$this->putThemeContent("akun/pegawai/home", $data);
		$this->putJsContent("akun/pegawai/home_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}
	public function baru()
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url_admin('login'));
			die();
		}
		$pengguna = $data['sess']->admin;

		$this->setTitle('Pegawai Baru ' . $this->config_semevar('admin_site_suffix', ''));

		$this->putThemeContent("akun/pegawai/baru_modal", $data);
		$this->putThemeContent("akun/pegawai/baru", $data);

		$this->putJsContent("akun/pegawai/baru_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}
	public function edit($id)
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url_admin('login'));
			die();
		}
		$id = (int) $id;
		if ($id <= 0) {
			redir(base_url_admin('akun/pegawai/'));
			die();
		}
		$apm = $this->apm->id($id);
		if (!isset($apm->id)) {
			redir(base_url_admin('akun/pegawai/'));
			die();
		}

		$data['apm'] = $apm;


		$this->setTitle('Pegawai Edit #' . $apm->id . ' ' . $this->config_semevar('admin_site_suffix', ''));
		$this->putThemeContent("akun/pegawai/edit_modal", $data);
		$this->putThemeContent("akun/pegawai/edit", $data);
		$this->putJsContent("akun/pegawai/edit_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}
	public function detail($id)
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url_admin('login'));
			die();
		}
		$id = (int) $id;
		if ($id <= 0) {
			redir(base_url_admin('akun/pegawai/'));
			die();
		}
		$apm = $this->apm->id($id);
		if (!isset($apm->id)) {
			redir(base_url_admin('akun/pegawai/'));
			die();
		}
		$this->setTitle('Pegawai Detail #' . $apm->id . ' ' . $this->config_semevar('admin_site_suffix', ''));

		$apm->fnama = htmlentities($apm->fnama);
		$apm->alamat = htmlentities($apm->alamat);
		$data['apm'] = $apm;
		$data['apm']->parent = $this->apm->id($apm->a_company_id);
		unset($apm);

		$this->putThemeContent("akun/pegawai/detail", $data);
		$this->putJsContent("akun/pegawai/detail_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}
	// public function module($id)
	// {
	// 	$data = $this->__init();
	// 	if (!$this->admin_login) {
	// 		redir(base_url_admin('login'));
	// 		die();
	// 	}
	// 	$id = (int) $id;
	// 	if ($id <= 0) {
	// 		redir(base_url_admin('akun/pegawai/'));
	// 		die();
	// 	}
	// 	$apm = $this->apm->id($id);
	// 	if (!isset($apm->id)) {
	// 		redir(base_url_admin('akun/pegawai/'));
	// 		die();
	// 	}
	// 	$ajpm = $this->ajpm->getAll();
	// 	if (!isset($ajpm[0]->id)) {
	// 		redir(base_url_admin('akun/pegawai/'));
	// 		die();
	// 	}
	// 	$apmm = $this->apmm->getByJabatanAndpegawai('', $id);

	// 	$new_apmm = [];
	// 	if (isset($apmm[0]->id)) {
	// 		foreach ($apmm as $bm) {
	// 			$new_apmm[$bm->a_jpenilaian_id . '-' . $bm->type] = $bm;
	// 		}
	// 	}
	// 	$this->setTitle('Manage pegawai Module #' . $apm->id . ' ' . $this->config_semevar('admin_site_suffix', ''));

	// 	$data['apm'] = $apm;
	// 	$data['ajpm'] = $ajpm;
	// 	$data['apmm'] = $new_apmm;
	// 	unset($apm);
	// 	unset($ajpm);
	// 	unset($apmm);
	// 	unset($new_apmm);

	// 	$this->putThemeContent("akun/pegawai/module", $data);
	// 	$this->putJsContent("akun/pegawai/module_bottom", $data);
	// 	$this->loadLayout('col-2-left', $data);
	// 	$this->render();
	// }
}
