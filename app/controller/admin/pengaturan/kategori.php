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
class Kategori extends \JI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->setTheme('admin');
		$this->lib("seme_purifier");
		$this->load("a_kategori_concern");
		$this->load("admin/a_kategori_model", "akm");
		$this->current_parent = 'pengaturan';
		$this->current_page = 'kategori';
	}
	public function index()
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url_admin('login'));
			die();
		}


		$this->setTitle('Kategori ' . $this->config_semevar('admin_site_suffix', ''));

		$this->putThemeContent("pengaturan/kategori/home_modal", $data);
		$this->putThemeContent("pengaturan/kategori/home", $data);
		$this->putJsContent("pengaturan/kategori/home_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}
	public function indikator($id)
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url_admin('login'));
			die();
		}
		$id = (int) $id;
		if ($id <= 0) {
			redir(base_url_admin('pengaturan/kategori'));
			die();
		}
		$pengguna = $data['sess']->admin;


		$this->setTitle('Kategori - Indikator ' . $this->config_semevar('admin_site_suffix', ''));

		$this->putThemeContent("pengaturan/indikator/home_modal", $data);
		$this->putThemeContent("pengaturan/indikator/home", $data);

		$this->putJsContent("pengaturan/indikator/home_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}
}
