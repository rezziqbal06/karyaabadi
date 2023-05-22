<?php

class Register extends JI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->setTheme('front');
		$this->load("a_company_concern");
		$this->load("api_front/a_company_model", 'acm');
		$this->load("b_user_concern");
		$this->load("api_front/a_modules_model", "amod");
		$this->load("api_front/b_user_model", "bum");
        $this->load("api_front/b_user_module_model", "bumod");
		$this->load("b_user_alamat_concern");
		$this->load("api_front/b_user_alamat_model", "buam");
		$this->status = 200;
		$this->message = 'Berhasil';
	}

	private function __passGen($password)
	{
		$password = preg_replace('/[^a-zA-Z0-9]/', '', $password);;
		return password_hash($password, PASSWORD_DEFAULT);
	}
	private function __passClear($password)
	{
		return preg_replace('/[^a-zA-Z0-9]/', '', $password);
	}

    private function cekStringLength($params, $key, $length=0)
    {
        if (!isset($params[$key])) {
			$this->status = 103;
			$this->message = 'Parameter tidak valid: '.$key;
            return false;
        }

        if ($length > mb_strlen($params[$key])) {
			$this->status = 104;
			$this->message = 'Isi '.$key.' terlalu pendek';
            return false;
        }
    }

    private function params($key_params, $autofill=true)
    {
        $params = [];
        foreach($_POST as $k=>$v) {
            if (in_array($k, $key_params)) {
                $params[$k] = $v;
            }
        }

        if ($autofill) {
            foreach($key_params as $k) {
                if (!isset($params[$k])) {
                    $params[$k] = '';
                }
            }
        }


        return $params;
    }

    private function b_user_params()
    {
        $key_params = ['fnama', 'telp', 'email', 'password', 'alamat', 'alamat2', 'foto', 'welcome_message'];

        return $this->params($key_params);
    }

    private function b_user_validate()
    {
        $params = $this->b_user_params();

        $this->cekStringLength($params, 'email', 3);
        $this->cekStringLength($params, 'password', 5);
        $params['username'] = $params['email'];
        $params['cdate'] = 'NOW()';
        $params['password'] = md5($params['password']);

        return $params;
    }

    private function b_user_alamat_params()
    {
        $key_params = ['alamat', 'alamat2', 'telp', 'kelurahan', 'kecamatan', 'kabkota', 'provinsi', 'kodepos', 'negara', 'kode_origin', 'kode_destination'];

        return $this->params($key_params);
    }

    private function b_user_alamat_validate()
    {
        $params = $this->b_user_alamat_params();

        $this->cekStringLength($params, 'alamat', 3);

        return $params;
    }

	public function __defMod($b_user_id){
		$amod = $this->amod->get();
		$dm = array();
		if(is_array($amod) && count($amod)){
			foreach($amod as $a){
				$dm[] = array(
					'b_user_id'=> $b_user_id,
					'a_modules_identifier'=> $a->identifier,
					'rule'=> 'allowed',
					'tmp_active'=> 'N'
				);
			}
		}
		return $dm;
	}

	public function index()
	{
		$data = $this->__init();
		if ($this->user_login) {
			redir(base_url(), 0);
			return;
		}

		$data['reff'] = '';
		if (isset($_SERVER['HTTP_REFERER'])) {
			$allowed_host = ($_SERVER['HTTP_HOST']);
			$host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
			if (substr($host, 0 - strlen($allowed_host)) == $allowed_host) {
				$data['reff'] = str_replace("/logout", " ", $_SERVER['HTTP_REFERER']);
			}
		}

		$this->setTitle('Form Pendaftaran ' . $this->current_reseller->site_title);
		$this->setDescription('Form pendaftaran member '.$this->current_reseller->nama);

		$this->putJsFooter($this->cdn_url('skin/admin/') . 'js/pages/login');
        $this->putThemeContent("register/home_modal", $data);
		$this->putThemeContent("register/home", $data);
		$this->putJsReady('register/home_bottom', $data);
		$this->loadLayout('login', $data);
		$this->render();
	}
	public function proses()
	{
		$dt = new stdClass();
		$data = $this->__init();
		$this->status = 200;
		$this->message = 'Sukses';
		$data['redirect_url'] = base_url('login#register');

		if (!isset($this->current_reseller->id)) {
			$this->status = 103;
			$this->message = 'Pendaftaran member saat ini tidak tersedia';
            $this->index();
			return;
		}

        $di = $this->b_user_validate();
        if ($this->status != 200) {
            $this->index();
			return;
        }

		$di['a_company_id'] = $this->current_reseller->id;

        if ($this->bum->checkemail($di['email'])) {
			$this->status = 105;
			$this->message = 'Email telah dipakai';
			$this->index();
			return;
		}

        $this->bum->trans_start();
		$b_user_id = $this->bum->set($di);
		if ($b_user_id) {
			$bum = $this->bum->id($b_user_id);

            $dia = $this->b_user_alamat_validate();
            $dia['b_user_id'] = $b_user_id;
            $this->buam->set($dia);

			// $this->bumod->setMass($this->__defMod($bum));

			$sess = $this->getKey();
			if (isset($d['sess'])) $sess  = $d['sess'];
			if (!is_object($sess)) $sess = new stdClass();
			if (!isset($sess->user)) $sess->user = new stdClass();
			$sess->user = $bum;
			$sess->user->utype = 'Member';

			$acm = $this->acm->id($bum->a_company_id);
			$sess->user->reseller = new stdClass();
			if (isset($acm->b_user_id_owner)) {
				$sess->user->reseller = $acm;
				if ($sess->user->id == $acm->b_user_id_owner) {
					$sess->user->utype = 'Reseller';
				}
				$this->setResellerIdSession($acm->id);
			}
			if (!isset($sess->user->reseller->nama)) {
				$sess->user->reseller->nama = '';
			}

			$sess->user->menus = new stdClass();
			$sess->user->menus->left = array();
			$sess->user->modules = array();

			//get modules
			$modules = $this->amod->getAllParent('front');
			foreach ($modules as &$module) {
				$childs = $this->amod->getChild($module->identifier, 'front');
				$mos = array();
				if (count($childs) > 0) {
					$sess->user->modules[] = $module;
					foreach ($sess->user->modules as $m) {
						foreach ($childs as $cs) {
							$sess->user->modules[] = $module;
						}
					}
				}
				$module->childs = $mos;
			}
			unset($module);

			//set module to session
			$allowed_all = 1;
			foreach ($modules as $mo) {
				$sess->user->menus->left[$mo->identifier] = $mo;
			}
			unset($mo);
            $this->bum->trans_commit();
            $this->bum->trans_end();

			$this->setKey($sess);
			redir(base_url(''));
			return;
		}else{
            $this->bum->trans_rollback();
            $this->bum->trans_end();

			$this->status = 900;
			$this->message = 'Pendaftaran Gagal';
			$this->index();
			return;
		}
	}

	public function api()
	{
		$dt = new stdClass();
		$data = $this->__init();
		$this->status = 200;
		$this->message = 'Sukses';
		$data['redirect_url'] = base_url('register');

        if (!isset($this->current_reseller->id)) {
			$this->status = 101;
			$this->message = 'Pendaftaran member saat ini tidak tersedia';
			$this->__json_out($data);
			die();
		}

        $di = $this->b_user_validate();
        if ($this->status != 200) {
            $this->__json_out($data);
			die();
        }
		$di['a_company_id'] = $this->current_reseller->id;

        if ($this->bum->checkemail($di['email'])) {
			$this->status = 102;
			$this->message = 'Email telah dipakai';
            $this->__json_out($data);
			die();
		}

        $this->bum->trans_start();
        $b_user_id = $this->bum->set($di);
		if ($b_user_id) {
			$this->status = 200;
			$this->message = 'Berhasil';

			$bum = $this->bum->id($b_user_id);

            $dia = $this->b_user_alamat_validate();
            $dia['b_user_id'] = $b_user_id;
            $this->buam->set($dia);

			// $this->bumod->setMass($this->__defMod($bum));

			$sess = $this->getKey();
			if (isset($d['sess'])) $sess  = $d['sess'];
			if (!is_object($sess)) $sess = new stdClass();
			if (!isset($sess->user)) $sess->user = new stdClass();
			$sess->user = $bum;
			$sess->user->utype = 'Member';

			$acm = $this->acm->id($bum->a_company_id);
			$sess->user->reseller = new stdClass();
			if (isset($acm->b_user_id_owner)) {
				$sess->user->reseller = $acm;
				if ($sess->user->id == $acm->b_user_id_owner) {
					$sess->user->utype = 'Reseller';
				}
				$this->setResellerIdSession($acm->id);
			}
			if (!isset($sess->user->reseller->nama)) {
				$sess->user->reseller->nama = '';
			}

			$sess->user->menus = new stdClass();
			$sess->user->menus->left = array();
			$sess->user->modules = array();

			//get modules
			$modules = $this->amod->getAllParent('front');
			foreach ($modules as &$module) {
				$childs = $this->amod->getChild($module->identifier, 'front');
				$mos = array();
				if (count($childs) > 0) {
					$sess->user->modules[] = $module;
					foreach ($sess->user->modules as $m) {
						foreach ($childs as $cs) {
							$sess->user->modules[] = $module;
						}
					}
				}
				$module->childs = $mos;
			}
			unset($module);

			//set module to session
			$allowed_all = 1;
			foreach ($modules as $mo) {
				$sess->user->menus->left[$mo->identifier] = $mo;
			}
			unset($mo);
			$data['redirect_url'] = $this->current_base_url();
            $this->bum->trans_commit();

			$this->setKey($sess);
		}else{
            $this->bum->trans_rollback();
			$this->status = 900;
			$this->message = 'Pendaftaran Gagal';
		}
        $this->bum->trans_end();

        $this->__json_out($data);
	}
}
