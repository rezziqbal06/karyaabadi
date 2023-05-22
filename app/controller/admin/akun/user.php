<?php

namespace Controller\Partner;

register_namespace(__NAMESPACE__);

/**
 * Main Controller Class for User Modul
 *
 * Mostly for this controller will resulting HTTP Body Content in HTML format
 *
 * @version 1.0.0
 *
 * @package Partner\User
 * @since 1.0.0
 */
class User extends \JI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->setTheme('admin');
		$this->lib("seme_purifier");
		$this->load("b_user_concern");
		$this->load("admin/b_user_model", "bum");
		$this->current_parent = 'akun';
		$this->current_page = 'user';
	}
	public function index()
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url_admin('login'));
			die();
		}


		$this->setTitle('Member ' . $this->config_semevar('site_suffix_admin', ''));

		$this->putThemeContent("akun/user/home_modal", $data);
		$this->putThemeContent("akun/user/home", $data);
		$this->putJsContent("akun/user/home_bottom", $data);
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

		$this->setTitle('Member Baru ' . $this->config_semevar('site_suffix', ''));

		$this->putThemeContent("akun/user/baru_modal", $data);
		$this->putThemeContent("akun/user/baru", $data);

		$this->putJsContent("akun/user/baru_bottom", $data);
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
			redir(base_url_admin('akun/user/'));
			die();
		}
		$bum = $this->bum->id($id);
		if (!isset($bum->id)) {
			redir(base_url_admin('akun/user/'));
			die();
		}

		$data['bum'] = $bum;


		$this->setTitle('Member Edit #' . $bum->id . ' ' . $this->config_semevar('site_suffix', ''));
		$this->putThemeContent("akun/user/edit_modal", $data);
		$this->putThemeContent("akun/user/edit", $data);
		$this->putJsContent("akun/user/edit_bottom", $data);
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
			redir(base_url_admin('akun/user/'));
			die();
		}
		$bum = $this->bum->id($id);
		if (!isset($bum->id)) {
			redir(base_url_admin('akun/user/'));
			die();
		}
		$this->setTitle('Member Detail #' . $bum->id . ' ' . $this->config_semevar('site_suffix', ''));

		$bum->fnama = htmlentities($bum->fnama);
		$bum->alamat = htmlentities($bum->alamat);
		$data['bum'] = $bum;
		$data['bum']->parent = $this->bum->id($bum->a_company_id);
		unset($bum);

		$this->putThemeContent("akun/user/detail", $data);
		$this->putJsContent("akun/user/detail_bottom", $data);
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
	// 		redir(base_url_admin('akun/user/'));
	// 		die();
	// 	}
	// 	$bum = $this->bum->id($id);
	// 	if (!isset($bum->id)) {
	// 		redir(base_url_admin('akun/user/'));
	// 		die();
	// 	}
	// 	$ajpm = $this->ajpm->getAll();
	// 	if (!isset($ajpm[0]->id)) {
	// 		redir(base_url_admin('akun/user/'));
	// 		die();
	// 	}
	// 	$bumm = $this->bumm->getByJabatanAndUser('', $id);

	// 	$new_bumm = [];
	// 	if (isset($bumm[0]->id)) {
	// 		foreach ($bumm as $bm) {
	// 			$new_bumm[$bm->a_jpenilaian_id . '-' . $bm->type] = $bm;
	// 		}
	// 	}
	// 	$this->setTitle('Manage User Module #' . $bum->id . ' ' . $this->config_semevar('site_suffix', ''));

	// 	$data['bum'] = $bum;
	// 	$data['ajpm'] = $ajpm;
	// 	$data['bumm'] = $new_bumm;
	// 	unset($bum);
	// 	unset($ajpm);
	// 	unset($bumm);
	// 	unset($new_bumm);

	// 	$this->putThemeContent("akun/user/module", $data);
	// 	$this->putJsContent("akun/user/module_bottom", $data);
	// 	$this->loadLayout('col-2-left', $data);
	// 	$this->render();
	// }
}
