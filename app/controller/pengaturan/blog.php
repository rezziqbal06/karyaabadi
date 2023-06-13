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
 * @package blog\User
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


		$this->setTitle('Member ' . $this->config_semevar('site_suffix_admin', ''));

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


		$this->setTitle('Member Baru ' . $this->config_semevar('site_suffix', ''));

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
		$arm = $this->arm->id($id);
		if (!isset($arm->id)) {
			redir(base_url_admin('pengaturan/blog/'));
			die();
		}

		// if (!isset($buam->id)) {
		// 	redir(base_url_admin('pengaturan/blog/'));
		// 	die();
		// }

		$data['arm'] = $arm;


		$this->setTitle('Member Edit #' . $arm->id . ' ' . $this->config_semevar('site_suffix', ''));
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
		$arm = $this->arm->id($id);
		if (!isset($arm->id)) {
			redir(base_url_admin('pengaturan/blog/'));
			die();
		}
		$this->setTitle('Member Detail #' . $arm->id . ' ' . $this->config_semevar('site_suffix', ''));

		$arm->fnama = htmlentities($arm->fnama);
		$arm->alamat = htmlentities($arm->alamat);
		$data['arm'] = $arm;
		$data['arm']->parent = $this->arm->id($arm->a_company_id);
		unset($arm);

		$this->putThemeContent("pengaturan/blog/detail", $data);
		$this->putJsContent("pengaturan/blog/detail_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}
}
