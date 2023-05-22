<?php
class User extends \JI_Controller
{
	var $media_pengguna = 'media/pengguna';

	public function __construct()
	{
		parent::__construct();
		$this->load('b_user_concern');
		$this->load('b_user_alamat_concern');
		$this->load("api_front/b_user_model", 'bum');
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
		$this->_api_auth_required($data, 'user');

		$this->status = 200;
		$this->message = API_ADMIN_ERROR_CODES[$this->status];

		/** advanced filter is_active */
		$is_active = $this->input->request('is_active', '');
		if (strlen($is_active)) {
			$is_active = intval($is_active);
		}

		$user_login = $d['sess']->user;
		$b_user_id = '';
		// Jika user adalah reseller, maka mengambil kustomernya
		if (isset($user_login->utype) && ($user_login->utype == 'agen' || $user_login->utype == 'reseller')) {
			$b_user_id = $user_login->id;
		}

		$datatable = $this->bum->datatable()->initialize();
		$dcount = $this->bum->count($b_user_id, $datatable->keyword());
		$ddata = $this->bum->data(
			$b_user_id,
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
			if (isset($gd->utype)) {
				$gd->utype = ($gd->utype == 'agen' || $gd->utype == 'reseller') ? '<span class="badge badge-primary">Reseller</span>' : '<span class="badge badge-secondary">Kustomer</span>';
			}
			if (isset($gd->is_active)) {
				$gd->is_active = $this->bum->label('is_active', $gd->is_active);
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
		$data = [];
		$this->_api_auth_required($data, 'user');

		$_POST['cdate'] = 'NOW()';
		$_POST['adate'] = 'NOW()';
		$_POST['edate'] = 'null';
		$_POST['utype'] = 'member';
		$_POST['umur'] = '20';
		$_POST['api_reg_date'] = 'NOW()';
		$_POST['api_web_date'] = 'NOW()';
		$_POST['api_mobile_date'] = 'NOW()';
		$_POST['is_deleted'] = '0';
		$_POST['b_user_id'] = 'null';
		$data = new \stdClass();
		if (!$this->bum->validates()) {
			$this->status = 444;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$validation_message = $this->bum->validation_message();
			if (strlen($validation_message)) {
				$this->message = $validation_message;
			}
			$this->__json_out($data);
			die();
		}

		$res = $this->bum->save();
		if ($res) {
			$this->lib("conumtext");
			$token = $this->conumtext->genRand($type = "str", 9, 9);
			$update_apikey = $this->bum->update($res, ['apikey' => $token, 'b_user_id' => $d['sess']->user->id]);
			$di = $_POST;
			$dia = [];
			$dia['b_user_id'] = $res;
			$dia['provinsi'] = isset($di['provinsi']) ? $di['provinsi'] : null;
			$dia['telp'] = isset($di['telp']) ? $di['telp'] : null;
			$dia['alamat'] = isset($di['alamat']) ? $di['alamat'] : null;
			$dia['alamat2'] = isset($di['alamat2']) ? $di['alamat2'] : null;
			$dia['kelurahan'] = isset($di['kelurahan']) ? $di['kelurahan'] : null;
			$dia['kecamatan'] = isset($di['kecamatan']) ? $di['kecamatan'] : null;
			$dia['kabkota'] = isset($di['kabkota']) ? $di['kabkota'] : null;
			$dia['provinsi'] = isset($di['provinsi']) ? $di['provinsi'] : null;
			$dia['negara'] = isset($di['negara']) ? $di['negara'] : null;
			$dia['kodepos'] = isset($di['kodepos']) ? $di['kodepos'] : null;
			$dia['kode_destination'] = isset($di['kode_destination']) ? $di['kode_destination'] : null;
			$dia['kode_origin'] = isset($di['kode_origin']) ? $di['kode_origin'] : null;
			$res_alamat = $this->buam->set($dia);
			if ($res_alamat) {
				$this->status = 200;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];
			} else {
				$this->bum->del($res);
				$this->status = 110;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];
			}
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
		if (!$this->user_login) {
			$this->status = 400;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			header("HTTP/1.0 400 Harus login");
			$this->__json_out($data);
			die();
		}
		$id = (int) $id;

		$this->status = 200;
		$this->message = API_ADMIN_ERROR_CODES[$this->status];
		$data = $this->bum->id($id);
		if (!isset($data->id)) {
			$data = new \stdClass();
			$this->status = 441;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}
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
	public function edit($id)
	{
		$d = $this->__init();
		$data = array();

		if (!$this->user_login) {
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

		if (!$this->bum->validates()) {
			$this->status = 444;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$validation_message = $this->bum->validation_message();
			if (strlen($validation_message)) {
				$this->message = $validation_message;
			}
			$this->__json_out($data);
			die();
		}

		$res = $this->bum->save($id);
		if ($res) {
			$di = $_POST;
			$dua = [];
			$dua['b_user_id'] = $id;
			$dua['provinsi'] = isset($di['provinsi']) ? $di['provinsi'] : null;
			$dua['telp'] = isset($di['telp']) ? $di['telp'] : null;
			$dua['alamat'] = isset($di['alamat']) ? $di['alamat'] : null;
			$dua['alamat2'] = isset($di['alamat2']) ? $di['alamat2'] : null;
			$dua['kelurahan'] = isset($di['kelurahan']) ? $di['kelurahan'] : null;
			$dua['kecamatan'] = isset($di['kecamatan']) ? $di['kecamatan'] : null;
			$dua['kabkota'] = isset($di['kabkota']) ? $di['kabkota'] : null;
			$dua['provinsi'] = isset($di['provinsi']) ? $di['provinsi'] : null;
			$dua['negara'] = isset($di['negara']) ? $di['negara'] : null;
			$dua['kodepos'] = isset($di['kodepos']) ? $di['kodepos'] : null;
			$dua['kode_destination'] = isset($di['kode_destination']) ? $di['kode_destination'] : null;
			$dua['kode_origin'] = isset($di['kode_origin']) ? $di['kode_origin'] : null;
			$res_alamat = $this->buam->update($di['b_user_alamat_id'], $dua);
			$this->status = 200;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
		} else {
			$this->status = 901;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
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
		if (!$this->user_login) {
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

		$bum = $this->bum->id($id);
		if (!isset($bum->id)) {
			$this->status = 521;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}
		if (!empty($bum->is_deleted)) {
			$this->status = 522;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}

		$res = $this->bum->update($id, array('is_deleted' => 1));
		if ($res) {
			$buam = $this->buam->getByUserId($id);
			if (isset($buam->id)) {
				$res_alamat = $this->buam->update($buam->id, ['is_deleted' => 1]);
			}
			$this->status = 200;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
		} else {
			$this->status = 902;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
		}
		$this->__json_out($data);
	}
	public function editpass($id = "")
	{
		$d = $this->__init();
		$data = array();
		if (!$this->user_login) {
			$this->status = 400;
			$this->message = 'Harus login';
			header("HTTP/1.0 400 Harus login");
			$this->__json_out($data);
			die();
		}
		$id = (int) $id;
		$du = $_POST;
		if (!isset($du['id'])) $du['id'] = 0;
		unset($du['id']);
		if ($id > 0) {
			if (strlen($du['password'])) {
				$du['password'] = md5($du['password']);
				$res = $this->bum->update($id, $du);
				$this->status = 200;
				$this->message = 'Perubahan berhasil diterapkan';
			} else {
				$this->status = 901;
				$this->message = 'Password terlalu pendek';
			}
		} else {
			$this->status = 447;
			$this->message = 'ID Pengguna tidak valid';
		}
		$this->__json_out($data);
	}


	public function edit_foto($id)
	{
		$d = $this->__init();
		$data = array();
		if (!$this->user_login) {
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
		$pengguna = $this->bum->getById($id);
		if ($id > 0 && isset($pengguna->id)) {
			if (!empty($penguna_foto)) {
				if (strlen($pengguna->foto) > 4) {
					$foto = SEMEROOT . DIRECTORY_SEPARATOR . $pengguna->foto;
					if (file_exists($foto)) unlink($foto);
				}
				$du = array();
				$du['foto'] = $penguna_foto;
				$res = $this->bum->update($id, $du);
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
		$this->load("api_admin/b_user_model", 'bum');
		$d = $this->__init();
		$keyword = $this->input->request('q');
		$ddata = $this->bum->select2($keyword);
		$datares = array();
		$i = 0;
		foreach ($ddata as $key => $value) {
			$datares["results"][$i++] = array("id" => $value->id, "text" => $value->kode . " - " . $value->fnama);
		}
		header('Content-Type: application/json');
		echo json_encode($datares);
	}

	public function hak_akses()
	{
		$d = $this->__init();
		$data = array();
		if (!$this->user_login) {
			$this->status = 400;
			$this->message = 'Harus login';
			header("HTTP/1.0 400 Harus login");
			$this->__json_out($data);
			die();
		}
		$this->load('api_admin/a_pengguna_module_model', 'bumm');
		$a_pengguna_id			= $_POST['a_pengguna_id'];
		$a_modules_identifier	= $_POST['a_modules_identifier'];

		$this->bumm->updateModule(array('tmp_active' => 'N'), $a_pengguna_id);

		foreach ($a_modules_identifier as $ami) {
			$arr							= array();
			$arr['a_pengguna_id']			= $a_pengguna_id;
			$arr['a_modules_identifier']	= $ami;
			$arr['rule']					= 'allowed';
			$arr['tmp_active']				= 'Y';

			$check_ami = $this->bumm->check_access($a_pengguna_id, $ami);
			if ($check_ami == 0) {
				$this->bumm->set($arr);
			} else {
				$this->bumm->updateModule($arr, $a_pengguna_id, $ami);
			}
		}

		$res = $this->bumm->delModule($a_pengguna_id);

		if ($res) {
			$this->status 	= 200;
			$this->message 	= 'Berhasil disimpan';
		} else {
			$this->status 	= 901;
			$this->message 	= 'Terjadi kesalahan dalam proses';
		}

		$this->__json_out($data);
	}
	public function pengguna_module()
	{
		$this->load('api_admin/a_pengguna_module_model', 'bumm');
		$d 			= $this->__init();
		$id			= $this->input->post('id');
		$ddata 		= $this->bumm->pengguna_module($id);
		$datares 	= array();
		$i 			= 0;
		foreach ($ddata as $key => $value) {
			$datares[$i++] = $value->a_modules_identifier;
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
		$data = $this->bum->cari($keyword);
		array_unshift($data, $p);
		$this->__json_select2($data);
	}

	public function editProfil($id = "")
	{
		$d = $this->__init();
		$data = array();

		$du = $_POST;
		// dd($du);
		// if (!$this->user_login) {
		// 	$this->status = 400;
		// 	$this->message = API_ADMIN_ERROR_CODES[$this->status];
		// 	header("HTTP/1.0 400 Harus login");
		// 	$this->__json_out($data);
		// 	die();
		// }

		$id = (int) $id;
		$id = isset($du['id']) ? $du['id'] : 0;
		if ($id <= 0) {
			$this->status = 444;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		} else {
			unset($du['id']);
			$res = $this->bum->update($id, $du);
			if ($res) {
				$this->status = 200;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];
			} else {
				$this->status = 901;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];
			}
		}

		$this->__json_out($data);
	}

	public function changePass($id = "")
	{
		$d = $this->__init();
		$data = array();

		$du = $_POST;
		// dd($du);
		// if (!$this->user_login) {
		// 	$this->status = 400;
		// 	$this->message = API_ADMIN_ERROR_CODES[$this->status];
		// 	header("HTTP/1.0 400 Harus login");
		// 	$this->__json_out($data);
		// 	die();
		// }

		$is_reset = false;
		if (isset($du['is_reset'])) {
			$is_reset = $du['is_reset'];
			unset($du['is_reset']);
		}

		// dd($du['is_reset']);
		$id = (int) $id;
		// $du = $_POST;
		$id =  isset($du['id']) ? $du['id'] : 0;
		unset($du['id']);
		if ($id > 0) {
			$dtuser = $this->bum->getUserById($id);
			// dd(["old" => $dtuser->password, "conf" => md5($du['old_pass'])]);
			if ($is_reset) {
				if (strlen($du['new_pass'])) {
					$du['password'] = md5($du['new_pass']);
					unset($du['old_pass']);
					unset($du['new_pass']);
					unset($du['confirm_new_pass']);
					$res = $this->bum->update($id, $du);
					$this->status = 200;
					$this->message = 'Perubahan berhasil diterapkan';
				} else {
					$this->status = 901;
					$this->message = 'Password terlalu pendek';
				}
			} else {
				if ($dtuser->password == md5($du['old_pass'])) {
					if (strlen($du['new_pass'])) {
						$du['password'] = md5($du['new_pass']);
						unset($du['old_pass']);
						unset($du['new_pass']);
						unset($du['confirm_new_pass']);
						$res = $this->bum->update($id, $du);
						$this->status = 200;
						$this->message = 'Perubahan berhasil diterapkan';
					} else {
						$this->status = 901;
						$this->message = 'Password terlalu pendek';
					}
				} else {
					$this->status = 402;
					$this->message = 'Password salah';
				}
			}
		} else {
			$this->status = 447;
			$this->message = 'ID Pengguna tidak valid';
		}
		$this->__json_out($data);
	}
}
