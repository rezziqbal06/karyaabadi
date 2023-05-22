<?php

class Asesmen extends JI_Controller
{
	var $media_pengguna = 'media/pengguna';

	public function __construct()
	{
		parent::__construct();
		$this->load('a_jpenilaian_concern');
		$this->load('a_indikator_concern');
		$this->load('b_user_concern');
		$this->load('b_user_module_concern');
		$this->load('c_asesmen_concern');
		$this->load('d_value_concern');

		$this->load("api_front/a_jpenilaian_model", 'ajm');
		$this->load("api_front/a_indikator_model", 'aim');
		$this->load("api_front/b_user_model", 'bum');
		$this->load("api_front/b_user_module_model", 'bumm');
		$this->load("api_front/c_asesmen_model", 'cam');
		$this->load("api_front/d_value_model", 'dvm');
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

		/** advanced filter is_active */
		$a_unit_id = $this->input->request('a_unit_id', '');
		if (strlen($a_unit_id)) {
			$a_unit_id = intval($a_unit_id);
		}
		$is_active = $this->input->request('is_active', '');
		if (strlen($is_active)) {
			$is_active = intval($is_active);
		}

		$admin_login = $d['sess']->user;
		$b_user_id = '';
		// Jika user adalah reseller, maka mengambil kustomernya
		// if (isset($admin_login->utype) && $admin_login->utype == 'agen') {
		// 	$b_user_id = $admin_login->id;
		// }

		$datatable = $this->cam->datatable()->initialize();
		$dcount = $this->cam->count($b_user_id, $datatable->keyword(), $is_active, $a_unit_id);
		$ddata = $this->cam->data(
			$b_user_id,
			$datatable->page(),
			$datatable->pagesize(),
			$datatable->sort_column(),
			$datatable->sort_direction(),
			$datatable->keyword(),
			$is_active,
			$a_unit_id
		);

		foreach ($ddata as &$gd) {
			if (isset($gd->fnama)) {
				$gd->fnama = htmlentities(rtrim($gd->fnama, ' - '));
			}
			if (isset($gd->utype)) {
				$gd->utype = ($gd->utype == 'agen' || $gd->utype == 'reseller') ? '<span class="label label-warning">Reseller</span>' : '<span class="label label-primary">Member</span>';
			}
			if (isset($gd->is_active)) {
				$gd->is_active = $this->cam->label('is_active', $gd->is_active);
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
		if (!$this->user_login) {
			$this->status = 400;
			$this->message = 'Harus login';
			header("HTTP/1.0 400 Harus login");
			$this->__json_out($data);
			die();
		}

		if (!$this->cam->validates()) {
			$this->status = 444;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$validation_message = $this->cam->validation_message();
			if (strlen($validation_message)) {
				$this->message = $validation_message;
			}
			$this->__json_out($data);
			die();
		}

		$ajm = $this->ajm->id($this->input->post('a_jpenilaian_id'));
		if (!isset($ajm->id)) {
			$this->status = 444;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}

		$nomor = $this->input->request('nomor');
		// Validasi Value
		if ($ajm->type_form == 1) {
			$indikator = $this->input->request('a_indikator_id');
			if (!is_array($indikator) || !count($indikator)) {
				$this->status = 444;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];
				$validation_message = $this->cam->validation_message();
				if (strlen($validation_message)) {
					$this->message = $validation_message;
				}
				$this->__json_out($data);
				die();
			}
			foreach ($indikator as $k => $v) {
				if (!empty((int) $v) && empty((int) $this->input->request('a_aksi_id_' . $nomor[$k], null))) {
					$this->status = 444;
					$this->message = API_ADMIN_ERROR_CODES[$this->status];
					$validation_message = $this->cam->validation_message();
					if (strlen($validation_message)) {
						$this->message = $validation_message;
					}
					$this->__json_out($data);
					die();
				} else if (empty((int) $v) && !empty((int) $this->input->request('a_aksi_id_' . $nomor[$k], null))) {
					$this->status = 444;
					$this->message = API_ADMIN_ERROR_CODES[$this->status];
					$validation_message = $this->cam->validation_message();
					if (strlen($validation_message)) {
						$this->message = $validation_message;
					}
					$this->__json_out($data);
					die();
				}
			}
		} elseif ($ajm->type_form == 2) {
			$aksi = $this->input->request("aksi");
			if (!is_array($aksi) || !count($aksi)) {
				$this->status = 444;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];
				$validation_message = $this->cam->validation_message();
				if (strlen($validation_message)) {
					$this->message = $validation_message;
				}
				$this->__json_out($data);
				die();
			}
		} elseif ($ajm->type_form == 3) {
			$a_indikator_id = $this->input->request('a_indikator_id');
			if (!is_array($a_indikator_id) || !count($a_indikator_id)) {
				$this->status = 444;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];
				$validation_message = $this->cam->validation_message();
				if (strlen($validation_message)) {
					$this->message = $validation_message;
				}
				$this->__json_out($data);
				die();
			}
			$a_indikator_aksi = $this->input->request('a_indikator_aksi');
			$aksi = $this->aim->getByPenilaian('aksi', $ajm->id);
			$params = [];
			$persentase = 0;
			foreach ($aksi as $key => $v) {
				$params[] = $v->id;
			}
			$is_empty = 0;
			$is_empty_indikator = 1;
			foreach ($a_indikator_id as $k => $v) {
				if (isset($v) && !empty((int)$v)) {
					$is_empty_indikator = 0;
				}
				if (isset($v) && !empty((int)$v) && !isset($a_indikator_aksi[$k])) {
					$is_empty = 1;
				} else if (isset($v) && empty((int)$v) && isset($a_indikator_aksi[$k])) {
					$is_empty = 1;
				}
			}
			if ($is_empty_indikator || $is_empty) {
				$this->status = 444;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];
				$validation_message = $this->cam->validation_message();
				if (strlen($validation_message)) {
					$this->message = $validation_message;
				}
				$this->__json_out($data);
				die();
			}
		}


		$b_user_id = !empty((int) $this->input->request('b_user_id')) ? $this->input->request('b_user_id') : '';
		if (!isset($b_user_id) || !strlen($b_user_id)) {
			$bum = $this->bum->getByName($this->input->request('user'));
			if (isset($bum->id)) {
				$this->cam->columns['b_user_id']->value = $bum->id;
			} else {
				$bu = [];
				$bu['fnama'] = $this->input->request('user');
				$bu['a_unit_id'] = $this->input->request('a_ruangan_id');
				$bu['a_jabatan_id'] = $this->input->request('a_jabatan_id');
				$bu['cdate'] = 'now()';
				$resUser = $this->bum->set($bu);
				if ($resUser) {
					$b_user_id = $resUser;
					$this->cam->columns['b_user_id']->value = $resUser;
				}
			}
		}

		if ($ajm->type_form == 2) {
			$cdate = $this->input->request('cdate');
			$a_ruangan_id = $this->input->request('a_ruangan_id');
			$cam_this_date = $this->cam->getByDateAndUser($ajm->id, $cdate, $d['sess']->user->id, '', $a_ruangan_id);
			if (isset($cam_this_date->id)) {
				$this->status = 903;
				$this->message = 'Penilaian pada tanggal ini sudah di buat oleh anda. Silakan lakukan pengubahan di penilaian sebelumnya.';
				$this->__json_out($data);
				die();
			}
		} else {
			$cdate = $this->input->request('cdate');
			$cam_this_date = $this->cam->getByDateAndUser($ajm->id, $cdate, $d['sess']->user->id, $b_user_id);
			if (isset($cam_this_date->id)) {
				$this->status = 903;
				$this->message = 'Penilaian pada tanggal ini sudah di buat oleh anda. Silakan lakukan pengubahan di penilaian sebelumnya.';
				$this->__json_out($data);
				die();
			}
		}


		date_default_timezone_set('Asia/Jakarta');
		$stime = $this->input->request('stime');
		$etime = date('H:i:s');
		$time1 = new DateTime(date('Y-m-d') . ' ' . $stime);
		$time2 = new DateTime();
		$timediff = $time1->diff($time2);

		$this->cam->columns['etime']->value = $etime;
		$this->cam->columns['cdate']->value = date('Y-m-d H:i:s');
		$this->cam->columns['b_user_id_penilai']->value = isset($d['sess']->user->id) ? $d['sess']->user->id : 0;

		$this->cam->columns['durasi']->value = $timediff->h . '.' . $timediff->i;

		$penilais = $this->input->request('b_user_id_penilais');
		$value = [];
		if ($ajm->type_form == 1) {
			$nilai = 0;
			$value = [];
			$indikator = $this->input->request('a_indikator_id');
			if (is_array($indikator) && count($indikator)) {
				foreach ($indikator as $k => $v) {
					if (!empty((int) $v) && !empty((int) $this->input->request('a_aksi_id_' . $nomor[$k], null))) {
						$value[$k]['b_user_id'] = isset($penilais[$k]) ? $penilais[$k] : 0;
						$value[$k]['indikator'] = $v;
						$value[$k]['aksi'] = $this->input->request('a_aksi_id_' . $nomor[$k], null);
						$aksi = $this->aim->id($value[$k]['aksi']);
						if (isset($aksi->nama) && ($aksi->nama == 'HW' || $aksi->nama == 'HR')) {
							$nilai++;
						}
					}
				}
				$this->cam->columns['nilai']->value = $nilai;
			}


			$this->cam->columns['cdate']->value = date('Y-m-d', strtotime($this->input->request('cdate')));
		} else if ($ajm->type_form == 2) {
			$value = [];
			$aksi = $this->input->request("aksi");
			$poin = 0;
			foreach ($aksi as $k => $v) {
				$value[] = [
					"b_user_id" => isset($penilais[$k]) ? $penilais[$k] : 0,
					"indikator" => "$k",
					"aksi" => $v
				];
				if ($v == "y") {
					$poin++;
				}
			}
			$nilai = ($poin / count($aksi)) * 100;
			$nilai = ceil($nilai);
			$this->cam->columns['nilai']->value = $nilai;
			$this->cam->columns['cdate']->value = date('Y-m-d', strtotime($this->input->request('cdate')));
		} else if ($ajm->type_form == 3) {
			$value = [];
			$a_indikator_id = $this->input->request('a_indikator_id');
			$a_indikator_aksi = $this->input->request('a_indikator_aksi');
			$aksi = $this->aim->getByPenilaian('aksi', $ajm->id);
			$params = [];
			$persentase = 0;
			foreach ($aksi as $key => $v) {
				if (isset($v->is_optional) && !$v->is_optional) $params[] = $v->id;
			}
			foreach ($a_indikator_id as $k => $v) {
				if (isset($a_indikator_aksi[$k]) && $a_indikator_aksi[$k] != "") {
					$value[$k]['b_user_id'] = isset($penilais[$k]) ? $penilais[$k] : 0;
					$value[$k]['indikator'] = $v;
					$aksi = [];
					$nilai_per_item = 0;
					foreach ($a_indikator_aksi[$k] as $k1 => $v1) {
						$aksi[] = $k1;
						if (in_array($k1, $params)) {
							$nilai_per_item++;
						}
					}
					$persentase += ($nilai_per_item / count($params)) * 100;
					$value[$k]['aksi'] = $aksi;
				}
			}
			$total_persentase = ($persentase / (count($a_indikator_id) * 100)) * 100;
			$this->cam->columns['nilai']->value = ceil($total_persentase);
			$this->cam->columns['cdate']->value = date('Y-m-d', strtotime($this->input->request('cdate')));
		}
		$json_value = json_encode($value);
		$this->cam->columns['value']->value = $json_value;
		$res = $this->cam->save();
		if ($res) {
			if ($ajm->type_form != 3) {
				if ($value) {
					foreach ($value as $k => $v) {
						$value[$k]['c_asesmen_id'] = $res;
						$value[$k]['b_user_id'] = isset($d['sess']->user->id) ? $d['sess']->user->id : 0;
					}
				}
				$resValue = $this->dvm->setMass($value);
				if (!$resValue) {
					$this->cam->delById($res);
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
		$data = $this->cam->id($id);
		if (!isset($data->id)) {
			$data = [];
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
	public function edit($id = "")
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
		$du = $_POST;


		$id = (int)$id;


		$id = (int) $id;
		if ($id <= 0) {
			$this->status = 444;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}

		$cam = $this->cam->id($id);
		if (!isset($cam->id)) {
			$this->status = 445;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}

		if (!$this->cam->validates()) {
			$this->status = 444;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$validation_message = $this->cam->validation_message();
			if (strlen($validation_message)) {
				$this->message = $validation_message;
			}
			$this->__json_out($data);
			die();
		}

		$ajm = $this->ajm->id($this->input->post('a_jpenilaian_id'));
		if (!isset($ajm->id)) {
			$this->status = 444;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}

		$b_user_id = !empty((int) $this->input->request('b_user_id')) ? $this->input->request('b_user_id') : '';
		if (!isset($b_user_id) || !strlen($b_user_id)) {
			$bum = $this->bum->getByName($this->input->request('user'));
			if (isset($bum->id)) {
				$this->cam->columns['b_user_id']->value = $bum->id;
			} else {
				$bu = [];
				$bu['fnama'] = $this->input->request('user');
				$bu['a_unit_id'] = $this->input->request('a_ruangan_id');
				$bu['a_jabatan_id'] = $this->input->request('a_jabatan_id');
				$bu['cdate'] = 'now()';
				$resUser = $this->bum->set($bu);
				if ($resUser) {
					$this->cam->columns['b_user_id']->value = $resUser;
				}
			}
		}

		date_default_timezone_set('Asia/Jakarta');
		$stime = $this->input->request('stime');
		$etime = date('H:i:s');
		$time1 = new DateTime(date('Y-m-d') . ' ' . $stime);
		$time2 = new DateTime();
		$timediff = $time1->diff($time2);

		$this->cam->columns['etime']->value = $etime;
		$this->cam->columns['cdate']->value = date('Y-m-d H:i:s');
		$this->cam->columns['b_user_id_penilai']->value = isset($d['sess']->user->id) ? $d['sess']->user->id : 0;

		$this->cam->columns['durasi']->value = $timediff->h . '.' . $timediff->i;

		$value = [];
		if ($ajm->type_form == 1) {
			$nilai = 0;
			$value = [];
			$indikator = $this->input->request('a_indikator_id');
			$penilais = $this->input->request('b_user_id_penilais');
			$nomor = $this->input->request('nomor');
			if (is_array($indikator) && count($indikator)) {
				foreach ($indikator as $k => $v) {
					if (!empty((int) $v) && !empty((int) $this->input->request('a_aksi_id_' . $nomor[$k], null))) {
						$value[$k]['c_asesmen_id'] = $id;
						$value[$k]['b_user_id'] = isset($penilais[$k]) ? $penilais[$k] : 0;
						$value[$k]['indikator'] = $v;
						$value[$k]['aksi'] = $this->input->request('a_aksi_id_' . $nomor[$k], null);
						$aksi = $this->aim->id($value[$k]['aksi']);
						if (isset($aksi->nama) && ($aksi->nama == 'HW' || $aksi->nama == 'HR')) {
							$nilai++;
						}
					}
				}

				$this->cam->columns['nilai']->value = $nilai;
			}
		} else if ($ajm->type_form == 2) {
			$value = [];
			$aksi = $this->input->request("aksi");
			$penilais = $this->input->request('b_user_id_penilais');
			$poin = 0;

			foreach ($aksi as $k => $v) {
				$value[] = [
					"c_asesmen_id" => $id,
					"b_user_id" => isset($penilais[$k]) ? $penilais[$k] : 0,
					"indikator" => "$k",
					"aksi" => $v
				];
				if ($v == "y") {
					$poin++;
				}
			}
			$nilai = ($poin / count($aksi)) * 100;
			$nilai = ceil($nilai);
			$this->cam->columns['nilai']->value = $nilai;
			$this->cam->columns['cdate']->value = date('Y-m-d', strtotime($this->input->request('cdate')));
		} else if ($ajm->type_form == 3) {
			$value = [];
			$indikator = $this->input->request('a_indikator_id');
			$penilais = $this->input->request('b_user_id_penilais');
			$aksi = $this->aim->getByPenilaian('aksi', $ajm->id);
			$params = [];
			foreach ($aksi as $key => $v) {
				$params[] = $v->id;
			}
			$persentase = 0;
			foreach ($indikator as $k => $v) {
				$aksi = [];
				$nilai_per_item = 0;
				foreach ($v as $k1 => $v1) {
					$aksi[] = $k1;
					if (in_array($k1, $params)) {
						$nilai_per_item++;
					}
				}
				$persentase += ($nilai_per_item / count($params)) * 100;
				$value[] = [
					"c_asesmen_id" => $id,
					"b_user_id" => isset($penilais[$k]) ? $penilais[$k] : 0,
					"indikator" => $k,
					"aksi" => $aksi
				];
			}
			$total_persentase = ($persentase / (count($indikator) * 100)) * 100;
			$this->cam->columns['nilai']->value = ceil($total_persentase);
			$this->cam->columns['cdate']->value = date('Y-m-d', strtotime($this->input->request('cdate')));
		}
		$json_value = json_encode($value);
		$this->cam->columns['value']->value = $json_value;
		if ($id > 0) {
			unset($du['id']);
			$res = $this->cam->save($id);
			if ($res) {

				if ($ajm->type_form != 3) {
					$resDeleteValue = $this->dvm->delByAsesmenId($id);
					$resValue = $this->dvm->setMass($value);
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

	public function hardDelete($id)
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
		$d_value = $this->dvm->getByAsesmenId($id);
		if (isset($d_value->id)) {
			$this->dvm->delByAsesmenId($id);
		}
		$this->cam->delById($id);
		if (isset($_SERVER['HTTP_REFERER'])) {
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		} else {
			// handle case where there is no previous page
		}
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

		$cam = $this->cam->id($id);
		if (!isset($cam->id)) {
			$this->status = 521;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}
		if (!empty($cam->is_deleted)) {
			$this->status = 522;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}

		$res = $this->cam->update($id, array('is_deleted' => 1));
		if ($res) {
			$this->status = 200;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
		} else {
			$this->status = 902;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
		}
		$this->__json_out($data);
	}

	/**
	 * Give json data set result on datatable format
	 *
	 * @api
	 *
	 * @return void
	 */
	public function list()
	{
		$d = $this->__init();
		$data = array();
		$this->_api_auth_required($data, 'user');

		$this->status = 200;
		$this->message = API_ADMIN_ERROR_CODES[$this->status];

		/** advanced filter is_active */
		$a_jpenilaian_id = $this->input->request('a_jpenilaian_id', '');
		$a_ruangan_id = $this->input->request('a_ruangan_id', '');
		$b_user_id = $this->input->request('b_user_id', '');
		$b_user_id_penilai = $this->input->request('b_user_id_penilai', $d['sess']->user->id);
		$is_active = $this->input->request('is_active', '');
		$sdate = $this->input->request('sdate', '');
		$bulan = $this->input->request('bulan', '');
		$edate = $this->input->request('edate', '');
		$page = $this->input->request('page', 1);
		$pagesize = $this->input->request('pagesize', 9);
		$sort_column = $this->input->request('sort_column', 'id');
		$sort_direction = $this->input->request('sort_direction', 'desc');
		$keyword = $this->input->request('keyword', '');

		// if ($d['sess']->user->profesi == 'IPCN' || $d['sess']->user->profesi == 'Komite Mutu') {
		// 	$b_user_id_penilai = '';
		// }

		if (strlen($bulan)) {
			$sdate = $bulan;
			$dates = explode('-', $sdate);
			$edate = date($dates[0] . '-' . $dates[1] . '-t');
		}


		$ajm = $this->ajm->id($a_jpenilaian_id);
		if (!isset($ajm->id)) {
			$this->status = 400;
			$this->message = "Data tidak ditemukan";
			$this->__json_out($data);
			die();
		}
		$data['ajm'] = $ajm;

		$aim = $this->aim->getByPenilaianId($ajm->id);
		if (!isset($aim[0]->id)) {
			$this->status = 400;
			$this->message = "Data tidak ditemukan";
			$this->__json_out($data);
			die();
		}
		$data['aim'] = $aim;

		$data['permission'] = new \stdClass;
		$data['permission']->read = $this->bumm->getPermission($ajm->id, "read", $d['sess']->user->a_jabatan_id, $d['sess']->user->id);
		$data['permission']->chart = $this->bumm->getPermission($ajm->id, "chart", $d['sess']->user->a_jabatan_id, $d['sess']->user->id);
		$data['permission']->export = $this->bumm->getPermission($ajm->id, "export", $d['sess']->user->a_jabatan_id, $d['sess']->user->id);

		$hand_hygiene = [];
		$datasets = [];
		$ddata = [];
		$dcount = 0;

		if ($data['permission']->read) {
			$dcount = $this->cam->count($b_user_id, $b_user_id_penilai, $a_jpenilaian_id, $a_ruangan_id, $sdate, $edate, $keyword, $is_active);
			$ddata = $this->cam->data(
				$page,
				$pagesize,
				$sort_column,
				$sort_direction,
				$b_user_id,
				$b_user_id_penilai,
				$a_jpenilaian_id,
				$a_ruangan_id,
				$sdate,
				$edate,
				$keyword,
				$is_active
			);

			$datasets = $this->cam->datasets($b_user_id, $b_user_id_penilai, $a_jpenilaian_id, $a_ruangan_id, $sdate, $edate, $keyword, $is_active);
			foreach ($datasets as $k => $v) {
				$percent = ($v->nilai / $v->jumlah) * 100;
				$v->percent = $percent;
				unset($v->nilai);
				unset($v->jumlah);
			}
		}


		$jenis_penilaian = $this->ajm->getBySlug($ajm->slug);
		if ($data['permission']->chart) {
			$hand_hygiene = $this->cam->chart_series($jenis_penilaian->id);
		}
		unset($aim);
		unset($ajm);

		if (count($ddata)) {

			foreach ($ddata as &$gd) {
				if (isset($gd->is_active)) {
					$gd->is_active = $this->cam->label('is_active', $gd->is_active);
				}

				if (isset($gd->cdate)) {
					$gd->cdate = $this->__dateIndonesia($gd->cdate);
				}

				if (isset($gd->value)) {
					$gd->value = json_decode($gd->value);
				}

				if (isset($gd->durasi)) {
					$durasis = explode('.', $gd->durasi);

					$gd->durasi = '';
					if ((int) $durasis[0]) $gd->durasi .= $durasis[0] . ' jam ';
					if ((int) $durasis[1]) $gd->durasi .= $durasis[1] . ' menit';
				}
			}
		}

		$total_pages = ceil($dcount / $pagesize);

		// Pagination markup using Bootstrap 5
		$pg = '<nav><ul class="pagination gap-2">';
		if ($page > 1) {
			$pg .= '<li class="page-item"><a class="page-link" href="#" onclick="goToPage(' . ($page - 1) . ')"><span class="fa fa-chevron-left"></span></a></li>';
		} else {
			$pg .= '<li class="page-item disabled"><a class="page-link" href="#"><span class="fa fa-chevron-left"></span></a></li>';
		}
		for ($i = 1; $i <= $total_pages; $i++) {
			if ($i == $page) {
				$pg .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
			} else {
				$pg .= '<li class="page-item"><a class="page-link" href="#" onclick="goToPage(' . $i . ')">' . $i . '</a></li>';
			}
		}
		if ($page < $total_pages) {
			$pg .= '<li class="page-item"><a class="page-link" href="#" onclick="goToPage(' . ($page + 1) . ')"><span class="fa fa-chevron-right"></span></a></li>';
		} else {
			$pg .= '<li class="page-item disabled"><a class="page-link" href="#"><span class="fa fa-chevron-right"></span></a></li>';
		}
		$pg .= '</ul></nav>';


		$data['datasets'] = $datasets;
		$data['list'] = $ddata;
		$data['count'] = $dcount;
		$data['pagesize'] = $pagesize;
		$data['page'] = $page;
		$data['pagination'] = $pg;

		$data['data'] = $hand_hygiene;
		$data['is_zip_loaded'] = extension_loaded('zip');

		$this->__json_out($data);
	}

	public function chart_asesmen()
	{
		$d = $this->__init();
		$data = array();
		$this->_api_auth_required($data, 'user');

		$this->status = 200;
		$this->message = API_ADMIN_ERROR_CODES[$this->status];

		$slug_penilaian = $this->input->request('slug', '');
		$jenis_penilaian = $this->ajm->getBySlug($slug_penilaian);
		$hand_hygiene = $this->cam->chart_series($jenis_penilaian->id);
		// dd($hand_hygiene);
		$data = [
			"data" => $hand_hygiene,
		];
		$this->__json_out($data);
	}

	public function indicatorLists($slug = "", $a_ruangan_id = 0)
	{
		$d = $this->__init();
		$data = array();
		$this->_api_auth_required($data, 'user');

		$this->status = 200;
		$this->message = API_ADMIN_ERROR_CODES[$this->status];

		/** advanced filter is_active */

		if (!strlen($slug)) {
			redir(base_url('asesmen'));
			die();
		}

		$ajm = $this->ajm->getBySlug($slug);
		if (!isset($ajm->id)) {
			redir(base_url('asesmen'));
			die();
		}
		$data['ajm'] = $ajm;

		$aim = $this->aim->getByIndikator($a_ruangan_id, $ajm->id);
		if (!isset($aim[0]->id)) {
			$aim = [];
		} else {
			$group_by_kategori = [];
			foreach ($aim as $key) {
				$group_by_kategori[$key->kategori][] = $key;
			}
			$aim = $group_by_kategori;
		}
		$data['aim'] = $aim;






		// $type_form = 1;
		// if (in_array($ajm->slug, ['audit-hand-hygiene'])) {
		// 	$type_form = 1;
		// }else if(in_array($ajm->slug, ['monitoring-kegiatan-harian-pencegahan-pengendalian-infeksi-ppi'])){
		// 	$type_form = 2;
		// 	$group_by_kategori = [];
		// 	if($a_ruangan_id > 0){
		// 		dd($aim);
		// 		foreach ($aim as $k => $v) {
		// 			if(!in_array($a_ruangan_id,$v->a_ruangan_ids)){
		// 				array_pop($aim[$k]);
		// 			}
		// 		}
		// 	}
		// 	foreach ($aim as $key ) {
		// 		$group_by_kategori[$key->kategori][] = $key;
		// 	}
		// 	$data['aim'] = $group_by_kategori;
		// }

		// $data['type_form'] = $type_form;

		// unset($type_form);
		// unset($ajm);
		// unset($aim);
		// unset($aim);

		// date_default_timezone_set('Asia/Jakarta');
		// $data['stime'] = date('H:i:s');

		$this->__json_out($data);
	}

	public function printing()
	{
		$data = [];
		$content = $this->input->post('content');
		if (!isset($content)) {
			$this->status = 400;
			$this->message = 'Data tidak ditemukan';
			$this->__json_out($data);
			die();
		}
		$html = '<!DOCTYPE html>
		<html lang="en">
		
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Document</title>
		</head>
		
		<body>';
		$html .= '<style>
					@page { margin: 25px; }
					body { 
						margin-left: 25px; 
						margin-right: 25px; 
						margin-top: 25px; 
						font-family: "Helvetica", "Arial", sans-serif;
					}
					.text-center {
						text-align: center;
					}

					h4{
						margin-bottom:0px;
					}

					.my_table {
						margin-bottom: 0.5rem;
						width: 100%;
						border-collapse: collapse;
					}

					.my_table td {
						border: 1px solid #121212;
						padding-left: 0.5rem;
						padding-bottom: 0.4rem;
					}

					.my_table th {
						border: 1px solid #121212;
						padding: 0.1rem;
					}

					.check {
						border: 1px solid #bebebe;
						width: 1rem;
						height: 1rem;
						border-radius: 6px;
					}

					.checked {
						border: 1px solid #bebebe;
						width: 1rem;
						height: 1rem;
						border-radius: 6px;
						background-color: #5e72e4;
					}

					body {
						font-size: x-small;
					}

					.page-break {
						page-break-after: always;
					}

					.form-check {
						display: block;
						padding-left: 2.3em;
						margin-bottom: 0.125rem;
					}

					.form-check-label, .form-check-input[type="checkbox"] {
						cursor: pointer;
					}
					.form-check-input[type="checkbox"] {
						border-radius: 0.25em !important;
					}
					.form-check .form-check-input {
						float: left;
						margin-left: -1.73em;
					}
					.form-check-input {
						width: 1.23em;
						height: 1.23em;
						border-radius: 3px;
						vertical-align: top;
						background-color: #fff;
						background-repeat: no-repeat;
						background-position: center;
						background-size: contain;
						
						appearance: none;
						color-adjust: exact;
					}
					.form-check-label {
						font-size: x-small;
					}
					.form-check-label, .form-check-input[type="checkbox"] {
						cursor: pointer;
					}
				</style>';

		$html .= $content;

		$html .= '</body>
		</html>';
		$_SESSION['content'] = $html;

		$this->status = 200;
		$this->message = 'Berhasil';
		$this->__json_out($data);
	}

	public function printing_xls()
	{
		$data = [];
		$content = $this->input->post('content');
		if (!isset($content)) {
			$this->status = 400;
			$this->message = 'Data tidak ditemukan';
			$this->__json_out($data);
			die();
		}

		$_SESSION['content'] = $content;

		$this->status = 200;
		$this->message = 'Berhasil';
		$this->__json_out($data);
	}

	/**
	 * Give json data set result on datatable format
	 *
	 * @api
	 *
	 * @return void
	 */
	public function list_for_print()
	{
		$d = $this->__init();
		$data = array();
		$this->_api_auth_required($data, 'user');

		$this->status = 200;
		$this->message = API_ADMIN_ERROR_CODES[$this->status];

		/** advanced filter is_active */
		$a_jpenilaian_id = $this->input->request('a_jpenilaian_id', '');
		$a_ruangan_id = $this->input->request('a_ruangan_id', '');
		$b_user_id = $this->input->request('b_user_id', '');
		$b_user_id_penilai = $this->input->request('b_user_id_penilai', '');
		$is_active = $this->input->request('is_active', '');
		$sdate = $this->input->request('sdate', '');
		$bulan = $this->input->request('bulan', '');
		$edate = $this->input->request('edate', '');
		$page = $this->input->request('page', 0);
		$pagesize = $this->input->request('pagesize', 10);
		$sort_column = $this->input->request('sort_column', 'id');
		$sort_direction = $this->input->request('sort_direction', 'desc');
		$keyword = $this->input->request('keyword', '');

		if ($d['sess']->user->profesi == 'IPCN' || $d['sess']->user->profesi == 'Komite Mutu') {
			$b_user_id_penilai = '';
		}
		if (strlen($bulan)) {
			$sdate = $bulan;
			$dates = explode('-', $sdate);
			$edate = date($dates[0] . '-' . $dates[1] . '-t');
		}

		$data['mindate'] = $sdate;
		$data['maxdate'] = $edate;

		$ajm = $this->ajm->id($a_jpenilaian_id);
		if (!isset($ajm->id)) {
			$this->status = 400;
			$this->message = "Data tidak ditemukan";
			$this->__json_out($data);
			die();
		}
		$data['ajm'] = $ajm;

		$aim = $this->aim->getByPenilaianId($ajm->id);
		if (!isset($aim[0]->id)) {
			$this->status = 400;
			$this->message = "Data tidak ditemukan";
			$this->__json_out($data);
			die();
		}
		$data['aim'] = $aim;

		if ($ajm->type_form == 2) {
			$ddata = $this->dvm->print_ppi(
				$page,
				$pagesize,
				$sort_column,
				$sort_direction,
				$b_user_id,
				$b_user_id_penilai,
				$a_jpenilaian_id,
				$a_ruangan_id,
				$sdate,
				$edate,
				$keyword,
				$is_active
			);
			$calculate = $this->dvm->calculate_ppi(
				$page,
				$pagesize,
				$sort_column,
				$sort_direction,
				$b_user_id,
				$b_user_id_penilai,
				$a_jpenilaian_id,
				$a_ruangan_id,
				$sdate,
				$edate,
				$keyword,
				$is_active
			);
		} else {
			$ddata = $this->cam->print(
				$page,
				$pagesize,
				$sort_column,
				$sort_direction,
				$b_user_id,
				$b_user_id_penilai,
				$a_jpenilaian_id,
				$a_ruangan_id,
				$sdate,
				$edate,
				$keyword,
				$is_active
			);
		}

		// dd($calculate);
		if (isset($calculate)) {
			$dcal = [];
			foreach ($calculate as $k => $v) {
				$dcal[$v->ruangan . ' - ' . $v->kategori] = $v;
			}
		}

		foreach ($ddata as &$gd) {
			if (isset($gd->is_active)) {
				$gd->is_active = $this->cam->label('is_active', $gd->is_active);
			}

			if (isset($gd->cdate)) {
				$gd->tgl = (int) date('d', strtotime($gd->cdate));
			}

			if (isset($gd->cdate)) {
				$gd->bulan_tahun = $this->__dateIndonesia($gd->cdate, 'bulan_tahun');
			}


			if (isset($gd->cdate)) {
				$gd->cdate = $this->__dateIndonesia($gd->cdate);
			}


			if (isset($gd->value)) {
				$gd->value = json_decode($gd->value);
			}

			if (isset($gd->durasi)) {
				$durasis = explode('.', $gd->durasi);

				$gd->durasi = '';
				if ((int) $durasis[0]) $gd->durasi .= $durasis[0] . ' jam ';
				if ((int) $durasis[1]) $gd->durasi .= $durasis[1] . ' menit';
			}

			if (isset($dcal)) {
				$gd->aksi_y = $dcal[$gd->ruangan . ' - ' . $gd->indikator_kategori]->y;
				$gd->aksi_n = $dcal[$gd->ruangan . ' - ' . $gd->indikator_kategori]->n;
				$gd->aksi_jumlah = $dcal[$gd->ruangan . ' - ' . $gd->indikator_kategori]->jumlah;
				$gd->aksi_persentase = $gd->aksi_y ? ceil($gd->aksi_y / $gd->aksi_jumlah * 100) : 0;
			}
		}
		unset($aim);
		unset($ajm);
		$data['list'] = $ddata;
		$this->__json_out($data);
	}
}
