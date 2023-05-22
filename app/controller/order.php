<?php

namespace Controller;

use stdClass;

register_namespace(__NAMESPACE__);
class Order extends \JI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->setTheme('front');
		$this->current_parent = 'order';
		$this->current_page = 'order';
		$this->load("a_nomorakun_concern");
		$this->load("b_user_concern");
		$this->load("b_user_alamat_concern");
		$this->load("c_order_concern");
		$this->load("front/a_nomorakun_model", 'amm');
		$this->load("front/b_user_model", 'bum');
		$this->load("front/b_user_alamat_model", 'buam');
		$this->load("front/c_order_model", 'com');
	}

	public function index()
	{
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'), 0);
			die();
		}
		$this->setTitle('Halaman Order ' . $this->config->semevar->site_suffix);

		//$this->putJsFooter($this->cdn_url('skin/admin/').'js/helpers/gmaps.min',0);
		$this->putJsFooter($this->cdn_url('skin/admin/') . 'js/pages/index');



		$this->putThemeContent("order/home", $data);
		$this->putThemeContent("order/home_modal", $data);
		$this->putJsContent("order/home_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}

	public function tambah()
	{
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'), 0);
			die();
		}

		$this->setTitle('Tambah Order ' . $this->config->semevar->site_suffix);
		$data['nomor_akun'] = $this->amm->get();

		$data['pengirim'] = $data['sess']->user;
		$data['pengirim']->alamat = $this->buam->getByUserId($data['pengirim']->id);
		if (isset($data['pengirim']->alamat->telp)) $data['pengirim']->alamat->telp = str_replace(' ', '', $data['pengirim']->alamat->telp);
		if (isset($data['pengirim']->alamat->kodepos)) $data['pengirim']->alamat->kodepos = str_replace(' ', '', $data['pengirim']->alamat->kodepos);
		//$this->putJsFooter($this->cdn_url('skin/admin/').'js/helpers/gmaps.min',0);
		$this->putJsFooter($this->cdn_url('skin/admin/') . 'js/pages/index');

		$this->putThemeContent("order/tambah", $data);
		$this->putThemeContent("order/tambah_modal", $data);
		$this->putJsContent("order/tambah_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}

	public function booking()
	{
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'), 0);
			die();
		}

		$this->setTitle('Edit Booking JNE ' . $this->config->semevar->site_suffix);
		$data['nomor_akun'] = $this->amm->get();

		$data['pengirim'] = $data['sess']->user;
		$data['pengirim']->alamat = $this->buam->getByUserId($data['pengirim']->id);
		if (isset($data['pengirim']->alamat->telp)) $data['pengirim']->alamat->telp = str_replace(' ', '', $data['pengirim']->alamat->telp);
		if (isset($data['pengirim']->alamat->kodepos)) $data['pengirim']->alamat->kodepos = str_replace(' ', '', $data['pengirim']->alamat->kodepos);
		//$this->putJsFooter($this->cdn_url('skin/admin/').'js/helpers/gmaps.min',0);
		$this->putJsFooter($this->cdn_url('skin/admin/') . 'js/pages/index');

		$this->putThemeContent("order/booking", $data);
		$this->putThemeContent("order/booking_modal", $data);
		$this->putJsContent("order/booking_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}

	public function edit($id)
	{
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'), 0);
			die();
		}

		$this->setTitle('Booking JNE ' . $this->config->semevar->site_suffix);
		$data['nomor_akun'] = $this->amm->get();

		$data['pengirim'] = $data['sess']->user;
		$data['pengirim']->alamat = $this->buam->getByUserId($data['pengirim']->id);
		if (isset($data['pengirim']->alamat->telp)) $data['pengirim']->alamat->telp = str_replace(' ', '', $data['pengirim']->alamat->telp);
		if (isset($data['pengirim']->alamat->kodepos)) $data['pengirim']->alamat->kodepos = str_replace(' ', '', $data['pengirim']->alamat->kodepos);
		//$this->putJsFooter($this->cdn_url('skin/admin/').'js/helpers/gmaps.min',0);
		$this->putJsFooter($this->cdn_url('skin/admin/') . 'js/pages/index');

		$this->putThemeContent("order/edit_booking", $data);
		$this->putThemeContent("order/edit_booking_modal", $data);
		$this->putJsContent("order/edit_booking_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}

	public function download_xls()
	{
		$d = $this->__init();
		$data = array();
		$this->_api_auth_required($data, 'user');

		$this->lib('seme_spreadsheet', 'ss');
		$this->status = 200;
		$this->message = API_ADMIN_ERROR_CODES[$this->status];

		/** advanced filter is_active */
		$is_active = $this->input->request('is_active', '');
		if (strlen($is_active)) {
			$is_active = intval($is_active);
		}

		$sdate = $this->input->request('sdate', '');
		$edate = $this->input->request('edate', '');
		$service = $this->input->request('service', '');


		$b_user_id = $d['sess']->user->id;

		$datatable = $this->com->datatable()->initialize();
		$ddata = $this->com->data(
			$b_user_id,
			$datatable->page(),
			$datatable->pagesize(),
			$datatable->sort_column(),
			$datatable->sort_direction(),
			$datatable->keyword(),
			$is_active,
			$sdate,
			$edate,
			$service
		);

		$head = [
			'Tanggal',
			'Service',
			'Layanan',
			'Telp',
			'Kode',
			'No Booking',
			'No Resi',
			'Status',
			'Pengirim',
			'Provinsi Pengirim',
			'Kabkota Pengirim',
			'Kecamatan Pengirim',
			'Alamat Pengirim',
			'Alamat 2 Pengirim',
			'Kodepos Pengirim',
			'Penerima',
			'Provinsi Penerima',
			'Kabkota Penerima',
			'Kecamatan Penerima',
			'Alamat Penerima',
			'Alamat 2 Penerima',
			'Kodepos Penerima',
			'Ongkir',
			'Harga Paket',
			'Harga COD',
		];

		foreach ($ddata as &$gd) {
			if (isset($gd->service)) {
				$type = 'info';
				if (stripos($gd->service, 'OKE') !== false) {
					$type = 'info';
				} else if (stripos($gd->service, 'REG') !== false) {
					$type = 'warning';
				} else if (stripos($gd->service, 'YES') !== false) {
					$type = 'success';
				} else if (stripos($gd->service, 'JTR') !== false) {
					$type = 'danger';
				}
				// $gd->service = '<span class="text-' . $type . '">' . $gd->service . '</span>';
			}
			if (isset($gd->cdate)) {
				$gd->cdate = $this->__dateIndonesia($gd->cdate);
			}
			if (isset($gd->json_value)) {
				$value = json_decode($gd->json_value);
				$gd->ongkir = "Rp. " . number_format((float) $value->ongkir, 0, ',', '.') ?? 'Rp. 0';
				$gd->harga_barang = "Rp. " . number_format((float) $value->harga_barang, 0, ',', '.') ?? 'Rp. 0';
				$gd->harga_cod = "Rp. " . number_format((float) $value->harga_cod, 0, ',', '.') ?? 'Rp. 0';
				unset($gd->json_value);
			}
			if (isset($gd->is_active)) {
				$gd->is_active = $gd->is_active ? 'Aktif' : 'Tidak Aktif';
			}
		}

		$request = new stdClass();
		$request->data = $ddata;
		$request->head = $head;
		$request->title = 'Daftar Paket JNE';
		$request->filename = 'kirim_paket_jne';
		$request->mindate = $sdate;
		$request->maxdate = $edate;
		return $this->ss->download_basic($request);
	}
}
