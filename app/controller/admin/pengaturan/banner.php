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
 * @package Banner\User
 * @since 1.0.0
 */
class Banner extends \JI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->setTheme('admin');
		$this->lib("seme_purifier");
		$this->load("a_banner_concern");
		$this->load("admin/a_banner_model", "abm");
		$this->current_parent = 'pengaturan';
		$this->current_page = 'banner';
	}
	public function index()
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url_admin('login'));
			die();
		}


		$this->setTitle('Member ' . $this->config_semevar('admin_site_suffix', ''));

		$this->putThemeContent("pengaturan/banner/home_modal", $data);
		$this->putThemeContent("pengaturan/banner/home", $data);
		$this->putJsContent("pengaturan/banner/home_bottom", $data);
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


		$this->setTitle('Member Baru ' . $this->config_semevar('admin_site_suffix', ''));

		$this->putThemeContent("pengaturan/banner/baru_modal", $data);
		$this->putThemeContent("pengaturan/banner/baru", $data);

		$this->putJsContent("pengaturan/banner/baru_bottom", $data);
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
			redir(base_url_admin('pengaturan/banner/'));
			die();
		}
		$abm = $this->abm->id($id);
		if (!isset($abm->id)) {
			redir(base_url_admin('pengaturan/banner/'));
			die();
		}

		// if (!isset($buam->id)) {
		// 	redir(base_url_admin('pengaturan/banner/'));
		// 	die();
		// }

		$data['abm'] = $abm;


		$this->setTitle('Member Edit #' . $abm->id . ' ' . $this->config_semevar('admin_site_suffix', ''));
		$this->putThemeContent("pengaturan/banner/edit_modal", $data);
		$this->putThemeContent("pengaturan/banner/edit", $data);
		$this->putJsContent("pengaturan/banner/edit_bottom", $data);
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
			redir(base_url_admin('pengaturan/banner/'));
			die();
		}
		$abm = $this->abm->id($id);
		if (!isset($abm->id)) {
			redir(base_url_admin('pengaturan/banner/'));
			die();
		}
		$this->setTitle('Member Detail #' . $abm->id . ' ' . $this->config_semevar('admin_site_suffix', ''));

		$abm->fnama = htmlentities($abm->fnama);
		$data['abm'] = $abm;
		$data['abm']->parent = $this->abm->id($abm->a_company_id);
		unset($abm);

		$this->putThemeContent("pengaturan/banner/detail", $data);
		$this->putJsContent("pengaturan/banner/detail_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}
	public function module($id)
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url_admin('login'));
			die();
		}
		$id = (int) $id;
		if ($id <= 0) {
			redir(base_url_admin('pengaturan/banner/'));
			die();
		}
		$abm = $this->abm->id($id);
		if (!isset($abm->id)) {
			redir(base_url_admin('pengaturan/banner/'));
			die();
		}

		$this->setTitle('Manage banner Module #' . $abm->id . ' ' . $this->config_semevar('admin_site_suffix', ''));

		$data['abm'] = $abm;

		unset($abm);
		$this->putThemeContent("pengaturan/banner/module", $data);
		$this->putJsContent("pengaturan/banner/module_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}
}
