<?php

namespace Controller\Front\API;

register_namespace(__NAMESPACE__);

/**
 * API Controller Class for Destination Modul
 *
 * Mostly for this controller will resulting HTTP Body Content in JSON format
 *
 * @version 1.0.0
 *
 * @package Partner\Destination\API
 * @since 1.0.0
 */
class Destination extends \JI_Controller
{
    public $utype = '';

    public function __construct()
    {
        parent::__construct();
        $this->lib("seme_purifier");
        $this->load("a_destination_concern");
        $this->load("api_front/a_destination_model", 'adm');
        $this->current_parent = 'destination';
        $this->current_page = 'destination_masterdata';
    }



    /**
     * Give json data set result on datatable format
     *
     * @api
     *
     * @return void
     */
    public function index()
    {
        $d = $this->__init();
        $data = array();
        $this->_api_auth_required($data, 'user');

        $this->status = 200;
        $this->message = API_ADMIN_ERROR_CODES[$this->status];

        /** advanced filter is_active */
        $is_active = $this->input->request('is_active', '');
        if (strlen($is_active)) {
            $is_active = intval($is_active);
        }

        $datatable = $this->adm->datatable()->initialize();
        $dcount = $this->adm->count($datatable->keyword());
        $ddata = $this->adm->data(
            $datatable->page(),
            $datatable->pagesize(),
            $datatable->sort_column(),
            $datatable->sort_direction(),
            $datatable->keyword(),
            $is_active
        );

        foreach ($ddata as &$gd) {
            if (isset($gd->nama)) {
                $gd->nama = htmlentities(rtrim($gd->nama, ' - '));
            }
            if (isset($gd->nominal)) {
                $gd->nominal = $this->rupiah->format($gd->nominal);
            }
            if (isset($gd->is_active)) {
                $gd->is_active = $this->adm->label('is_active', $gd->is_active);
            }
        }

        $this->__jsonDataTable($ddata, $dcount);
    }

    /**
     * Create new data
     *
     * @api
     *
     * @return void
     */
    public function baru()
    {
        $d = $this->__init();

        $data = new \stdClass();
        if (!$this->adm->validates()) {
            $this->status = 444;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
            $validation_message = $this->adm->validation_message();
            if (strlen($validation_message)) {
                $this->message = $validation_message;
            }
            $this->__json_out($data);
            die();
        }

        $res = $this->adm->save();
        if ($res) {
            $this->status = 200;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
        } else {
            $this->status = 110;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
        }
        $this->__json_out($data);
    }

    /**
     * Get detailed information by idea
     *
     * @param  int   $id               ID value from a_fasilitas table
     *
     * @api
     * @return void
     */
    public function detail($id)
    {
        $d = $this->__init();
        $data = array();
        if (!$this->user_login) {
            $this->status = 400;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
            header("HTTP/1.0 400 Harus login");
            $this->__json_out($data);
            die();
        }
        $id = (int) $id;

        $this->status = 200;
        $this->message = API_ADMIN_ERROR_CODES[$this->status];
        $data = $this->adm->id($id);
        if (!isset($data->id)) {
            $data = new \stdClass();
            $this->status = 441;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
            $this->__json_out($data);
            die();
        }
        $this->__json_out($data);
    }

    /**
     * Update data by supplied ID
     *
     * @param  int   $id               ID value from a_fasilitas table
     *
     * @api
     *
     * @return void
     */
    public function edit($id)
    {
        $d = $this->__init();
        $data = array();

        if (!$this->user_login) {
            $this->status = 400;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
            header("HTTP/1.0 400 Harus login");
            $this->__json_out($data);
            die();
        }

        $id = (int) $id;
        if ($id <= 0) {
            $this->status = 444;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
            $this->__json_out($data);
            die();
        }

        if (!$this->adm->validates()) {
            $this->status = 444;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
            $validation_message = $this->adm->validation_message();
            if (strlen($validation_message)) {
                $this->message = $validation_message;
            }
            $this->__json_out($data);
            die();
        }

        $res = $this->adm->save($id);
        if ($res) {
            $this->status = 200;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
        } else {
            $this->status = 901;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
        }
        $this->__json_out($data);
    }

    /**
     * Delete data by supplied ID
     *
     * @param  int   $id               ID value from a_fasilitas table
     *
     * @api
     *
     * @return void
     */
    public function hapus($id)
    {
        $d = $this->__init();

        $data = array();
        if (!$this->user_login) {
            $this->status = 400;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
            header("HTTP/1.0 400 Harus login");
            $this->__json_out($data);
            die();
        }

        $id = (int) $id;
        if ($id <= 0) {
            $this->status = 520;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
            $this->__json_out($data);
            die();
        }
        $pengguna = $d['sess']->admin;

        $afm = $this->adm->id($id);
        if (!isset($afm->id)) {
            $this->status = 521;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
            $this->__json_out($data);
            die();
        }
        if (!empty($afm->is_deleted)) {
            $this->status = 522;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
            $this->__json_out($data);
            die();
        }

        $res = $this->adm->update($id, array('is_deleted' => 1));
        if ($res) {
            $this->status = 200;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
        } else {
            $this->status = 902;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
        }
        $this->__json_out($data);
    }

    /**
     * Search data by keyword on select2 format
     *
     *
     * @api
     *
     * @return void
     */
    public function cari()
    {
        $keyword = $this->input->request("keyword");
        $type = $this->input->request("type");
        if (empty($keyword)) {
            $keyword = "";
        }
        if (!empty($type) && $type == 'kota') {
            $data = $this->adm->getKota($keyword);
        } else {
            $data = $this->adm->getSearch($keyword);
        }
        $this->__json_select2($data);
    }
}
