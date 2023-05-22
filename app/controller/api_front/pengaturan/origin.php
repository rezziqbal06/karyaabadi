<?php

namespace Controller\Front\API;

register_namespace(__NAMESPACE__);

/**
 * API Controller Class for Origin Modul
 *
 * Mostly for this controller will resulting HTTP Body Content in JSON format
 *
 * @version 1.0.0
 *
 * @package Partner\Origin\API
 * @since 1.0.0
 */
class Origin extends \JI_Controller
{
    public $utype = '';

    public function __construct()
    {
        parent::__construct();
        $this->lib("seme_purifier");
        $this->load("a_origin_concern");
        $this->load("api_front/a_origin_model", 'aom');
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

        $datatable = $this->aom->datatable()->initialize();
        $dcount = $this->aom->count($datatable->keyword());
        $ddata = $this->aom->data(
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
                $gd->is_active = $this->aom->label('is_active', $gd->is_active);
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
        if (!$this->aom->validates()) {
            $this->status = 444;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
            $validation_message = $this->aom->validation_message();
            if (strlen($validation_message)) {
                $this->message = $validation_message;
            }
            $this->__json_out($data);
            die();
        }

        $res = $this->aom->save();
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
        if (!$this->aomin_login) {
            $this->status = 400;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
            header("HTTP/1.0 400 Harus login");
            $this->__json_out($data);
            die();
        }
        $id = (int) $id;

        $this->status = 200;
        $this->message = API_ADMIN_ERROR_CODES[$this->status];
        $data = $this->aom->id($id);
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

        if (!$this->aomin_login) {
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

        if (!$this->aom->validates()) {
            $this->status = 444;
            $this->message = API_ADMIN_ERROR_CODES[$this->status];
            $validation_message = $this->aom->validation_message();
            if (strlen($validation_message)) {
                $this->message = $validation_message;
            }
            $this->__json_out($data);
            die();
        }

        $res = $this->aom->save($id);
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
        if (!$this->aomin_login) {
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
        $pengguna = $d['sess']->aomin;

        $afm = $this->aom->id($id);
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

        $res = $this->aom->update($id, array('is_deleted' => 1));
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
    public function get_by_kota($kabkota)
    {
        $data = [];
        $this->status = 200;
        $this->message = API_ADMIN_ERROR_CODES[$this->status];
        if (!empty($kabkota)) {
            $data = $this->aom->getByKabkota($kabkota);
        }
        $this->__json_out($data);
    }
}
