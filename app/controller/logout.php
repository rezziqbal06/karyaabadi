<?php
class Logout extends JI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->setTheme('front');
	}
	public function index()
	{
		$d = $this->__init();
		unset($_SESSION);
		$sess = $d['sess'];
		if (!is_object($sess)) $sess = new stdClass();
		if (!isset($sess->user)) $sess->user = new stdClass();
		if (!isset($sess->admin)) $sess->admin = new stdClass();
		$sess->user = new stdClass();
		$sess->admin = new stdClass();
		$this->login_user = 0;
		$this->login_admin = 0;
		$this->setKey($sess);
		flush();
		redir(base_url("login"), 0, 1);
	}
}
