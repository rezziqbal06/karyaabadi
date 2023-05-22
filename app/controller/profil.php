<?php
class Profil extends JI_Controller
{
	var $media_pengguna = 'media/pengguna/';

	public function __construct()
	{
		parent::__construct();
		$this->setTheme('front');
		$this->current_parent = 'dashboard';
		$this->current_page = 'dashboard';
		$this->load('a_jabatan_concern');
		$this->load('a_ruangan_concern');
		$this->load('b_user_alamat_concern');
		$this->load('b_user_concern');
		$this->load('c_asesmen_concern');

		// $this->load('front/a_pengguna_model', 'apm');
		// $this->load('front/a_company_model', 'acm');
		$this->load('front/a_jabatan_model', 'ajm');
		$this->load('front/a_ruangan_model', 'arm');
		$this->load('front/b_user_alamat_model', 'buam');
		$this->load('front/b_user_model', 'bum');
		$this->load('front/c_asesmen_model', 'cam');
	}

	public function index()
	{
		$data = $this->__init();

		if (!$this->user_login) {
			redir(base_url('login'));
			die();
		}

		// $acm = $this->acm->getByUserId($data['sess']->user->id);
		// if (isset($acm->id)) $data['acm'] = $acm;
		// unset($acm);

		// $buam = $this->buam->getByUserId($data['sess']->user->id);
		// if (isset($buam->id)) $data['buam'] = $buam;
		// unset($buam);

		$ajm = $this->ajm->get();
		if(isset($ajm)) $data['ajm'] = $ajm;
		unset($ajm);

		$arm = $this->arm->getAll();
		if(isset($arm)) $data['arm'] = $arm;
		unset($arm);

		$user_exist = $this->bum->getUserById($data['sess']->user->id);
		if(isset($user_exist)) $data['ue'] = $user_exist;
		unset($user_exist);
		
		$count_hygiene = $this->cam->getByUserPenilaiId($data['sess']->user->id, 2);
		if (isset($count_hygiene)) $data['count_hygiene'] = $count_hygiene->count;
		$count_apd = $this->cam->getByUserPenilaiId($data['sess']->user->id, 3);
		if (isset($count_apd)) $data['count_apd'] = $count_apd->count;
		$count_monev = $this->cam->getByUserPenilaiId($data['sess']->user->id, 4);
		if (isset($count_monev)) $data['count_monev'] = $count_monev->count;

		

		$this->setTitle('Profil Saya ' . $this->config->semevar->site_suffix);
		$this->putThemeContent("profil/home_modal", $data);
		$this->putThemeContent("profil/home", $data);

		$this->putJsReady("profil/home_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}
	public function edit_foto()
	{
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'));
			die();
		}
		$admin_id = $data['sess']->user->id;

		$data['notif'] = 'Error: Gagal ubah foto profil';
		$foto = $this->__uploadFoto($admin_id); //handling file upload
		if (strlen($foto) > 3) {
			//delete existing foto
			$admin_foto = $data['sess']->user->foto;
			if (strlen($admin_foto) > 3) {
				$admin_foto = str_replace('//', '/', $admin_foto);
				$admin_foto_path = SEMEROOT . DIRECTORY_SEPARATOR . $admin_foto;
				if (file_exists($admin_foto_path)) unlink($admin_foto_path);
			}

			//set to current session
			$data['sess']->user->foto = '';
			$this->setKey($data['sess']);

			//replace double slash
			$foto = str_replace('//', '/', $foto);

			//update new foto to database;
			$du = array('foto' => $foto);
			$res = $this->apm->update($admin_id, $du);
			if ($res) {
				$data['sess']->user->foto = $foto;
				$this->setKey($data['sess']);
				$data['notif'] = 'Berhasil';
			}
		}

		$this->setTitle('Profil Saya ' . $this->config->semevar->site_suffix);
		$this->putThemeContent("profil/home_modal", $data);
		$this->putThemeContent("profil/home", $data);

		$this->putThemeContent("profil/home_modal", $data);
		$this->putThemeContent("profil/home", $data);

		$this->putJsReady("profil/home_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}
}
