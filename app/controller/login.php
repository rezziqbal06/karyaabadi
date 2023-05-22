<?php

use PhpOffice\PhpSpreadsheet\Reader\Xls\MD5;

class Login extends \JI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->setTheme('front');
		$this->load("b_user_concern");
		$this->load("front/b_user_model", "bum");
		$this->load("api_front/b_user_module_model", "bumod");
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

		$this->setTitle('Login ' . $this->config->semevar->site_title);
		$this->setDescription('Silakan login untuk masuk ke dashboard ');

		$this->putJsFooter($this->cdn_url('skin/admin/') . 'js/pages/login');
		$this->putThemeContent("login/home", $data);
		$this->putJsContent('login/home_bottom', $data);
		$this->loadLayout('login', $data);
		$this->render();
	}
	public function proses()
	{
		$data = $this->__init();
		$data['reff'] = '';
		if (isset($_SERVER['HTTP_REFERER'])) {
			$allowed_host = ($_SERVER['HTTP_HOST']);
			$host = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
			if (substr($host, 0 - strlen($allowed_host)) == $allowed_host) {
				$data['reff'] = str_replace("/logout", " ", $_SERVER['HTTP_REFERER']);
			}
		}
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		if (strlen($username) > 3 && strlen($password) > 3) {
			$res = $this->bum->auth($username, $password);
			if (isset($res->id)) {
				if (empty($res->is_active)) {
					$data['pesan_info'] = 'Akun anda telah dinonaktifkan';

					$this->setTitle('Login ' . $this->config->semevar->site_title);
					$this->setDescription('Silakan login untuk masuk ke dashboard ' . $this->config->semevar->nama);

					$this->putJsFooter($this->cdn_url('skin/admin/') . 'js/pages/login');
					$this->putThemeContent("login/home", $data);
					$this->putJsContent('login/home_bottom', $data);
					$this->loadLayout('login', $data);
					$this->render();
					return;
				}

				//check password
				$pv1 = 1;
				$pv2 = 1;
				if (md5($password) != $res->password) {
					$pv1 = 0;
				}
				if (!password_verify($password, $res->password)) {
					$pv2 = 0;
				}
				if (empty($pv1) && empty($pv2)) {
					$data['pesan_info'] = 'Kombinasi username atau password tidak cocok';
					$this->setTitle('Login ' . $this->config->semevar->site_title);
					$this->setDescription('Silakan login untuk masuk ke dashboard ' . $this->config->semevar->nama);

					$this->putJsFooter($this->cdn_url('skin/admin/') . 'js/pages/login');
					$this->putThemeContent("login/home", $data);
					$this->putJsContent('login/home_bottom', $data);
					$this->loadLayout('login', $data);
					$this->render();
					return;
				}

				//upgrade password encryption
				if (!empty($pv1) && empty($pv2)) {
					$this->bum->update($res->id, array("password" => $this->__passGen($password)));
				}

				$sess = $data['sess'];
				if (!is_object($sess)) $sess = new stdClass();
				if (!isset($sess->user)) $sess->user = new stdClass();
				$sess->user = $res;
				$sess->user->utype = 'Member';


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

				$this->setKey($sess);

				$reff = $this->input->request('reff');
				if (strlen($reff) > 10) {
					redir($reff);
				} else {
					redir(base_url());
				}
				return;
			} else {
				$data['pesan_info'] = 'Username atau password salah';
			}
		} else {

			$data['pesan_info'] = 'Username atau password salah';
		}

		$this->setTitle('Login ' . $this->config->semevar->site_title);
		$this->setDescription('Silakan login untuk masuk ke dashboard ' . $this->config->semevar->nama);

		$this->putJsFooter($this->cdn_url('skin/admin/') . 'js/pages/login');
		$this->putThemeContent("login/home", $data);
		$this->putJsContent('login/home_bottom', $data);
		$this->loadLayout('login', $data);
		$this->render();
	}
	public function auth()
	{
		$dt = new stdClass();
		$data = $this->__init();
		$this->status = 102;
		$this->message = 'Gagal, kombinasi username atau password salah';
		$data['redirect_url'] = base_url('login');
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		if (strlen($username) > 3 && strlen($password) > 3) {
			$res = $this->bum->auth($username);

			if (isset($res->id)) {
				if (empty($res->is_active)) {
					$this->status = 103;
					$this->message = 'Akun anda telah dinonaktifkan';
					$this->__json_out($data);
					return;
				}

				//check password
				$pv1 = 1;
				$pv2 = 1;
				if (md5($password) != $res->password) {
					$pv1 = 0;
				}
				if (!password_verify($password, $res->password)) {
					$pv2 = 0;
				}
				if (empty($pv1) && empty($pv2)) {
					$this->status = 104;
					$this->message = 'Kombinasi username dan password tidak cocok';
					$this->__json_out($dt);
					return;
				}

				//upgrade password  encryption
				if (!empty($pv1) && empty($pv2)) {
					$this->bum->update($res->id, array("password" => $this->__passGen($password)));
				}

				$sess = $data['sess'];
				if (!is_object($sess)) $sess = new stdClass();
				if (!isset($sess->user)) $sess->user = new stdClass();
				$sess->user = $res;
				$sess->user->utype = 'Member';



				$sess->user->menus = new stdClass();
				$sess->user->menus->left = array();
				$sess->user->modules = array();

				//get modules
				// $modules = $this->amod->getAllParent('front');
				// foreach ($modules as &$module) {
				// 	$childs = $this->amod->getChild($module->identifier, 'front');
				// 	$mos = array();
				// 	if (count($childs) > 0) {
				// 		$sess->user->modules[] = $module;
				// 		foreach ($sess->user->modules as $m) {
				// 			foreach ($childs as $cs) {
				// 				$sess->user->modules[] = $module;
				// 			}
				// 		}
				// 	}
				// 	$module->childs = $mos;
				// }
				// unset($module);

				//set module to session
				// $allowed_all = 1;
				// foreach ($modules as $mo) {
				// 	$sess->user->menus->left[$mo->identifier] = $mo;
				// }
				// unset($mo);

				$this->setKey($sess);

				$this->status = 200;
				$this->message = 'Berhasil';
				$data['redirect_url'] = base_url();
				$reff = $this->input->request('reff');
				if (strlen($reff)) {
					$data['redirect_url'] = $reff;
				}
			}
		}
		$this->__json_out($data);
	}
	public function lupa_lagi()
	{
		$data = $this->__init();
		$email = $this->input->post("email");
		$password = $this->input->post("password");
		if (strlen($email) > 3 && strlen($password) > 3) {
			$res = $this->bum->auth($email, $password);
			if (isset($res->id)) {
				$sess = $data['sess'];
				if (!is_object($sess)) $sess = new stdClass();
				if (!isset($sess->user)) $sess->user = new stdClass();
				$sess->user = $res;
				$this->login_admin = 1;
				$this->setKey($sess);
				redir(base_url(""));
				return;
			} else {
				$data['pesan_info'] = 'Username atau password salah';
			}
		} else {

			$data['pesan_info'] = 'Username atau password salah';
		}

		$this->setTitle('Login ' . $this->config->semevar->site_title);
		$this->setDescription('Silakan login untuk masuk ke dashboard ' . $this->config->semevar->nama);

		$this->putJsFooter($this->cdn_url('skin/admin/') . 'js/pages/login');

		$this->putThemeContent("login/home", $data);
		$this->putJsContent('login/home_bottom', $data);
		$this->loadLayout('login', $data);
		$this->render();
	}
}
