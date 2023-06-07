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
class Order extends \JI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->setTheme('admin');
		$this->lib("seme_purifier");
		$this->load("b_produk_concern");
		$this->load("b_produk_harga_concern");
		$this->load("b_produk_gambar_concern");
		$this->load("b_user_concern");
		$this->load("a_kategori_concern");
		$this->load("c_order_concern");
		$this->load("c_order_produk_concern");
		$this->load("admin/a_kategori_model", "akm");
		$this->load("admin/b_produk_model", "bpm");
		$this->load("admin/b_produk_harga_model", "bphm");
		$this->load("admin/b_produk_gambar_model", "bpgm");
		$this->load("admin/b_user_model", "bum");
		$this->load("admin/c_order_model", "com");
		$this->load("admin/c_order_produk_model", "copm");
		$this->current_parent = 'admin';
		$this->current_page = 'order';
	}
	public function index()
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url_admin('login'));
			die();
		}

		$data['akm'] = $this->akm->getAll();

		$this->setTitle('Order ' . $this->config_semevar('admin_site_suffix', ''));

		$this->putThemeContent("order/home_modal", $data);
		$this->putThemeContent("order/home", $data);
		$this->putJsContent("order/home_bottom", $data);
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
		$data['akm'] = $this->akm->getAll();
		$data['bpm'] = $this->bpm->getAll();


		$this->setTitle('Order Baru ' . $this->config_semevar('admin_site_suffix', ''));

		$this->putThemeContent("order/baru_modal", $data);
		$this->putThemeContent("order/baru", $data);

		$this->putJsContent("order/baru_bottom", $data);
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
			redir(base_url_admin('order/'));
			die();
		}
		$com = $this->com->id($id);
		if (!isset($com->id)) {
			redir(base_url_admin('order/'));
			die();
		}

		$data['com'] = $com;
		$bum = $this->bum->id($com->b_user_id);
		$data['com']->b_user_nama = $bum->fnama;
		$data['akm'] = $this->akm->getAll();
		$data['bpm'] = $this->bpm->getAll();
		$data['copm'] = $this->copm->getByOrder($com->id);

		// dd($data['bphm']);
		$this->setTitle('Order Edit #' . $com->id . ' ' . $this->config_semevar('admin_site_suffix', ''));
		$this->putThemeContent("order/edit_modal", $data);
		$this->putThemeContent("order/edit", $data);
		$this->putJsContent("order/edit_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}
}
