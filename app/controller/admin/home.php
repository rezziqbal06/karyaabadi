<?php
class Home extends JI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->setTheme('admin');
		$this->current_parent = 'dashboard';
		$this->current_page = 'dashboard';

		$this->load('a_kategori_concern');
		$this->load('a_banner_concern');
		$this->load('a_partner_concern');
		$this->load('b_produk_concern');
		$this->load('b_user_concern');
		$this->load('c_order_concern');
		$this->load('c_order_produk_concern');

		$this->load('admin/a_kategori_model', 'akm');
		$this->load('admin/a_banner_model', 'abm');
		$this->load('admin/a_partner_model', 'apm');
		$this->load('admin/b_produk_model', 'bpm');
		$this->load('admin/b_user_model', 'bum');
		$this->load('admin/c_order_model', 'com');
		$this->load('admin/c_order_produk_model', 'copm');
	}

	public function index()
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url_admin('login'), 0);
			die();
		}

		$data['count_produk'] = $this->bpm->countAll();
		$data['count_kustomer'] = $this->bum->countAll();
		$data['count_order_on_proses'] = $this->com->countAll('progress');
		$data['count_order_done'] = $this->com->countAll('done');
		$bulan = [];
		$omset = [];
		$jumlah = [];
		$chart = $this->com->chart('done');
		if (isset($chart[0])) {
			foreach ($chart as $c) {
				// if (isset($c->omset)) {
				// 	$c->omset = number_format((float) $c->omset, 0, ',', '.');
				// }
				$bulan[] = $c->bulan;
				$omset[] = $c->omset;
				$jumlah[] = $c->jumlah;
			}
		}
		$data['chart'] = new stdClass();
		$data['chart']->bulan = json_encode($bulan);
		$data['chart']->omset = json_encode($omset);
		$data['chart']->jumlah = json_encode($jumlah);

		$this->setTitle('Dashboard ' . $this->config->semevar->site_suffix);

		$this->putJsFooter($this->cdn_url('skin/admin/') . 'js/pages/index');

		$this->putThemeContent("home/home", $data);
		$this->putJsContent("home/home_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}
}
