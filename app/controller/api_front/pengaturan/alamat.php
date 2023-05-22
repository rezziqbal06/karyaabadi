<?php

class Alamat extends JI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->current_parent = 'pengaturan';
    $this->current_page = 'pengaturan_alamat';
    $this->load("api_front/b_user_model", 'bum');
    $this->load("api_front/b_user_alamat_model", 'buam');
  }

  public function index()
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
    $b_user_id = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$b_user_id = (int) $d['sess']->user->b_user_id;
		}

    $draw = $this->input->post("draw");
    $sval = $this->input->post("search");
    $sSearch = $this->input->post("sSearch");
    $sEcho = $this->input->post("sEcho");
    $page = $this->input->post("iDisplayStart");
    $pagesize = $this->input->post("iDisplayLength");

    $iSortCol_0 = $this->input->post("iSortCol_0");
    $sSortDir_0 = $this->input->post("sSortDir_0");

    $a_company_id = $this->input->post("a_company_id");
    if (empty($a_company_id)) {
      $a_company_id = '';
    }
    $sdate = $this->input->post("sdate");
    $edate = $this->input->post("edate");

    $sortCol = "date";
    $sortDir = strtoupper($sSortDir_0);
    if (empty($sortDir)) {
      $sortDir = "DESC";
    }
    if (strtolower($sortDir) != "desc") {
      $sortDir = "ASC";
    }

    switch ($iSortCol_0) {
      case 0:
        $sortCol = "id";
        break;
      case 1:
        $sortCol = "deskripsi";
        break;
      case 2:
        $sortCol = "nama_penerima";
        break;
      case 3:
        $sortCol = "kecamatan";
        break;
      case 4:
        $sortCol = "kabkota";
        break;
      case 5:
        $sortCol = "provinsi";
        break;
      case 6:
        $sortCol = "kodepos";
        break;
      case 7:
        $sortCol = "is_default";
        break;
      default:
        $sortCol = "id";
    }

    if (empty($draw)) {
      $draw = 0;
    }
    if (empty($pagesize)) {
      $pagesize = 10;
    }
    if (empty($page)) {
      $page = 0;
    }
    $keyword = $sSearch;


    $this->status = 200;
    $this->message = 'Berhasil';
    $dcount = $this->buam->countByUserId($keyword, $b_user_id);
    $ddata = $this->buam->getByUserId($page, $pagesize, $sortCol, $sortDir, $keyword, $b_user_id);

    foreach ($ddata as &$gd) {
      if (isset($gd->is_default)) {
        if (!empty($gd->is_default)) {
          $gd->is_default = '<span class="label label-success">Default <i class="fa fa-check-circle"></i></span>';
        } else {
          $gd->is_default = '';
        }
      }
      if (isset($gd->is_active)) {
        if (!empty($gd->is_active)) {
          $gd->is_active = '<span class="label label-success">Aktif</span>';
        } else {
          $gd->is_active = '<span class="label label-default">Tidak Aktif</span>';
        }
      }
    }
    $this->__jsonDataTable($ddata, $dcount);
  }

  public function default($b_user_id, $b_user_alamat_id)
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

    $b_user_id = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$b_user_id = (int) $d['sess']->user->b_user_id;
		}
    if (empty($b_user_id)) {
      $this->status = 505;
      $this->message = 'ID Pelanggan tidak valid';
      $this->__json_out($data);
      die();
    }
    $b_user_alamat_id = (int) $b_user_alamat_id;
    if (empty($b_user_alamat_id)) {
      $this->status = 506;
      $this->message = 'ID Alamat Pelanggan tidak valid';
      $this->__json_out($data);
      die();
    }
    $this->status = 902;
    $this->message = 'ID Alamat tidak valid';
    $alamat = $this->buam->getByIdAndUserId($b_user_alamat_id, $b_user_id);
    if (isset($alamat->id)) {
      $this->status = 200;
      $this->message = 'Berhasil';
      $this->buam->setDefault($b_user_id, $b_user_alamat_id);
      $duu = array(
        'alamat' => $alamat->alamat,
        'kecamatan' => $alamat->kecamatan,
        'kabkota' => $alamat->kabkota,
        'provinsi' => $alamat->provinsi,
        'kodepos' => $alamat->kodepos
      );
      $this->bum->update($b_user_id, $duu);
    }

    $this->__json_out($data);
  }

  public function baru($b_user_id)
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

    $b_user_id = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$b_user_id = (int) $d['sess']->user->b_user_id;
		}
    if (empty($b_user_id)) {
      $this->status = 505;
      $this->message = 'ID Pelanggan tidak valid';
      $this->__json_out($data);
      die();
    }
    $di = array();
    $di['b_user_id'] = $b_user_id;
    $di['nama'] = $this->input->post("nama");
    $di['telp'] = $this->input->post("telp");
    $di['deskripsi'] = $this->input->post("deskripsi");
    $di['alamat'] = $this->input->post("alamat");
    $di['alamat2'] = $this->input->post("alamat2");
    $di['kelurahan'] = $this->input->post("kelurahan");
    $di['kecamatan'] = $this->input->post("kecamatan");
    $di['kabkota'] = $this->input->post("kabkota");
    $di['provinsi'] = $this->input->post("provinsi");
    $di['negara'] = $this->input->post("negara");
    $di['kodepos'] = $this->input->post("kodepos");
    $res = $this->buam->set($di);
    if ($res) {
      $this->status = 200;
      $this->message = 'Berhasil';
    } else {
      $this->status = 900;
      $this->message = 'Tambah alamat pelanggan gagal';
    }

    $this->__json_out($data);
  }

  public function edit($id)
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

    $b_user_id = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$b_user_id = (int) $d['sess']->user->b_user_id;
		}
    if (empty($b_user_id)) {
      $this->status = 505;
      $this->message = 'ID user tidak valid';
      $this->__json_out($data);
      die();
    }

    $id = (int) $id;
    if (empty($id)) {
      $this->status = 505;
      $this->message = 'ID Alamat tidak valid';
      $this->__json_out($data);
      die();
    }

    $alamat = $this->buam->getByIdAndUserId($id, $b_user_id);
    if (!isset($alamat->id)) {
      $this->status = 506;
      $this->message = 'ID alamat tidak ditemukan';
      $this->__json_out($data);
      die();
    }

    $du = array();
    $du['b_user_id'] = $b_user_id;
    $du['deskripsi'] = $this->input->post("deskripsi");
    $du['alamat'] = $this->input->post("alamat");
    $du['alamat2'] = $this->input->post("alamat2");
    $du['telp'] = $this->input->post("telp");
    $du['negara'] = $this->input->post("negara");
    $du['kelurahan'] = $this->input->post("kelurahan");
    $du['kecamatan'] = $this->input->post("kecamatan");
    $du['kabkota'] = $this->input->post("kabkota");
    $du['provinsi'] = $this->input->post("provinsi");
    $du['kodepos'] = $this->input->post("kodepos");
    foreach ($du as &$d) {
      if (empty($d)) {
        $d = '';
      }
    }
    $res = $this->buam->updateByUserId($b_user_id, $id, $du);
    if ($res) {
      $this->status = 200;
      $this->message = 'Berhasil';
    } else {
      $this->status = 900;
      $this->message = 'Edit alamat gagal';
    }
    $this->__json_out($data);
  }

  public function hapus($b_user_id, $b_user_alamat_id)
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

    $b_user_id = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$b_user_id = (int) $d['sess']->user->b_user_id;
		}
    if (empty($b_user_id)) {
      $this->status = 505;
      $this->message = 'ID Pelanggan tidak valid';
      $this->__json_out($data);
      die();
    }
    $b_user_alamat_id = (int) $b_user_alamat_id;
    if (empty($b_user_alamat_id)) {
      $this->status = 505;
      $this->message = 'ID Alamat tidak valid';
      $this->__json_out($data);
      die();
    }
    $alamat = $this->buam->getByIdAndUserId($b_user_alamat_id, $b_user_id);
    if (!isset($alamat->id)) {
      $this->status = 506;
      $this->message = 'ID alamat tidak ditemukan';
      $this->__json_out($data);
      die();
    }
    $this->status = 200;
    $this->message = 'Berhasil';
    $res = $this->buam->deleteByIdAndUserId($b_user_alamat_id, $b_user_id);
    if (empty($res)) {
      $this->status = 900;
      $this->message = 'Hapus alamat pelanggan gagal';
    }
    $this->__json_out($data);
  }

  public function detail($b_user_id, $b_user_alamat_id)
  {
    $d = $this->__init();
    $data = new stdClass();
    if (!$this->user_login) {
      $this->status = 400;
      $this->message = 'Harus login';
      header("HTTP/1.0 400 Harus login");
      $this->__json_out($data);
      die();
    }

    $b_user_id = (int) $d['sess']->user->id;
    if (empty($b_user_id)) {
      $this->status = 505;
      $this->message = 'ID Pelanggan tidak valid';
      $this->__json_out($data);
      die();
    }
    $b_user_alamat_id = (int) $b_user_alamat_id;
    if (empty($b_user_alamat_id)) {
      $this->status = 505;
      $this->message = 'ID Alamat tidak valid';
      $this->__json_out($data);
      die();
    }
    $alamat = $this->buam->getByIdAndUserId($b_user_alamat_id, $b_user_id);
    if (!isset($alamat->id)) {
      $this->status = 506;
      $this->message = 'ID alamat tidak ditemukan';
      $this->__json_out($data);
      die();
    }
    $this->status = 200;
    $this->message = 'Berhasil';
    $data = $alamat;
    $this->__json_out($data);
  }
}
