<?php
class Home extends JI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->setTheme('front');
		$this->current_parent = 'dashboard';
		$this->current_page = 'dashboard';

		// $this->load('a_ruangan_concern');
		// $this->load('b_user_concern');

		// $this->load('front/a_ruangan_model', 'arm');
		// $this->load('front/b_user_model', 'bum');
	}

	public function index()
	{
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'), 0);
			die();
		}
		$this->setTitle('Dashboard ' . $this->config->semevar->site_suffix);


		// $ajm = $this->ajm->getAll();
		// if (isset($ajm[0]->id)) $data['ajm'] = $ajm;

		// $data['ajm'] = $ajm;
		// unset($ajm);

		// $bum = $this->bum->getAll();
		// if (isset($bum[0]->id)) $data['bum'] = $bum;

		// $data['bum'] = $bum;
		// unset($bum);

		// $arm = $this->arm->getAll();
		// if (isset($arm[0]->id)) $data['arm'] = $arm;

		// $data['arm'] = $arm;
		// unset($arm);

		// $data['jp'] = $this->input->request('jp', 2);

		$this->putThemeContent("home/home", $data);
		$this->putThemeContent("home/home_modal", $data);
		$this->putThemeContent("home/print_hh", $data);
		$this->putJsContent("home/home_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}
}
