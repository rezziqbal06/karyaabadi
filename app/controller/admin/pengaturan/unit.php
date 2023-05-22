<?php

namespace Controller\Pengaturan;

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
class Unit extends \JI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->setTheme('admin');
		$this->lib("seme_purifier");
		$this->load("a_unit_concern");
		$this->load("admin/a_unit_model", "aum");
		$this->current_parent = 'pengaturan';
		$this->current_page = 'unit';
	}
	public function index()
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url_admin('login'));
			die();
		}


		$this->setTitle('Member ' . $this->config_semevar('site_suffix_admin', ''));

		$this->putThemeContent("pengaturan/unit/home_modal", $data);
		$this->putThemeContent("pengaturan/unit/home", $data);
		$this->putJsContent("pengaturan/unit/home_bottom", $data);
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
		$aum = $this->aum->id($id);
		if (!isset($aum->id)) {
			redir(base_url_admin('akun/user/'));
			die();
		}

		// if (!isset($buam->id)) {
		// 	redir(base_url_admin('akun/user/'));
		// 	die();
		// }

		$data['aum'] = $aum;


		$this->setTitle('Member Edit #' . $aum->id . ' ' . $this->config_semevar('site_suffix', ''));
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
		$aum = $this->aum->id($id);
		if (!isset($aum->id)) {
			redir(base_url_admin('akun/user/'));
			die();
		}
		$this->setTitle('Member Detail #' . $aum->id . ' ' . $this->config_semevar('site_suffix', ''));

		$aum->fnama = htmlentities($aum->fnama);
		$aum->alamat = htmlentities($aum->alamat);
		$data['aum'] = $aum;
		$data['aum']->parent = $this->aum->id($aum->a_company_id);
		unset($aum);

		$this->putThemeContent("akun/user/detail", $data);
		$this->putJsContent("akun/user/detail_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}
}
