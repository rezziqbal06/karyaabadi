<?php
class Saldo extends JI_Controller{
  public $kode_pattern = '%04d';
  public $nomunik_mtd = 0;

	public function __construct(){
    parent::__construct();
		$this->load("api_front/c_topup_model",'ctpm');
	}

	public function index(){
		$d = $this->__init();
		$data = array();
		if(!$this->user_login){
			$this->status = 400;
			$this->message = 'Harus login';
			header("HTTP/1.0 400 Harus login");
			$this->__json_out($data);
			die();
		}
		$b_user_id = (int) $d['sess']->user->id;

		$draw = $this->input->post("draw");
		$sval = $this->input->post("search");
		$sSearch = $this->input->post("sSearch");
		$sEcho = $this->input->post("sEcho");
		$page = $this->input->post("iDisplayStart");
		$pagesize = $this->input->post("iDisplayLength");

		$iSortCol_0 = $this->input->post("iSortCol_0");
		$sSortDir_0 = $this->input->post("sSortDir_0");


		$sortCol = "date";
		$sortDir = strtoupper($sSortDir_0);
		if(empty($sortDir)) $sortDir = "DESC";
		if(strtolower($sortDir) != "desc"){
			$sortDir = "ASC";
		}

		switch($iSortCol_0){
			case 0:
				$sortCol = "id";
				break;
			case 1:
				$sortCol = "kode";
				break;
			case 2:
				$sortCol = "cdate";
				break;
			case 3:
				$sortCol = "nominal";
				break;
      case 4:
        $sortCol = "trf_nominal";
        break;
      case 5:
        $sortCol = "is_active, is_expired ASC, is_paid ";
        break;
			default:
				$sortCol = "id";
		}

		if(empty($draw)) $draw = 0;
		if(empty($pagesize)) $pagesize=10;
		if(empty($page)) $page=0;

		$keyword = $sSearch;

		$this->status = 200;
		$this->message = 'Berhasil';
		$dcount = $this->ctpm->countAll($keyword,$b_user_id);
		$ddata = $this->ctpm->getAll($page,$pagesize,$sortCol,$sortDir,$keyword,$b_user_id);

		foreach($ddata as &$gd){
			if(isset($gd->foto)){
				if(!empty($gd->foto)){
					$gd->foto = '<img src='.base_url($gd->foto).' class="img-responsive" style="max-width: 48px;" />';
				}else{
					$gd->foto = '<img src='.base_url('media/pengguna/default.png').' style="max-width: 48px;" class="img-responsive" />';
				}
			}
			if(isset($gd->is_active)){
        if(isset($gd->is_paid,$gd->is_expired)){
  				if(!empty($gd->is_paid) && empty($gd->is_expired)){
  					$gd->is_active = '<span class="label label-success">Dibayar</span>';
  				}elseif(empty($gd->is_paid) && !empty($gd->is_expired)){
  					$gd->is_active = '<span class="label label-default">Expired</span>';
          }elseif(empty($gd->is_paid) && empty($gd->is_expired)){
  					$gd->is_active = '<span class="label label-danger">Belum Dibayar</span>';
          }else{
  					$gd->is_active = '<span class="label label-danger">Belum Dibayar</span>';
          }
  			}
			}
		}
		$this->__jsonDataTable($ddata,$dcount);
	}
	public function topup(){
		$d = $this->__init();
		$data = array();
		if(!$this->user_login){
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

    if($this->ctpm->check($b_user_id)){
			$this->status = 620;
			$this->message = 'Masih ada tagihan yang belum dibayar, silakan bayar dulu';
			$this->__json_out($data);
			die();
    }

		$di = $_POST;
		if(!isset($di['nominal'])) $di['nominal'] = 0;
		$di['nominal'] = (int) $di['nominal'];
		if($di['nominal'] < 10000){
			$this->status = 621;
			$this->message = 'Nominal topup terlalu sedikit';
			$this->__json_out($data);
			die();
		}
		if($di['nominal'] > 2500000){
			$this->status = 622;
			$this->message = 'Nominal topup terlalu banyak';
			$this->__json_out($data);
			die();
		}

    $di['nomunik'] = mt_rand(1,1999);
    if($this->nomunik_mtd){
      $di['trf_nominal'] = $di['nominal'] + $di['nomunik'];
    }else{
      $di['trf_nominal'] = $di['nominal'] - $di['nomunik'];
    }

		$kode_last = 1;
    $ctpm =	$this->ctpm->getLastKode($b_user_id);
		if (isset($ctpm->urutan)) $kode_last = (int) $ctpm->urutan;
		unset($ctpm);
    $di['kode'] = date("ymd").sprintf($this->kode_pattern, $kode_last);
    unset($kode_last);

    $di['b_user_id'] = $b_user_id;
    $di['cdate'] = 'NOW()';
    $di['is_paid'] = 0;
    $di['is_expired'] = 0;
		$di['is_active'] = 1;
		$resid = $this->ctpm->set($di);
		if($resid){
			$this->status = 200;
			$this->message = 'Data baru berhasil ditambahkan';
		}else{
			$this->status = 900;
			$this->message = 'Tidak dapat menyimpan data baru, silakan coba beberapa saat lagi';
		}
		$this->__json_out($data);
	}

	public function detail($id){
		$d = $this->__init();
		$data = new stdClass();
		if(!$this->user_login){
			$this->status = 400;
			$this->message = 'Harus login';
			header("HTTP/1.0 400 Harus login");
			$this->__json_out($data);
			die();
		}

		$id = (int) $id;
		if($id<=0){
			$this->status = 623;
			$this->message = 'ID tidak valid';
			$this->__json_out($data);
			die();
		}


		$data = $this->ctpm->getById($id);
    if($data->b_user_id == $d['sess']->user->id || $data->b_user_id == $d['sess']->user->b_user_id){
      $this->status = 200;
  		$this->message = 'Berhasil';
      if(isset($data->nominal)){
        $data->nominal = 'Rp '.number_format($data->nominal,0,',','.');
      }
      if(isset($data->trf_nominal)){
        $data->trf_nominal = 'Rp '.number_format($data->trf_nominal,0,',','.');
      }
      if(isset($data->cdate)){
        $edate = new DateTime($data->cdate);
        $edate->modify('+1 day');
        $data->edate = $this->__dateIndonesia($edate->format('Y-m-d H:i'),'hari_tanggal_jam');
        unset($edate);
      }else{
        $data->edate = date('Y-m-d H:i',strtotime('+2 hour'));
      }
      if(isset($data->trf_dt)){
        $data->trf_dt = $this->__dateIndonesia($data->trf_dt,'hari_tanggal_jam');
      }else{
        $data->trf_dt = '-';
      }

      $data->status = 'pending';
      $data->status_teks = 'Pending';
      $data->status_label = '<span class="label label-warning">Pending</span>';
      if(isset($data->is_active,$data->is_paid,$data->is_expired)){
				if(!empty($data->is_paid) && empty($data->is_expired)){
          $data->status = 'dibayar';
          $data->status_teks = 'Dibayar';
					$data->status_label = '<span class="label label-success">Dibayar</span>';
				}elseif(empty($data->is_paid) && !empty($data->is_expired)){
          $data->status = 'expired';
          $data->status_teks = 'Expired';
					$data->status_label = '<span class="label label-default">Expired</span>';
        }elseif(empty($data->is_paid) && empty($data->is_expired)){
          $data->status = 'belum-dibayar';
          $data->status_teks = 'Belum Dibayar';
					$data->status_label = '<span class="label label-danger">Belum Dibayar</span>';
        }else{
          $data->status = 'belum-dibayar';
          $data->status_teks = 'Belum Dibayar';
					$data->status_label = '<span class="label label-warning">Pending</span>';
        }
			}
    }else{
      $this->status = 624;
  		$this->message = 'Data topup tidak ada';
      $data = new stdClass();
    }
		$this->__json_out($data);
	}

	public function edit(){
		$d = $this->__init();
		$data = array();
		if(!$this->user_login){
			$this->status = 400;
			$this->message = 'Harus login';
			header("HTTP/1.0 400 Harus login");
			$this->__json_out($data);
			die();
		}

		$du = $_POST;
		if(!isset($du['id'])) $du['id'] = 0;
		$id = (int) $du['id'];
		if($id<=0){
			$this->status = 624;
			$this->message = 'ID tidak valid';
			$this->__json_out($data);
			die();
		}

		$ctpm = $this->ctpm->getById($id);
		if(!isset($ctpm->id)){
			$this->status = 625;
			$this->message = 'Data dengan ID tersebut tidak ada';
			$this->__json_out($data);
			die();
		}

		$b_user_id = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$b_user_id = (int) $d['sess']->user->b_user_id;
		}
		$ctpm->b_user_id = (int) $ctpm->b_user_id;
		if($b_user_id != $ctpm->b_user_id || empty($b_user_id) || empty($ctpm->b_user_id)){
			$this->status = 626;
			$this->message = 'Tidak dapat edit admin';
			$this->__json_out($data);
			die();
		}

		if(!isset($du['email'])) $du['email'] = '';
		$du['email'] = trim($du['email']);
		if(strlen($du['email'])<=3){
			$this->status = 601;
			$this->message = 'Email tidak valid';
			$this->__json_out($data);
			die();
		}

		if($this->ctpm->checkEmail($du['email'],$id)){
			$this->status = 602;
			$this->message = 'Email sudah digunakan';
			$this->__json_out($data);
			die();
		}
		$du['username'] = $du['email'];

		$res = $this->ctpm->update($id,$du);
		if($res){
			$this->status = 200;
			$this->message = 'Perubahan berhasil diterapkan';
		}else{
			$this->status = 901;
			$this->message = 'Tidak dapat melakukan perubahan ke basis data';
		}

		$this->__json_out($data);
	}

	public function hapus($id){
		$d = $this->__init();
		$data = array();
		if(!$this->user_login && empty($id)){
			$this->status = 400;
			$this->message = 'Harus login';
			header("HTTP/1.0 400 Harus login");
			$this->__json_out($data);
			die();
		}

		$id = (int) $id;
		if($id<=0){
			$this->status = 600;
			$this->message = 'ID tidak valid';
			$this->__json_out($data);
			die();
		}

		$ctpm = $this->ctpm->getById($id);
		if(!isset($ctpm->id)){
			$this->status = 610;
			$this->message = 'Data dengan ID tersebut tidak ada';
			$this->__json_out($data);
			die();
		}

		$b_user_id = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$b_user_id = (int) $d['sess']->user->b_user_id;
		}
		$ctpm->b_user_id = (int) $ctpm->b_user_id;
		if($b_user_id != $ctpm->b_user_id || empty($b_user_id) || empty($ctpm->b_user_id)){
			$this->status = 609;
			$this->message = 'Tidak dapat edit admin';
			$this->__json_out($data);
			die();
		}

		$this->ctpmm->delByUserId($id);
		$res = $this->ctpm->del($id);
		if($res){
			$this->status = 200;
			$this->message = 'Berhasil';
		}else{
			$this->status = 902;
			$this->message = 'Data gagal dihapus';
		}
		$this->__json_out($data);
	}
	public function edit_foto($id){
		$d = $this->__init();
		$data = array();
		if(!$this->user_login){
			$this->status = 400;
			$this->message = 'Harus login';
			header("HTTP/1.0 400 Harus login");
			$this->__json_out($data);
			die();
		}
		$id = (int) $id;
		$du = $_POST;
		if(!isset($du['id'])) $du['id'] = 0;
		if(empty($id)){
			$id = (int) $du['id'];
			unset($du['id']);
		}
		$pengguna = $this->ctpm->getById($id);
		if( $id>0 && isset($pengguna->id) ){
			$penguna_foto = $this->__uploadFoto($pengguna->id);
			if(!empty($penguna_foto)){
				if(strlen($pengguna->foto)>4){
					$foto = SEMEROOT.DIRECTORY_SEPARATOR.$pengguna->foto;
					if(file_exists($foto)) unlink($foto);
				}
				$du = array();
				$du['foto'] = $penguna_foto;
				$res = $this->ctpm->update($id,$du);
				if($res){
					$this->status = 200;
					$this->message = 'Upload foto berhasil';
				}else{
					$this->status = 901;
					$this->message = 'Upload foto gagal';
				}
			}else{
				$this->status = 459;
				$this->message = 'Tidak ada file gambar yang terupload';
			}
		}else{
			$this->status = 550;
			$this->message = 'Dont hack this :P';
		}
		$this->__json_out($data);
	}

	//Temporary Select2 di Pengguna API
	public function select2()
	{
		$this->load("api_admin/b_user_model",'ctpm');
		$d = $this->__init();
		$keyword = $this->input->request('q');
		$ddata = $this->ctpm->select2($keyword);
		$datares = array();
		$i = 0;
		foreach ($ddata as $key => $value) {
			$datares["results"][$i++] = array("id"=>$value->id,"text"=>$value->kode." - ".$value->fnama);
		}
		header('Content-Type: application/json');
		echo json_encode($datares);
	}

	public function cari(){
		$keyword = $this->input->request("keyword");
		if(empty($keyword)) $keyword='';
		$p = new stdClass();
		$p->id = 'NULL';
		$p->text = '-';
		$data = $this->ctpm->cari($keyword);
		array_unshift($data, $p);
		$this->__json_select2($data);
	}

	public function hakakses($id) {
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
		if($id<=0){
			$this->status = 600;
			$this->message = 'ID tidak valid';
			$this->__json_out($data);
			die();
		}

		$ctpm = $this->ctpm->getById($id);
		if(!isset($ctpm->id)){
			$this->status = 610;
			$this->message = 'Data dengan ID tersebut tidak ada';
			$this->__json_out($data);
			die();
		}

		$b_user_id = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$b_user_id = (int) $d['sess']->user->b_user_id;
		}
		$ctpm->b_user_id = (int) $ctpm->b_user_id;
		if($b_user_id != $ctpm->b_user_id || empty($b_user_id) || empty($ctpm->b_user_id)){
			$this->status = 609;
			$this->message = 'Tidak dapat edit admin';
			$this->__json_out($data);
			die();
		}

		$data = array();
		$ctpmm = $this->ctpmm->getByUserId($ctpm->id);
		foreach ($ctpmm as $k => $v) {
			$data[] = $v->a_modules_identifier;
		}
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function hakakses_set($id) {
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
		if($id<=0){
			$this->status = 600;
			$this->message = 'ID tidak valid';
			$this->__json_out($data);
			die();
		}

		$ctpm = $this->ctpm->getById($id);
		if(!isset($ctpm->id)){
			$this->status = 610;
			$this->message = 'Data dengan ID tersebut tidak ada';
			$this->__json_out($data);
			die();
		}

		$b_user_id = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$b_user_id = (int) $d['sess']->user->b_user_id;
		}
		$ctpm->b_user_id = (int) $ctpm->b_user_id;
		if($b_user_id != $ctpm->b_user_id || empty($b_user_id) || empty($ctpm->b_user_id)){
			$this->status = 609;
			$this->message = 'Tidak dapat edit admin';
			$this->__json_out($data);
			die();
		}

		$a_modules_identifier	= $this->input->post('a_modules_identifier');
		$this->ctpmm->updateByUserId(array('tmp_active' => 'N'), $ctpm->id);
		foreach ($a_modules_identifier as $ami) {
			$arr							= array();
			$arr['b_user_id']			= $ctpm->id;
			$arr['a_modules_identifier']	= $ami;
			$arr['rule']					= 'allowed';
			$arr['tmp_active']				= 'Y';
			$check_ami = $this->ctpmm->checkByUserId($ctpm->id, $ami);
			if ($check_ami == 0) {
				$this->ctpmm->set($arr);
			} else {
				$this->ctpmm->updateByUserId($arr, $ctpm->id, $ami);
			}
		}

		$res = $this->ctpmm->delByUserId($ctpm->id);
		if ($res) {
			$this->status 	= 200;
			$this->message 	= 'Berhasil disimpan';
		} else {
			$this->status 	= 901;
			$this->message 	= 'Terjadi kesalahan dalam proses';
		}

		$this->__json_out($data);
	}

  public function password($id="")
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
		if($id<=0){
			$this->status = 600;
			$this->message = 'ID tidak valid';
			$this->__json_out($data);
			die();
		}

		$ctpm = $this->ctpm->getById($id);
		if(!isset($ctpm->id)){
			$this->status = 610;
			$this->message = 'Data dengan ID tersebut tidak ada';
			$this->__json_out($data);
			die();
		}

		$b_user_id = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$b_user_id = (int) $d['sess']->user->b_user_id;
		}
		$ctpm->b_user_id = (int) $ctpm->b_user_id;
		if($b_user_id != $ctpm->b_user_id || empty($b_user_id) || empty($ctpm->b_user_id)){
			$this->status = 609;
			$this->message = 'Tidak dapat edit admin';
			$this->__json_out($data);
			die();
		}

    $password = $this->input->post("password");
    $repassword = $this->input->post("repassword");
    if ($id>0 && strlen($password)>4 && ($password == $repassword)) {
      if (strlen($password)) {
        $du = array();
        $du['password'] = md5($password);
        $res = $this->ctpm->update($ctpm->id, $du);
        $this->status = 200;
        $this->message = 'Perubahan berhasil diterapkan';
      } else {
        $this->status = 901;
        $this->message = 'Password terlalu pendek';
      }
    } else {
      $this->status = 447;
      $this->message = 'ID atau Password Pengguna tidak valid';
    }
    $this->__json_out($data);
  }
}
