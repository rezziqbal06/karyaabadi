<?php
class Produk extends JI_Controller
{
	var $media_pengguna = 'media/pengguna';

	public function __construct()
	{
		parent::__construct();
		$this->load('b_produk_concern');
		$this->load('b_produk_harga_concern');
		$this->load('b_produk_gambar_concern');
		$this->load("api_admin/b_produk_model", 'bpm');
		$this->load("api_admin/b_produk_harga_model", 'bphm');
		$this->load("api_admin/b_produk_gambar_model", 'bpgm');
		$this->lib("seme_upload", 'se');
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

		$datatable = $this->bpm->datatable()->initialize();
		$dcount = $this->bpm->count($datatable->keyword(), $is_active);
		$ddata = $this->bpm->data(
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
				$gd->is_active = $this->bpm->label('is_active', $gd->is_active);
			}
			if (isset($gd->gambar)) {
				$gd->gambar = '<img src="' . base_url($gd->gambar) . '" class="img-fluid rounded"/>';
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
		if (!$this->bpm->validates()) {
			$this->status = 444;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$validation_message = $this->bpm->validation_message();
			if (strlen($validation_message)) {
				$this->message = $validation_message;
			}
			$this->__json_out($data);
			die();
		}
		$this->bpm->columns['cdate']->value = 'NOW()';
		$spec = $this->input->post('spec');
		$count_spec = $this->input->post('count_spec');
		if (is_array($spec) && count($spec)) {
			$spesifikasi = [];
			foreach ($spec as $k => $v) {
				$spesifikasi[$v] = [];
				if ($count_spec[$k] != 'qty') {
					$spec_detail = $this->input->post('spec_detail_' . $count_spec[$k]);
					foreach ($spec_detail as $k1 => $v1) {
						$spesifikasi[$v][] = $v1;
					}
				} else {
					$spec_detail_from = $this->input->post('spec_detail_from_qty');
					$spec_detail_to = $this->input->post('spec_detail_to_qty');
					$spec_detail_operator = $this->input->post('spec_detail_operator_qty');
					foreach ($spec_detail_from as $k1 => $v1) {
						$qty = $v1 . ' ' . $spec_detail_operator[$k1] . ' ' . $spec_detail_to[$k1];
						$spesifikasi[$v][] = $qty;
					}
				}
			}
			$spesifikasi = json_encode($spesifikasi);
			$this->bpm->columns['spesifikasi']->value = $spesifikasi;
		}
		// dd($spesifikasi);

		$res = $this->bpm->save();
		if ($res) {
			//Upload Gambar
			$is_cover = $this->input->request('is_cover', 1);
			$dig = [];
			for ($i = 1; $i <= 5; $i++) {
				$resUpload = $this->se->upload_file('gambar' . $i, 'produk', $res, $i);
				if ($resUpload->status == 200) {
					if ($is_cover == $i) {
						$this->bpm->update($res, ['gambar' => $resUpload->file]);
					}
					$go = [];
					$go['gambar'] = $resUpload->file;
					$go['b_produk_id'] = $res;
					$go['ke'] = $i;
					$go['is_cover'] = $is_cover == $i ? 1 : 0;
					$dig[] = $go;
				}
			}
			$res_gambar = $this->bpgm->setMass($dig);
			if ($res_gambar) {
				$this->status = 200;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];
			} else {
				$this->status = 110;
				$this->message = API_ADMIN_ERROR_CODES[$this->status];

				$res_hapus = $this->bpm->del($res);
			}

			//Upload Harga
			$value_spec = $this->input->post('value_spec');
			$price_spec = $this->input->post('price_spec');
			if (is_array($price_spec) && count($price_spec)) {
				$dih = [];
				foreach ($price_spec as $kp => $vp) {
					$dih[$kp]['b_produk_id'] = $res;
					$dih[$kp]['harga'] = $vp;
					$dih[$kp]['is_active'] = 1;
					$dih[$kp]['is_deleted'] = 0;

					$arr_value_spec = explode(' --- ', $value_spec[$kp]);
					$dih[$kp]['spesifikasi'] = json_encode($arr_value_spec);

					$qty = $arr_value_spec[(count($arr_value_spec) - 1)];
					$arr_qty = explode(' ', $qty);
					if (count($arr_qty) == 3) {
						$dih[$kp]['dari_qty'] = $arr_qty[0];
						$dih[$kp]['opr'] = $arr_qty[1];
						$dih[$kp]['ke_qty'] = $arr_qty[2];
					} else {
						$dih[$kp]['opr'] = $arr_qty[0];
						$dih[$kp]['ke_qty'] = $arr_qty[1];
					}
				}

				$res_harga = $this->bphm->setMass($dih);
				if ($res_harga) {
					$this->status = 200;
					$this->message = API_ADMIN_ERROR_CODES[$this->status];
				} else {
					$this->status = 110;
					$this->message = API_ADMIN_ERROR_CODES[$this->status];

					$res_hapus = $this->bpm->del($res);
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
		$data = $this->bpm->id($id);
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


		$id = (int)$id;
		$id = isset($du['id']) ? $du['id'] : 0;
		$du = [];
		$du['nama'] = $_POST['nama'];
		$du['deskripsi'] = $_POST['deskripsi'];
		$du['slug'] = $_POST['slug'];

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

		$bpm = $this->bpm->id($id);
		if (!isset($bpm->id)) {
			$this->status = 445;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}

		if (!$this->bpm->validates()) {
			$this->status = 444;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$validation_message = $this->bpm->validation_message();
			if (strlen($validation_message)) {
				$this->message = $validation_message;
			}
			$this->__json_out($data);
			die();
		}
		if ($id > 0) {
			unset($du['id']);
			//Upload Gambar
			$is_cover = $this->input->request('is_cover', 1);
			$dig = [];
			for ($i = 1; $i <= 5; $i++) {
				$gambar = $this->bpgm->getByProdukAndSort($id, $i);
				$resUpload = $this->se->upload_file('gambar' . $i, 'produk', $id, $i);
				// Jika berhasil upload
				if ($resUpload->status == 200) {
					// Jika ada gambar sebelumnya
					if (isset($gambar->id)) {
						$this->bpgm->update($gambar->id, ['gambar' => $resUpload->file, 'is_cover' => $is_cover == $i ? 1 : 0, 'ke' => $i]);
					} else {
						$this->bpgm->set(['b_produk_id' => $id, 'gambar' => $resUpload, 'is_cover' => $is_cover == $i ? 1 : 0, 'ke' => $i]);
					}
					if ($is_cover == $i) {
						$this->bpm->update($id, ['gambar' => $resUpload->file]);
					}
				} else {
					if (isset($gambar->id)) {
						$this->bpgm->update($gambar->id, ['is_cover' => $is_cover == $i ? 1 : 0]);
						if ($is_cover == $i) {
							$this->bpm->update($id, ['gambar' => $gambar->gambar]);
						}
					}
				}
			}

			// $resUpload1 = $this->se->upload_file('gambar1', 'produk', $id, 1);
			// if ($resUpload1->status == 200) {
			// 	$du['gambar'] = $resUpload1->file;
			// }

			$spec = $this->input->post('spec');
			$count_spec = $this->input->post('count_spec');
			if (is_array($spec) && count($spec)) {
				$spesifikasi = [];
				foreach ($spec as $k => $v) {
					$spesifikasi[$v] = [];
					if ($count_spec[$k] != 'qty') {
						$spec_detail = $this->input->post('spec_detail_' . $count_spec[$k]);
						foreach ($spec_detail as $k1 => $v1) {
							$spesifikasi[$v][] = $v1;
						}
					} else {
						$spec_detail_from = $this->input->post('spec_detail_from_qty');
						$spec_detail_to = $this->input->post('spec_detail_to_qty');
						$spec_detail_operator = $this->input->post('spec_detail_operator_qty');
						foreach ($spec_detail_from as $k1 => $v1) {
							$qty = $v1 . ' ' . $spec_detail_operator[$k1] . ' ' . $spec_detail_to[$k1];
							$spesifikasi[$v][] = $qty;
						}
					}
				}
				$spesifikasi = json_encode($spesifikasi);
				$du['spesifikasi'] = $spesifikasi;
			}

			$res = $this->bpm->update($id, $du);
			if ($res) {
				//Upload Harga
				$res_hapus = $this->bphm->delByProduk($id);
				if ($res_hapus) {
					$value_spec = $this->input->post('value_spec');
					$price_spec = $this->input->post('price_spec');
					if (is_array($price_spec) && count($price_spec)) {
						$dih = [];
						foreach ($price_spec as $kp => $vp) {
							$dih[$kp]['b_produk_id'] = $id;
							$dih[$kp]['harga'] = $vp;
							$dih[$kp]['is_active'] = 1;
							$dih[$kp]['is_deleted'] = 0;

							$arr_value_spec = explode(' --- ', $value_spec[$kp]);
							$dih[$kp]['spesifikasi'] = json_encode($arr_value_spec);

							$qty = $arr_value_spec[(count($arr_value_spec) - 1)];
							$arr_qty = explode(' ', $qty);
							if (count($arr_qty) == 3) {
								$dih[$kp]['dari_qty'] = $arr_qty[0];
								$dih[$kp]['opr'] = $arr_qty[1];
								$dih[$kp]['ke_qty'] = $arr_qty[2];
							} else {
								$dih[$kp]['opr'] = $arr_qty[0];
								$dih[$kp]['ke_qty'] = $arr_qty[1];
							}
						}

						$res_harga = $this->bphm->setMass($dih);
						if ($res_harga) {
							$this->status = 200;
							$this->message = API_ADMIN_ERROR_CODES[$this->status];
						} else {
							$this->status = 110;
							$this->message = API_ADMIN_ERROR_CODES[$this->status];

							$res_hapus = $this->bpm->del($res);
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

		$bpm = $this->bpm->id($id);
		if (!isset($bpm->id)) {
			$this->status = 521;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}
		if (!empty($bpm->is_deleted)) {
			$this->status = 522;
			$this->message = API_ADMIN_ERROR_CODES[$this->status];
			$this->__json_out($data);
			die();
		}

		$res = $this->bpm->update($id, array('is_deleted' => 1));
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
		$pengguna = $this->bpm->getById($id);
		if ($id > 0 && isset($pengguna->id)) {
			if (!empty($penguna_foto)) {
				if (strlen($pengguna->foto) > 4) {
					$foto = SEMEROOT . DIRECTORY_SEPARATOR . $pengguna->foto;
					if (file_exists($foto)) unlink($foto);
				}
				$du = array();
				$du['foto'] = $penguna_foto;
				$res = $this->bpm->update($id, $du);
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
		$ddata = $this->bpm->select2($keyword);
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
		$data = $this->bpm->cari($keyword);
		array_unshift($data, $p);
		$this->__json_select2($data);
	}
}
