<?php
class Order extends JI_Controller
{
	var $media_pengguna = 'media/pengguna';

	public function __construct()
	{
		parent::__construct();
		$this->load('b_produk_concern');
		$this->load('b_produk_harga_concern');
		$this->load('b_produk_gambar_concern');
		$this->load('b_user_concern');
		$this->load('c_order_concern');
		$this->load('c_order_produk_concern');
		$this->load("api_admin/b_produk_model", 'bpm');
		$this->load("api_admin/b_produk_harga_model", 'bphm');
		$this->load("api_admin/b_produk_gambar_model", 'bpgm');
		$this->load("api_admin/b_user_model", 'bum');
		$this->load("api_admin/c_order_model", 'com');
		$this->load("api_admin/c_order_produk_model", 'copm');
		$this->lib("seme_upload", 'se');
	}

	public function __generateKodeProduk($sitename)
	{
		$last_id = $this->com->last_id();

		$words = preg_split('/[^a-zA-Z0-9]+/', $sitename);
		$acronym = '';
		// Iterate over the words and extract the first character
		foreach ($words as $word) {
			$acronym .= strtoupper(substr($word, 0, 1));
		}

		$tgl = date("Ymd");

		return "ORD-$acronym-$tgl-$last_id";
	}

	/**
	 * Give json data set result on datatable format
	 *
	 * @api
	 *
	 * @return void
	 */
	public function index()
	{
		$d = $this->__init();
		$data = array();
		$this->_api_auth_required($data, 'admin');

		$this->status = 200;
		$this->message = API_ADMIN_ERROR_CODES[$this->status];


		$is_active = $this->input->request('is_active', 1);
		if (strlen($is_active)) {
			$is_active = intval($is_active);
		}

		$admin_login = $d['sess']->user;
		$b_user_id = '';
		// Jika user adalah reseller, maka mengambil kustomernya
		// if (isset($admin_login->utype) && $admin_login->utype == 'agen') {
		// 	$b_user_id = $admin_login->id;
		// }

		$datatable = $this->com->datatable()->initialize();
		$dcount = $this->com->count($datatable->keyword(), $is_active);
		$ddata = $this->com->data(
			$datatable->page(),
			$datatable->pagesize(),
			$datatable->sort_column(),
			$datatable->sort_direction(),
			$datatable->keyword(),
			$is_active
		);

		foreach ($ddata as &$gd) {
			if (isset($gd->fnama)) {
				$gd->fnama = htmlentities(rtrim($gd->fnama, ' - '));
			}
			if (isset($gd->is_active)) {
				$gd->is_active = $this->com->label('is_active', $gd->is_active);
			}
			if (isset($gd->total_harga)) {
				$gd->total_harga = number_format((int) $gd->total_harga, 0, ',', '.');
			}
		}

		$this->__jsonDataTable($ddata, $dcount);
	}

	/**
	 * Create new data
	 *
	 * @api
	 *
	 * @return void
	 */
	public function baru()
	{
		$d = $this->__init();
		$data = new \stdClass();
		if (!$this->com->validates()) {
			$this->status = 444;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$validation_message = $this->com->validation_message();
			if (strlen($validation_message)) {
				$this->message = $validation_message;
			}
			$this->__json_out($data);
			die();
		}

		$kode = $this->__generateKodeProduk($this->config_semevar("site_name"));
		$this->com->columns['kode']->value = $kode;
		$this->com->columns['cdate']->value = 'NOW()';
		$total_harga = $this->input->post('total_harga');
		$this->com->columns['total_harga']->value = (int) str_replace('.', '', $total_harga);

		$b_user_id = $this->input->post('b_user_id');
		if (!$b_user_id) {
			$b_user_nama = $this->input->post("b_user_nama");
			if (!$b_user_nama) {
				$this->status = 444;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];
				$validation_message = $this->com->validation_message();
				$this->__json_out($data);
				die();
			}
			$res_user = $this->bum->set(['fnama' => $b_user_nama]);
			if (!$res_user) {
				$this->status = 444;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];
				$validation_message = $this->com->validation_message();
				$this->__json_out($data);
				die();
			}
			$this->com->columns['b_user_id']->value = $res_user;
		}

		$res = $this->com->save();
		if ($res) {
			//Upload Produk
			$b_produk_id = $this->input->post('b_produk_id');
			$b_produk_id_harga = $this->input->post('b_produk_id_harga');
			$harga = $this->input->post('harga');
			$qty = $this->input->post('qty');
			if (isset($b_produk_id) && is_array($b_produk_id) && count($b_produk_id)) {
				$dip = [];
				foreach ($b_produk_id as $k => $v) {
					$dip[$k]['c_order_id'] = $res;
					$dip[$k]['b_produk_id'] = $v;
					$dip[$k]['b_produk_id_harga'] = $b_produk_id_harga[$k];
					$dip[$k]['qty'] = $qty[$k];
					$dip[$k]['sub_harga'] = (int) str_replace('.', '', $harga[$k]);
					$dip[$k]['tgl_pesan'] = $this->input->post('tgl_pesan');
					$dip[$k]['cdate'] = "NOW()";
				}
				$res_produk = $this->copm->setMass($dip);
				if ($res_produk) {
					$this->status = 200;
					$this->message = API_ADMIN_ERROR_CODES[$this->status];
				} else {
					$this->status = 110;
					$this->message = API_ADMIN_ERROR_CODES[$this->status];

					$res_hapus = $this->com->del($res);
				}
			}

			$this->status = 200;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
		} else {
			$this->status = 110;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
		}
		$this->__json_out($data);
	}

	/**
	 * Get detailed information by idea
	 *
	 * @param  int   $id               ID value from a_fasilitas table
	 *
	 * @api
	 * @return void
	 */
	public function detail($id)
	{
		$d = $this->__init();
		$data = array();
		if (!$this->admin_login) {
			$this->status = 400;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			header("HTTP/1.0 400 Harus login");
			$this->__json_out($data);
			die();
		}
		$id = (int) $id;

		$this->status = 200;
		$this->message = API_ADMIN_ERROR_CODES[$this->status];
		$data = $this->com->id($id);
		if (!isset($data->id)) {
			$data = new \stdClass();
			$this->status = 441;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}

		// dd(count($data->indikator));
		$this->__json_out($data);
	}

	/**
	 * Update data by supplied ID
	 *
	 * @param  int   $id               ID value from a_fasilitas table
	 *
	 * @api
	 *
	 * @return void
	 */
	public function edit($id = "")
	{
		$d = $this->__init();
		$data = array();

		$du = $_POST;
		$id = (int) $id;
		$id = isset($du['id']) ? $du['id'] : $id;
		$du = [];

		if (!$this->admin_login) {
			$this->status = 400;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			header("HTTP/1.0 400 Harus login");
			$this->__json_out($data);
			die();
		}

		$id = (int) $id;
		if ($id <= 0) {
			$this->status = 444;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}

		$com = $this->com->id($id);
		if (!isset($com->id)) {
			$this->status = 445;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}

		if (!$this->com->validates()) {
			$this->status = 444;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$validation_message = $this->com->validation_message();
			if (strlen($validation_message)) {
				$this->message = $validation_message;
			}
			$this->__json_out($data);
			die();
		}

		$total_harga = $this->input->post('total_harga');
		$du['total_harga'] = (int) str_replace('.', '', $total_harga);

		$b_user_id = $this->input->post('b_user_id');
		if (!$b_user_id) {
			$b_user_nama = $this->input->post("b_user_nama");
			if (!$b_user_nama) {
				$this->status = 444;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];
				$validation_message = $this->com->validation_message();
				$this->__json_out($data);
				die();
			}
			$res_user = $this->bum->set(['fnama' => $b_user_nama]);
			if (!$res_user) {
				$this->status = 444;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];
				$validation_message = $this->com->validation_message();
				$this->__json_out($data);
				die();
			}
			$du['b_user_id']->value = $res_user;
		}

		if ($id > 0) {
			unset($du['id']);

			$res = $this->com->update($id, $du);
			if ($res) {
				//Upload Produk

				$res_hapus = $this->copm->delByOrder($id);
				if ($res_hapus) {
					$b_produk_id = $this->input->post('b_produk_id');
					$b_produk_id_harga = $this->input->post('b_produk_id_harga');
					$harga = $this->input->post('harga');
					$qty = $this->input->post('qty');
					if (isset($b_produk_id) && is_array($b_produk_id) && count($b_produk_id)) {
						$dip = [];
						foreach ($b_produk_id as $k => $v) {
							$dip[$k]['c_order_id'] = $id;
							$dip[$k]['b_produk_id'] = $v;
							$dip[$k]['b_produk_id_harga'] = $b_produk_id_harga[$k];
							$dip[$k]['qty'] = $qty[$k];
							$dip[$k]['sub_harga'] = (int) str_replace('.', '', $harga[$k]);
							$dip[$k]['tgl_pesan'] = $this->input->post('tgl_pesan');
							$dip[$k]['cdate'] = "NOW()";
						}
						$res_produk = $this->copm->setMass($dip);
						if ($res_produk) {
							$this->status = 200;
							$this->message = API_ADMIN_ERROR_CODES[$this->status];
						} else {
							$this->status = 110;
							$this->message = API_ADMIN_ERROR_CODES[$this->status];

							$res_hapus = $this->com->del($res);
						}
					}
				}


				$this->status = 200;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];
			} else {
				$this->status = 901;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];
			}
		} else {
			$this->status = 444;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}

		$this->__json_out($data);
	}

	/**
	 * Delete data by supplied ID
	 *
	 * @param  int   $id               ID value from a_fasilitas table
	 *
	 * @api
	 *
	 * @return void
	 */
	public function hapus($id)
	{
		$d = $this->__init();

		$data = array();
		if (!$this->admin_login) {
			$this->status = 400;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			header("HTTP/1.0 400 Harus login");
			$this->__json_out($data);
			die();
		}

		$id = (int) $id;
		if ($id <= 0) {
			$this->status = 520;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}
		$pengguna = $d['sess']->admin;

		$com = $this->com->id($id);
		if (!isset($com->id)) {
			$this->status = 521;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}
		if (!empty($com->is_deleted)) {
			$this->status = 522;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}

		$res = $this->com->update($id, array('is_deleted' => 1));
		if ($res) {
			$this->status = 200;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
		} else {
			$this->status = 902;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
		}
		$this->__json_out($data);
	}

	public function edit_foto($id)
	{
		$d = $this->__init();
		$data = array();
		if (!$this->admin_login) {
			$this->status = 400;
			$this->message = 'Harus login';
			header("HTTP/1.0 400 Harus login");
			$this->__json_out($data);
			die();
		}
		$id = (int) $id;
		$du = $_POST;
		if (!isset($du['id'])) $du['id'] = 0;
		if (empty($id)) {
			$id = (int) $du['id'];
			unset($du['id']);
		}
		$pengguna = $this->com->getById($id);
		if ($id > 0 && isset($pengguna->id)) {
			if (!empty($penguna_foto)) {
				if (strlen($pengguna->foto) > 4) {
					$foto = SEMEROOT . DIRECTORY_SEPARATOR . $pengguna->foto;
					if (file_exists($foto)) unlink($foto);
				}
				$du = array();
				$du['foto'] = $penguna_foto;
				$res = $this->com->update($id, $du);
				if ($res) {
					$this->status = 200;
					$this->message = 'Upload foto berhasil';
				} else {
					$this->status = 901;
					$this->message = 'Upload foto gagal';
				}
			} else {
				$this->status = 459;
				$this->message = 'Tidak ada file gambar yang terupload';
			}
		} else {
			$this->status = 550;
			$this->message = 'Dont hack this :P';
		}
		$this->__json_out($data);
	}

	//Temporary Select2 di Pengguna API
	public function select2()
	{
		$this->load("api_admin/b_user_model", 'bpm');
		$d = $this->__init();
		$keyword = $this->input->request('q');
		$ddata = $this->com->select2($keyword);
		$datares = array();
		$i = 0;
		foreach ($ddata as $key => $value) {
			$datares["results"][$i++] = array("id" => $value->id, "text" => $value->kode . " - " . $value->fnama);
		}
		header('Content-Type: application/json');
		echo json_encode($datares);
	}


	public function cari()
	{
		$keyword = $this->input->request("keyword");
		if (empty($keyword)) $keyword = "";
		$p = new stdClass();
		$p->id = 'NULL';
		$p->text = '-';
		$data = $this->com->cari($keyword);
		array_unshift($data, $p);
		$this->__json_select2($data);
	}
}
