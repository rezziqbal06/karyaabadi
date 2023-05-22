<?php
class A_Pengguna_Model extends SENE_Model
{
  public $tbl = 'a_pengguna';
  public $tbl_as = 'ap';
  public $tbl2 = 'a_jabatan';
  public $tbl2_as = 'j';
  public function __construct()
  {
    parent::__construct();
    $this->db->from($this->tbl, $this->tbl_as);
  }
  public function getAll($page=0, $pagesize=10, $sortCol="id", $sortDir="ASC", $keyword="", $sdate="", $edate="")
  {
    $this->db->flushQuery();
    $this->db->select('id')
    ->select('foto')
    ->select('username')
    ->select('email')
    ->select('nama')
    ->select('welcome_message')
    ->select('is_active')
    ;
    $this->db->from($this->tbl, $this->tbl_as);
    if (strlen($keyword)>1) {
      $this->db->where("username", $keyword, "OR", "%like%", 1, 0);
      $this->db->where("email", $keyword, "OR", "%like%", 0, 1);
    }
    $this->db->order_by($sortCol, $sortDir)->limit($page, $pagesize);
    return $this->db->get("object", 0);
  }
  public function countAll($keyword="", $sdate="", $edate="")
  {
    $this->db->flushQuery();
    $this->db->select_as("COUNT(*)", "jumlah", 0);
    if (strlen($keyword)>1) {
      $this->db->where("username", $keyword, "OR", "%like%", 1, 0);
      $this->db->where("email", $keyword, "OR", "%like%", 0, 1);
    }
    $d = $this->db->from($this->tbl)->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }
  public function getById($id)
  {
    $this->db->where("id", $id);
    return $this->db->get_first();
  }
  public function set($di)
  {
    if (!is_array($di)) {
      return 0;
    }
    $this->db->insert($this->tbl, $di, 0, 0);
    return $this->db->last_id;
  }
  public function update($id, $du)
  {
    if (!is_array($du)) {
      return 0;
    }
    $this->db->where("id", $id);
    return $this->db->update($this->tbl, $du, 0);
  }
  public function del($id)
  {
    $this->db->where("id", $id);
    return $this->db->delete($this->tbl);
  }
  public function checkusername($username, $id=0)
  {
    $this->db->select_as("COUNT(*)", "jumlah", 0);
    $this->db->where("username", $username);
    if (!empty($id)) {
      $this->db->where("id", $id, 'AND', '!=');
    }
    $d = $this->db->from($this->tbl)->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }
  public function checkemail($email, $id=0)
  {
    $this->db->select_as("COUNT(*)", "jumlah", 0);
    $this->db->where("email", $email);
    if (!empty($id)) {
      $this->db->where("id", $id, 'AND', '!=');
    }
    $d = $this->db->from($this->tbl)->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }
  public function checknamaperusahaan($np, $id=0)
  {
    $this->db->select_as("COUNT(*)", "jumlah", 0);
    $this->db->where("nama_perusahaan", $np);
    if (!empty($id)) {
      $this->db->where("id", $id, 'AND', '!=');
    }
    $d = $this->db->from($this->tbl)->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }
  public function checkKode($id=0)
  {
    $this->db->select_as("COUNT(*)", "jumlah", 0);
    $this->db->where("id", $id);
    $d = $this->db->from($this->tbl)->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }

  public function getPengguna($page=0, $pagesize=10, $sortCol="id", $sortDir="ASC", $keyword="", $a_company_id="", $edate="")
  {
    $this->db->flushQuery();
    $this->db->select('id')
    ->select('foto')
    ->select('username')
    ->select('email')
    ->select('nama')
    ->select('welcome_message')
    ->select('is_active')
    ;
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->where("is_karyawan", 0);
    if (strlen($keyword)>1) {
      $this->db->where("username", $keyword, "OR", "%like%", 1, 0);
      $this->db->where("email", $keyword, "OR", "%like%", 0, 1);
    }
    $this->db->order_by($sortCol, $sortDir)->limit($page, $pagesize);
    return $this->db->get("object", 0);
  }
  public function countPengguna($keyword="", $a_company_id="", $edate="")
  {
    $this->db->flushQuery();
    $this->db->select_as("COUNT(*)", "jumlah", 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->where("is_karyawan", 0);
    if (strlen($keyword)>1) {
      $this->db->where("username", $keyword, "OR", "%like%", 1, 0);
      $this->db->where("email", $keyword, "OR", "%like%", 0, 1);
    }
    $d = $this->db->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }
  public function getKaryawan($page=0, $pagesize=10, $sortCol="id", $sortDir="ASC", $keyword="", $a_company_id="", $edate="")
  {
    $this->db->flushQuery();
    $this->db->select('id')
    ->select('nip')
    ->select('nama')
    ->select('a_jabatan_nama')
    ->select('a_company_nama')
    ->select('karyawan_status')
    ->select('is_active')
    ;
    $this->db->from($this->tbl, $this->tbl_as);
    if (strlen($a_company_id)) {
      $this->db->where("a_company_id", $a_company_id);
    }
    if (strlen($keyword)>0) {
      $this->db->where("username", $keyword, "OR", "%like%", 1, 0);
      $this->db->where("nama", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("a_jabatan_nama", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("a_company_nama", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("email", $keyword, "OR", "%like%", 0, 1);
    }
    $this->db->order_by($sortCol, $sortDir)->limit($page, $pagesize);
    return $this->db->get("object", 0);
  }
  public function countKaryawan($keyword="", $a_company_id="", $edate="")
  {
    $this->db->flushQuery();
    $this->db->select_as("COUNT(*)", "jumlah", 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->where("is_karyawan", 1);
    if (strlen($a_company_id)) {
      $this->db->where("a_company_id", $a_company_id);
    }
    if (strlen($keyword)>0) {
      $this->db->where("username", $keyword, "OR", "%like%", 1, 0);
      $this->db->where("nama", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("a_jabatan_nama", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("a_company_nama", $keyword, "OR", "%like%", 0, 0);
      $this->db->where("email", $keyword, "OR", "%like%", 0, 1);
    }
    $d = $this->db->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }
  public function getResepDokter($keyword="",$a_company_id=""){
    $this->db->select_as("$this->tbl_as.*, COALESCE($this->tbl2_as.nama,'dokter')",'jabatan',0);
    $this->db->from($this->tbl,$this->tbl_as);
    $this->db->join($this->tbl2,$this->tbl2_as,'id',$this->tbl_as,'a_jabatan_id','left');
    $this->db->where_in("LOWER(COALESCE($this->tbl2_as.nama,'terapis'))",array('dokter'));
    if(strlen($a_company_id)) $this->db->where_as("$this->tbl_as.a_company_id",$a_company_id,'AND','=',0,0);
    if(strlen($keyword)){
      $this->db->where_as("$this->tbl_as.nama",$keyword,'OR','like%%',1,0);
      $this->db->where_as("$this->tbl_as.username",$keyword,'OR','like%%',0,0);
      $this->db->where_as("$this->tbl_as.email",$keyword,'OR','like%%',0,0);
      $this->db->where_as("$this->tbl_as.a_company_nama",$keyword,'OR','like%%',0,1);
    }
    $this->db->order_by("$this->tbl_as.nama",'asc');
    $this->db->order_by("COALESCE($this->tbl2_as.nama,'dokter')",'asc');
    return $this->db->get('',0);
  }
  public function cari($keyword=""){
    $this->db->select_as("$this->tbl_as.id","id",0);
    $this->db->select_as("CONCAT($this->tbl_as.nama,' (',$this->tbl_as.a_company_nama,')')","text",0);
    $this->db->from($this->tbl,$this->tbl_as);
    if(strlen($keyword)>0){
      $this->db->where_as("$this->tbl_as.nama",($keyword),"OR","LIKE%%",1,0);
      $this->db->where_as("$this->tbl_as.username",($keyword),"OR","LIKE%%",0,0);
      $this->db->where_as("$this->tbl_as.email",($keyword),"OR","LIKE%%",0,0);
      $this->db->where_as("$this->tbl_as.alamat",($keyword),"OR","LIKE%%",0,0);
      $this->db->where_as("$this->tbl_as.nip",($keyword),"OR","LIKE%%",0,1);
    }
    $this->db->order_by("$this->tbl_as.nama","asc");
    $this->db->order_by("$this->tbl_as.a_company_nama","asc");
    return $this->db->get('',0);
  }

  public function getTerapisByCompanyId($keyword="",$a_company_id="",$who_first=""){
    $this->db->select_as("$this->tbl_as.*, COALESCE($this->tbl2_as.nama,'terapis')",'jabatan',0);
    $this->db->from($this->tbl,$this->tbl_as);
    $this->db->join($this->tbl2,$this->tbl2_as,'id',$this->tbl_as,'a_jabatan_id','left');
    $this->db->where_in("LOWER(COALESCE($this->tbl2_as.nama,'terapis'))",array('dokter','terapis','perawat'));
    if(strlen($a_company_id)) $this->db->where_as("$this->tbl_as.a_company_id",$a_company_id,'AND','=',0,0);
    if(strlen($keyword)){
      $this->db->where_as("$this->tbl_as.nama",$keyword,'OR','like%%',1,0);
      $this->db->where_as("$this->tbl_as.username",$keyword,'OR','like%%',0,0);
      $this->db->where_as("$this->tbl_as.email",$keyword,'OR','like%%',0,0);
      $this->db->where_as("$this->tbl_as.a_company_nama",$keyword,'OR','like%%',0,1);
    }
    $this->db->order_by("$this->tbl_as.nama",'asc');
    $this->db->order_by("COALESCE($this->tbl2_as.nama,'terapis')",'asc');
    return $this->db->get('',0);
  }

	public function getLastId(){
		$this->db->select_as("COALESCE(MAX($this->tbl_as.id),0)+1", "last_id", 0);
		$this->db->from($this->tbl, $this->tbl_as);
		$d = $this->db->get_first('',0);
		if(isset($d->last_id)) return $d->last_id;
		return 0;
	}
}
