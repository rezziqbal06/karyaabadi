<?php
class Admin extends JI_Controller{
	var $media_pengguna = 'media/pengguna';

	public function __construct(){
    parent::__construct();
		$this->load("api_front/b_user_model",'bum');
		$this->load("api_front/b_user_module_model",'bumm');
	}

	private function __uploadFoto($admin_id){
		//building path target
		$fldr = $this->media_pengguna;
		$folder = SEMEROOT.DIRECTORY_SEPARATOR.$fldr.DIRECTORY_SEPARATOR;
		$folder = str_replace('\\','/',$folder);
		$folder = str_replace('//','/',$folder);
		$ifol = realpath($folder);

		//check folder
		if(!$ifol) mkdir($folder); //create folder
		$ifol = realpath($folder); //get current realpath

		reset($_FILES);
		$temp = current($_FILES);
		if (is_uploaded_file($temp['tmp_name'])){
			if (isset($_SERVER['HTTP_ORIGIN'])) {
				// same-origin requests won't set an origin. If the origin is set, it must be valid.
				header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
			}
			header('Access-Control-Allow-Credentials: true');
			header('P3P: CP="There is no P3P policy."');

			// Sanitize input
			if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
					header("HTTP/1.0 500 Invalid file name.");
					return 0;
			}
			// Verify extension
			$ext = strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION));
			if (!in_array($ext, array("gif", "jpg", "png"))) {
					header("HTTP/1.0 500 Invalid extension.");
					return 0;
			}

			// Create magento style media directory
			$temp['name'] = md5($admin_id).date('is').'.'.$ext;
			$name  = $temp['name'];
			$name1 = date("Y");
			$name2 = date("m");

			//building directory structure
			if(PHP_OS == "WINNT"){
				if(!is_dir($ifol)) mkdir($ifol);
				$ifol = $ifol.DIRECTORY_SEPARATOR.$name1.DIRECTORY_SEPARATOR;
				if(!is_dir($ifol)) mkdir($ifol);
				$ifol = $ifol.DIRECTORY_SEPARATOR.$name2.DIRECTORY_SEPARATOR;
				if(!is_dir($ifol)) mkdir($ifol);
			}else{
				if(!is_dir($ifol)) mkdir($ifol,0775);
				$ifol = $ifol.DIRECTORY_SEPARATOR.$name1.DIRECTORY_SEPARATOR;
				if(!is_dir($ifol)) mkdir($ifol,0775);
				$ifol = $ifol.DIRECTORY_SEPARATOR.$name2.DIRECTORY_SEPARATOR;
				if(!is_dir($ifol)) mkdir($ifol,0775);
			}

			// Accept upload if there was no origin, or if it is an accepted origin

			$filetowrite = $ifol . $temp['name'];

			if(file_exists($filetowrite)) unlink($filetowrite);
			move_uploaded_file($temp['tmp_name'], $filetowrite);
			if(file_exists($filetowrite)){
				$this->lib("wideimage/WideImage",'wideimage',"inc");
				WideImage::load($filetowrite)->resize(320)->saveToFile($filetowrite);
				return $fldr."/".$name1."/".$name2."/".$name;
			}else{
				return 0;
			}
		} else {
			// Notify editor that the upload failed
			//header("HTTP/1.0 500 Server Error");
			return 0;
		}
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
				$sortCol = "fnama";
				break;
			case 2:
				$sortCol = "fnama";
				break;
			case 3:
				$sortCol = "email";
				break;
      case 4:
        $sortCol = "telp";
        break;
      case 5:
        $sortCol = "kelamin";
        break;
      case 6:
        $sortCol = "bdate";
        break;
      case 7:
        $sortCol = "is_active";
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
		$dcount = $this->bum->countAll($keyword,$b_user_id);
		$ddata = $this->bum->getAll($page,$pagesize,$sortCol,$sortDir,$keyword,$b_user_id);

		foreach($ddata as &$gd){
			if(isset($gd->kelamin)){
				if(!empty($gd->kelamin)){
					$gd->kelamin = 'Pria';
				}else{
					$gd->kelamin = 'Wanita';
				}
			}
			if(isset($gd->foto)){
				if(!empty($gd->foto)){
					$gd->foto = '<img src='.base_url($gd->foto).' class="img-responsive" style="max-width: 48px;" />';
				}else{
					$gd->foto = '<img src='.base_url('media/pengguna/default.png').' style="max-width: 48px;" class="img-responsive" />';
				}
			}
			if(isset($gd->is_active)){
				if(!empty($gd->is_active)){
					$gd->is_active = '<span class="label label-success">Aktif</span>';
				}else{
					$gd->is_active = '<span class="label label-danger">Tidak Aktif</span>';
				}
			}
		}
		$this->__jsonDataTable($ddata,$dcount);
	}
	public function baru(){
		$d = $this->__init();
		$data = array();
		if(!$this->user_login){
			$this->status = 400;
			$this->message = 'Harus login';
			header("HTTP/1.0 400 Harus login");
			$this->__json_out($data);
			die();
		}
		$di = $_POST;
		$di['cdate'] = 'NOW()';
		$di['adate'] = 'NULL';
		$di['edate'] = 'NULL';
		$di['tlahir'] = '';
		$di['is_agree'] = '1';
		$di['b_user_id'] = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$di['b_user_id'] = (int) $d['sess']->user->b_user_id;
		}

		if(!isset($di['email'])) $di['email'] = '';
		$di['email'] = trim($di['email']);
		if(strlen($di['email'])<=3){
			$this->status = 601;
			$this->message = 'Email tidak valid';
			$this->__json_out($data);
			die();
		}

		if($this->bum->checkEmail($di['email'])){
			$this->status = 602;
			$this->message = 'Email sudah digunakan';
			$this->__json_out($data);
			die();
		}

		if(!isset($di['password'])) $di['password'] = '';
		$di['password'] = trim($di['password']);
		if(strlen($di['password'])<=5){
			$this->status = 603;
			$this->message = 'Password terlalu pendek';
			$this->__json_out($data);
			die();
		}
		$di['password'] = md5($di['password']);
		$resid = $this->bum->set($di);
		if($resid){
			$this->status = 200;
			$this->message = 'Data baru berhasil ditambahkan';
			$penguna_foto = $this->__uploadFoto($resid);
			if(strlen($penguna_foto)>4){
				$du = array();
				$du['foto'] = $penguna_foto;
				$this->bum->update($resid,$du);
				$this->message .= ', Foto profil berhasil diupload';
			}
		}else{
			$this->status = 900;
			$this->message = 'Tidak dapat menyimpan data baru, silakan coba beberapa saat lagi';
		}
		$this->__json_out($data);
	}

	public function detail($id){
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
		if($id<=0){
			$this->status = 600;
			$this->message = 'ID tidak valid';
			$this->__json_out($data);
			die();
		}

		$this->status = 200;
		$this->message = 'Berhasil';
		$data = $this->bum->getById($id);
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
			$this->status = 600;
			$this->message = 'ID tidak valid';
			$this->__json_out($data);
			die();
		}

		$bum = $this->bum->getById($id);
		if(!isset($bum->id)){
			$this->status = 610;
			$this->message = 'Data dengan ID tersebut tidak ada';
			$this->__json_out($data);
			die();
		}

		$b_user_id = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$b_user_id = (int) $d['sess']->user->b_user_id;
		}
		$bum->b_user_id = (int) $bum->b_user_id;
		if($b_user_id != $bum->b_user_id || empty($b_user_id) || empty($bum->b_user_id)){
			$this->status = 609;
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

		if($this->bum->checkEmail($du['email'],$id)){
			$this->status = 602;
			$this->message = 'Email sudah digunakan';
			$this->__json_out($data);
			die();
		}
		$du['username'] = $du['email'];

		$res = $this->bum->update($id,$du);
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

		$bum = $this->bum->getById($id);
		if(!isset($bum->id)){
			$this->status = 610;
			$this->message = 'Data dengan ID tersebut tidak ada';
			$this->__json_out($data);
			die();
		}

		$b_user_id = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$b_user_id = (int) $d['sess']->user->b_user_id;
		}
		$bum->b_user_id = (int) $bum->b_user_id;
		if($b_user_id != $bum->b_user_id || empty($b_user_id) || empty($bum->b_user_id)){
			$this->status = 609;
			$this->message = 'Tidak dapat edit admin';
			$this->__json_out($data);
			die();
		}

		$this->bumm->delByUserId($id);
		$res = $this->bum->del($id);
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
		$pengguna = $this->bum->getById($id);
		if( $id>0 && isset($pengguna->id) ){
			$penguna_foto = $this->__uploadFoto($pengguna->id);
			if(!empty($penguna_foto)){
				if(strlen($pengguna->foto)>4){
					$foto = SEMEROOT.DIRECTORY_SEPARATOR.$pengguna->foto;
					if(file_exists($foto)) unlink($foto);
				}
				$du = array();
				$du['foto'] = $penguna_foto;
				$res = $this->bum->update($id,$du);
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
		$this->load("api_admin/b_user_model",'bum');
		$d = $this->__init();
		$keyword = $this->input->request('q');
		$ddata = $this->bum->select2($keyword);
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
		$data = $this->bum->cari($keyword);
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

		$bum = $this->bum->getById($id);
		if(!isset($bum->id)){
			$this->status = 610;
			$this->message = 'Data dengan ID tersebut tidak ada';
			$this->__json_out($data);
			die();
		}

		$b_user_id = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$b_user_id = (int) $d['sess']->user->b_user_id;
		}
		$bum->b_user_id = (int) $bum->b_user_id;
		if($b_user_id != $bum->b_user_id || empty($b_user_id) || empty($bum->b_user_id)){
			$this->status = 609;
			$this->message = 'Tidak dapat edit admin';
			$this->__json_out($data);
			die();
		}

		$data = array();
		$bumm = $this->bumm->getByUserId($bum->id);
		foreach ($bumm as $k => $v) {
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

		$bum = $this->bum->getById($id);
		if(!isset($bum->id)){
			$this->status = 610;
			$this->message = 'Data dengan ID tersebut tidak ada';
			$this->__json_out($data);
			die();
		}

		$b_user_id = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$b_user_id = (int) $d['sess']->user->b_user_id;
		}
		$bum->b_user_id = (int) $bum->b_user_id;
		if($b_user_id != $bum->b_user_id || empty($b_user_id) || empty($bum->b_user_id)){
			$this->status = 609;
			$this->message = 'Tidak dapat edit admin';
			$this->__json_out($data);
			die();
		}

		$a_modules_identifier	= $this->input->post('a_modules_identifier');
		$this->bumm->updateByUserId(array('tmp_active' => 'N'), $bum->id);
		foreach ($a_modules_identifier as $ami) {
			$arr							= array();
			$arr['b_user_id']			= $bum->id;
			$arr['a_modules_identifier']	= $ami;
			$arr['rule']					= 'allowed';
			$arr['tmp_active']				= 'Y';
			$check_ami = $this->bumm->checkByUserId($bum->id, $ami);
			if ($check_ami == 0) {
				$this->bumm->set($arr);
			} else {
				$this->bumm->updateByUserId($arr, $bum->id, $ami);
			}
		}

		$res = $this->bumm->delByUserId($bum->id);
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

		$bum = $this->bum->getById($id);
		if(!isset($bum->id)){
			$this->status = 610;
			$this->message = 'Data dengan ID tersebut tidak ada';
			$this->__json_out($data);
			die();
		}

		$b_user_id = (int) $d['sess']->user->id;
		if(!is_null($d['sess']->user->b_user_id)){
			$b_user_id = (int) $d['sess']->user->b_user_id;
		}
		$bum->b_user_id = (int) $bum->b_user_id;
		if($b_user_id != $bum->b_user_id || empty($b_user_id) || empty($bum->b_user_id)){
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
        $res = $this->bum->update($bum->id, $du);
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
