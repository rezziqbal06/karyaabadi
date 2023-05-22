<?php
class Admin extends JI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->setTheme('front');
		$this->current_parent = 'pengaturan';
		$this->current_page = 'pengaturan_admin';
		$this->load("front/b_user_model", 'bum');
	}

	/**
	 * Generates hak akses list in html view for default value checked button
	 * @param  string $id [description]
	 * @return [type]     [description]
	 */
	private function __vHakAkses($id = "")
	{
		$this->load('front/a_modules_model', 'amm');
		$res = '';
		$amm = $this->amm->getChildModules($id);
		if (!empty($amm)) {
			$td = '';
			$n	= 1;
			foreach ($amm as $am) {
				if (empty($id)) {
					$td .= '<td width="50%" valign="top">';
					$td .= '<label for="' . $am->identifier . '"><input id="' . $am->identifier . '" type="checkbox" name="a_modules_identifier[]" value="' . $am->identifier . '" data-key="parent" />&nbsp; ' . $am->name . '</label>';
					$td .= $this->__vHakAkses($am->identifier);
					$td .= '</td>';
					if ($n == 2) {
						$res   .= '<tr>' . $td . '</tr>';
						$td		= '';
						$n 		= 1;
					} else {
						$n++;
					}
				} else {
					$res .= '<br><label for="' . $am->identifier . '"><input id="' . $am->identifier . '" type="checkbox" class="' . $id . '" name="a_modules_identifier[]" data-key="child" value="' . $am->identifier . '" />&nbsp; -- ' . $am->name . '</label>';
				}
			}
			if (!empty($td)) {
				$res .= '<tr>' . $td . '<td></td></tr>';
			}
		}
		return $res;
	}

	public function index()
	{
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'));
			return false;
		}
		$data['hakakses_v']	= $this->__vHakAkses();

		$this->setTitle('Admin ' . $this->config->semevar->site_suffix);

		$this->putThemeContent("pengaturan/admin/home_modal", $data);
		$this->putThemeContent("pengaturan/admin/home", $data);
		$this->putJsContent("pengaturan/admin/home_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}

	public function baru()
	{
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'));
			return false;
		}
		$this->setTitle('Tambah Admin ' . $this->config->semevar->site_suffix);

		$this->putThemeContent("pengaturan/admin/baru_modal", $data);
		$this->putThemeContent("pengaturan/admin/baru", $data);
		$this->putJsContent("pengaturan/admin/baru_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}
	public function edit($id)
	{
		$id = (int) $id;
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'));
			return false;
		}
		if ($id <= 0) {
			redir(base_url('pengaturan/admin/'));
			return false;
		}
		$a_company_id = $data['sess']->user->a_company_id;

		$bum = $this->bum->getById($id, $a_company_id);
		if (!isset($bum->id)) {
			redir(base_url('pengaturan/admin/'));
			return false;
		}
		if ($bum->b_user_id != $data['sess']->user->id) {
			redir(base_url('pengaturan/admin/'));
			return false;
		}

		$data['bum'] = $bum;

		$this->setTitle('Edit Admin ' . $this->config->semevar->site_suffix);
		$this->putThemeContent("pengaturan/admin/edit_modal", $data);
		$this->putThemeContent("pengaturan/admin/edit", $data);
		$this->putJsContent("pengaturan/admin/edit_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}

	public function detail($id)
	{
		$data = $this->__init();
		if (!$this->user_login) {
			redir(base_url('login'));
			return false;
		}
		$id = (int) $id;
		if (empty($id)) {
			redir(base_url('pengaturan/admin/'));
			return false;
		}

		$data['bum'] = $this->bum->getById($id);
		if (!isset($data['bum']->id)) {
			redir(base_url('pengaturan/admin/'));
			return false;
		}
		if ($data['bum']->b_user_id != $data['sess']->user->id) {
			redir(base_url('pengaturan/admin/'));
			return false;
		}

		$this->setTitle('Detail Admin: #' . $data['bum']->id . ' ' . $this->config->semevar->site_suffix);

		$this->putThemeContent("pengaturan/admin/detail_modal", $data);
		$this->putThemeContent("pengaturan/admin/detail", $data);
		$this->putJsContent("pengaturan/admin/detail_bottom", $data);
		$this->loadLayout('col-1-bar', $data);
		$this->render();
	}
}
