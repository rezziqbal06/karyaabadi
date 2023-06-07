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
class Partner extends \JI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->setTheme('admin');
		$this->lib("seme_purifier");
		$this->load("a_partner_concern");
		$this->load("admin/a_partner_model", "apm");
		$this->current_parent = 'pengaturan';
		$this->current_page = 'partner';
	}
	public function index()
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url_admin('login'));
			die();
		}


		$this->setTitle('Member ' . $this->config_semevar('admin_site_suffix', ''));

		$this->putThemeContent("pengaturan/partner/home_modal", $data);
		$this->putThemeContent("pengaturan/partner/home", $data);
		$this->putJsContent("pengaturan/partner/home_bottom", $data);
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

		$this->putThemeContent("pengaturan/partner/baru_modal", $data);
		$this->putThemeContent("pengaturan/partner/baru", $data);

		$this->putJsContent("pengaturan/partner/baru_bottom", $data);
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
			redir(base_url_admin('pengaturan/partner/'));
			die();
		}
		$apm = $this->apm->id($id);
		if (!isset($apm->id)) {
			redir(base_url_admin('pengaturan/partner/'));
			die();
		}

		// if (!isset($buam->id)) {
		// 	redir(base_url_admin('pengaturan/partner/'));
		// 	die();
		// }

		$data['apm'] = $apm;


		$this->setTitle('Member Edit #' . $apm->id . ' ' . $this->config_semevar('admin_site_suffix', ''));
		$this->putThemeContent("pengaturan/partner/edit_modal", $data);
		$this->putThemeContent("pengaturan/partner/edit", $data);
		$this->putJsContent("pengaturan/partner/edit_bottom", $data);
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
			redir(base_url_admin('pengaturan/partner/'));
			die();
		}
		$apm = $this->apm->id($id);
		if (!isset($apm->id)) {
			redir(base_url_admin('pengaturan/partner/'));
			die();
		}
		$this->setTitle('Member Detail #' . $apm->id . ' ' . $this->config_semevar('admin_site_suffix', ''));

		$apm->fnama = htmlentities($apm->fnama);
		$data['apm'] = $apm;
		$data['apm']->parent = $this->apm->id($apm->a_company_id);
		unset($apm);

		$this->putThemeContent("pengaturan/partner/detail", $data);
		$this->putJsContent("pengaturan/partner/detail_bottom", $data);
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
			redir(base_url_admin('pengaturan/partner/'));
			die();
		}
		$apm = $this->apm->id($id);
		if (!isset($apm->id)) {
			redir(base_url_admin('pengaturan/partner/'));
			die();
		}

		$this->setTitle('Manage partner Module #' . $apm->id . ' ' . $this->config_semevar('admin_site_suffix', ''));

		$data['apm'] = $apm;

		unset($apm);
		$this->putThemeContent("pengaturan/partner/module", $data);
		$this->putJsContent("pengaturan/partner/module_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}
}
