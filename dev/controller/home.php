<?php
class Home extends JI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $this->cli->print_main_command();
        $this->cli->print_command_item('dump', '', 'Command for data dump');
        $this->cli->print_command_item('migrate', '', 'Command for data migration');
    }
}
