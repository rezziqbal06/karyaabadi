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
 * @package Blog\User
 * @since 1.0.0
 */
class Blog extends \JI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->setTheme('admin');
		$this->lib("seme_purifier");
		$this->load("a_blog_concern");
		$this->load("admin/a_blog_model", "abm");
		$this->current_parent = 'pengaturan';
		$this->current_page = 'blog';
	}
	public function index()
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url_admin('login'));
			die();
		}


		$this->setTitle('Blog ' . $this->config_semevar('admin_site_suffix', ''));

		$this->putThemeContent("pengaturan/blog/home_modal", $data);
		$this->putThemeContent("pengaturan/blog/home", $data);
		$this->putJsContent("pengaturan/blog/home_bottom", $data);
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


		$this->setTitle('Blog Baru ' . $this->config_semevar('admin_site_suffix', ''));

		$this->putThemeContent("pengaturan/blog/baru_modal", $data);
		$this->putThemeContent("pengaturan/blog/baru", $data);

		$this->putJsContent("pengaturan/blog/baru_bottom", $data);
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
			redir(base_url_admin('pengaturan/blog/'));
			die();
		}
		$abm = $this->abm->id($id);
		if (!isset($abm->id)) {
			redir(base_url_admin('pengaturan/blog/'));
			die();
		}

		// if (!isset($buam->id)) {
		// 	redir(base_url_admin('pengaturan/blog/'));
		// 	die();
		// }

		$data['abm'] = $abm;


		$this->setTitle('Blog Edit #' . $abm->id . ' ' . $this->config_semevar('admin_site_suffix', ''));
		$this->putThemeContent("pengaturan/blog/edit_modal", $data);
		$this->putThemeContent("pengaturan/blog/edit", $data);
		$this->putJsContent("pengaturan/blog/edit_bottom", $data);
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
			redir(base_url_admin('pengaturan/blog/'));
			die();
		}
		$abm = $this->abm->id($id);
		if (!isset($abm->id)) {
			redir(base_url_admin('pengaturan/blog/'));
			die();
		}
		$this->setTitle('Blog Detail #' . $abm->id . ' ' . $this->config_semevar('admin_site_suffix', ''));

		$abm->fnama = htmlentities($abm->fnama);
		$data['abm'] = $abm;
		$data['abm']->parent = $this->abm->id($abm->a_company_id);
		unset($abm);

		$this->putThemeContent("pengaturan/blog/detail", $data);
		$this->putJsContent("pengaturan/blog/detail_bottom", $data);
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
			redir(base_url_admin('pengaturan/blog/'));
			die();
		}
		$abm = $this->abm->id($id);
		if (!isset($abm->id)) {
			redir(base_url_admin('pengaturan/blog/'));
			die();
		}

		$this->setTitle('Manage blog Module #' . $abm->id . ' ' . $this->config_semevar('admin_site_suffix', ''));

		$data['abm'] = $abm;

		unset($abm);
		$this->putThemeContent("pengaturan/blog/module", $data);
		$this->putJsContent("pengaturan/blog/module_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}
}
