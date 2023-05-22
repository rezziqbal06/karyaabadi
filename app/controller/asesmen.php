<?php

use Dompdf\Dompdf;

class Asesmen extends JI_Controller
{
	var $media_pengguna = 'media/';

	public function __construct()
	{
		parent::__construct();
		$this->setTheme('front');
		$this->current_parent = 'asesmen';
		$this->current_page = 'asesmen';
		// $this->load('a_company_concern');
		$this->load('a_jpenilaian_concern');
		$this->load('a_indikator_concern');
		$this->load('a_ruangan_concern');
		$this->load('a_jabatan_concern');
		$this->load('b_user_concern');
		$this->load('b_user_module_concern');
		$this->load('c_asesmen_concern');
		$this->load('d_value_concern');

		$this->load('front/a_jpenilaian_model', 'ajm');
		$this->load('front/a_indikator_model', 'aim');
		$this->load('front/a_ruangan_model', 'arm');
		$this->load('front/a_jabatan_model', 'ajbm');
		$this->load('front/b_user_model', 'bum');
		$this->load('front/b_user_module_model', 'bumm');
		$this->load('front/c_asesmen_model', 'cam');
		$this->load('api_front/d_value_model', 'dvm');
	}

	public function index()
	{
		$data = $this->__init();

		if (!$this->user_login) {
			redir(base_url('login'));
			die();
		}

		$user = $data['sess']->user;
		$ajm = $this->ajm->getAllPermit($user->a_jabatan_id, $user->id);
		if (isset($ajm[0]->id)) $data['ajm'] = $ajm;
		unset($ajm);


		$this->setTitle('Asesmen ' . $this->config->semevar->site_suffix);
		$this->putThemeContent("asesmen/home_modal", $data);
		$this->putThemeContent("asesmen/home", $data);

		$this->putJsReady("asesmen/home_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}
	public function detail($slug = '')
	{
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'));
			die();
		}

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

		$aim = $this->aim->getByPenilaianId($ajm->id);
		if (!isset($aim[0]->id)) {
			redir(base_url('asesmen'));
			die();
		}
		$data['aim'] = $aim;

		$arm = $this->arm->getAll();
		if (!isset($arm[0]->id)) {
			redir(base_url('asesmen'));
			die();
		}
		$data['arm'] = $arm;

		$ajbm = $this->ajbm->getAll();
		if (!isset($ajbm[0]->id)) {
			redir(base_url('asesmen'));
			die();
		}
		$data['ajbm'] = $ajbm;

		$type_form = $ajm->type_form ?? 1;
		if (in_array($ajm->slug, ['audit-hand-hygiene'])) {
			$type_form = 1;
		} else if (in_array($ajm->slug, ['monitoring-kegiatan-harian-pencegahan-pengendalian-infeksi-ppi'])) {
			$type_form = 2;
		} else if (in_array($ajm->slug, ['audit-kepatuhan-apd'])) {
			$type_form = 3;
		} else if (in_array($ajm->slug, ['surveilan-pencegahan-dan-pengendalian-infeksi'])) {
			$type_form = 4;
		}

		if ($type_form == 2) {
			$group_by_kategori = [];
			foreach ($aim as $key) {
				$group_by_kategori[$key->kategori][] = $key;
			}
			$data['aim'] = $group_by_kategori;
		}

		$data['type_form'] = $type_form;
		$data['slug'] = $ajm->slug;

		$data['permission'] = new \stdClass;
		$data['permission']->create = $this->bumm->getPermission($ajm->id, "create", $data['sess']->user->a_jabatan_id, $data['sess']->user->id);
		$data['permission']->edit = $this->bumm->getPermission($ajm->id, "edit", $data['sess']->user->a_jabatan_id, $data['sess']->user->id);

		// unset($type_form);
		unset($ajm);
		unset($aim);
		unset($aim);

		date_default_timezone_set('Asia/Jakarta');
		$data['stime'] = date('H:i:s');
		if ($type_form != 4) {
			$this->setTitle('Asesmen' . $this->config->semevar->site_suffix);
			$this->putThemeContent("asesmen/detail_modal", $data);
			$this->putThemeContent("asesmen/detail", $data);

			$this->putJsReady("asesmen/detail_bottom", $data);
			$this->loadLayout('col-1', $data);
			$this->render();
		} else {
			$this->setTitle('Asesmen' . $this->config->semevar->site_suffix);
			$this->putThemeContent("asesmen/detail_modal", $data);
			$this->putThemeContent("asesmen/survei", $data);
			$this->putJsReady("asesmen/detail_bottom", $data);
			$this->loadLayout('col-1', $data);
			$this->render();
		}
	}

	public function edit($slug = '', $id = '')
	{
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'));
			die();
		}

		if (!strlen($slug)) {
			redir(base_url(''));
			die();
		}

		$ajm = $this->ajm->getBySlug($slug);
		if (!isset($ajm->id)) {
			redir(base_url(''));
			die();
		}
		$data['ajm'] = $ajm;

		$aim = $this->aim->getByPenilaianId($ajm->id);
		if (!isset($aim[0]->id)) {
			redir(base_url(''));
			die();
		}
		$data['aim'] = $aim;

		$arm = $this->arm->getAll();
		if (!isset($arm[0]->id)) {
			redir(base_url(''));
			die();
		}
		$data['arm'] = $arm;

		$ajbm = $this->ajbm->getAll();
		if (!isset($ajbm[0]->id)) {
			redir(base_url(''));
			die();
		}
		$data['ajbm'] = $ajbm;

		$cam = $this->cam->id($id);
		if (!isset($cam)) {
			redir(base_url(''));
			die();
		}
		// dd($cam->value);

		$user = $this->bum->id($cam->b_user_id);
		if (!isset($user)) {
			redir(base_url(''));
			die();
		}
		$cam->b_user_name = $user->fnama ?? '';
		$bulan = date('m', strtotime($cam->cdate));
		if ($ajm->type_form == 1) {
			$value = $this->dvm->getByFilter($user->id, $cam->b_user_id_penilai, $ajm->id, date('Y-' . (int)$bulan . '-1'), date('Y-' . (int)$bulan . '-t'));
		} else {
			$value = json_decode($cam->value);
		}
		// dd($value);
		$type_form = $ajm->type_form ?? '';
		if (!strlen($type_form)) {
			if (in_array($ajm->slug, ['audit-hand-hygiene'])) {
				$type_form = 1;
			} else if (in_array($ajm->slug, ['monitoring-kegiatan-harian-pencegahan-pengendalian-infeksi-ppi'])) {
				$type_form = 2;
			} else if (in_array($ajm->slug, ['audit-kepatuhan-apd'])) {
				$type_form = 3;
			}
		}


		$data['permission'] = new \stdClass;
		$data['permission']->create = $this->bumm->getPermission($ajm->id, "create", $data['sess']->user->a_jabatan_id, $data['sess']->user->id);
		$data['permission']->edit = $this->bumm->getPermission($ajm->id, "edit", $data['sess']->user->a_jabatan_id, $data['sess']->user->id);

		$data['type_form'] = $type_form;
		$data['slug'] = $ajm->slug;
		$data['cam'] = $cam;
		$data['user'] = $user;
		$data['value'] = $value;
		$data['id'] = $id;
		unset($value);
		unset($type_form);
		unset($ajm);
		unset($aim);
		unset($cam);
		unset($user);

		// dd($data['value']);
		date_default_timezone_set('Asia/Jakarta');
		$data['stime'] = date('H:i:s');

		$this->setTitle('Asesmen' . $this->config->semevar->site_suffix);
		$this->putThemeContent("asesmen/detail_modal", $data);
		$this->putThemeContent("asesmen/detail", $data);

		$this->putJsReady("asesmen/detail_bottom", $data);
		$this->loadLayout('col-1', $data);
		$this->render();
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
					.text-center {
						text-align: center;
					}

					.my_table {
						margin-bottom: 0.5rem;
						width: 100%;
						border-collapse: collapse;
					}

					.my_table td {
						border: 1px solid #ced4da;
						padding: 0.5rem;
					}

					.my_table th {
						border: 1px solid #ced4da;
						padding: 0.5rem;
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
				</style>';

		$html .= $content;

		$html .= '</body>
		</html>';
		$_SESSION['html_print'] = $html;

		$this->status = 200;
		$this->message = 'Berhasil';
		$this->__json_out($data);
	}
}
