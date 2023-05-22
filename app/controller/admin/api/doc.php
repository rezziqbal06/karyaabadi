<?php

namespace Controller;

register_namespace(__NAMESPACE__);
class Doc extends \JI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->setTheme('admin');
		$this->current_parent = 'api_doc';
		$this->current_page = 'api_doc';
		$this->load("a_api_concern");
		$this->load("admin/a_api_model", 'aam');
	}

	public function index()
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url('login'), 0);
			die();
		}

		$aam = $this->aam->get();
		if (!isset($aam[0])) {
			redir(base_url(''), 0);
			die();
		}
		$data['aam'] = $aam;
		unset($aam);
		$this->setTitle('Halaman Dokumentasi API ' . $this->config->semevar->site_suffix);

		//$this->putJsFooter($this->cdn_url('skin/admin/').'js/helpers/gmaps.min',0);
		$this->putJsFooter($this->cdn_url('skin/admin/') . 'js/pages/index');

		$this->putThemeContent("documentation/home", $data);
		$this->putThemeContent("documentation/home_modal", $data);
		$this->putJsContent("documentation/home_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}

	public function detail($type = '')
	{
		$data = $this->__init();
		if (!$this->admin_login) {
			redir(base_url('login'), 0);
			die();
		}

		if (!strlen($type)) {
			redir(base_url(''), 0);
			die();
		}

		$aam = $this->aam->getByType($type);
		if (!isset($aam->id)) {
			redir(base_url(''), 0);
			die();
		}
		$data['aam'] = $aam;
		unset($aam);
		$this->setTitle('Halaman Dokumentasi API ' . $this->config->semevar->site_suffix);

		//$this->putJsFooter($this->cdn_url('skin/admin/').'js/helpers/gmaps.min',0);
		$this->putJsFooter($this->cdn_url('skin/admin/') . 'js/pages/index');

		$this->putThemeContent("documentation/detail", $data);
		$this->putThemeContent("documentation/detail_modal", $data);
		$this->putJsContent("documentation/detail_bottom", $data);
		$this->loadLayout('col-2-left', $data);
		$this->render();
	}
}
