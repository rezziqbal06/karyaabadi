<?php
include('seme_curl.php');

class Jne
{
    public $url = '';
    public $api_key = '';
    public $username = '';
    public $type = 'sandbox';
    public $status = [];
    public $icon = [];
    public $color = [];

    public $sandbox_url = 'http://apiv2.jne.co.id:10102/';
    public $prod_url = 'http://apiv2.jne.co.id:10101/';
    public $sandbox_api_key = '25c898a9faea1a100859ecd9ef674548';
    public $sandbox_username = 'TESTAPI';
    public $prod_api_key = '28ad3909b85d9b69396bf450024367a0';
    public $prod_username = 'SEHADI';

    public function __construct()
    {
        if ($this->type == 'sandbox') {
            $this->api_key = $this->sandbox_api_key;
            $this->username = $this->sandbox_username;
            $this->url = $this->sandbox_url;
        } else if ($this->type == 'production' || $this->type == 'live') {
            $this->api_key = $this->prod_api_key;
            $this->username = $this->prod_username;
            $this->url = $this->prod_url;
        }

        $this->status['D01'] = 'Sukses Diterima';
        $this->status['OP1'] = 'Diterima Ditempat Penyortiran';
        $this->status['OP2'] = 'Sedang Disortir';
        $this->status['OP3'] = 'Dalam Transit';
        $this->status['OP4'] = 'Sedang Menuju Tujuan';
        $this->status['IP1'] = 'Diterima di Gudang';
        $this->status['IP2'] = 'Berada di Kantor Terdekat';
        $this->status['RC1'] = 'Paket Telah Diterima JNE Dari Pengirim';
        $this->status['RC2'] = 'Paket Berada Di Konter';
        $this->status['TP4'] = 'Dikirim Dari Transit';

        $this->icon['DELIVERED'] = 'check';
        $this->icon['OTHERS'] = 'info';
        $this->icon['OTHER'] = 'info';
        $this->icon['UNDELIVERED'] = 'times';
        $this->icon['BEA CUKA'] = 'id-badge';
        $this->icon['DELIVERY PROBLEM'] = 'truck';
        $this->icon['GATEWAY PROCESS'] = 'id-card-o';
        $this->icon['HOLD PROCESS'] = 'clock-o';
        $this->icon['INBOUND PROCESS'] = 'arrow-right';
        $this->icon['IRREGULARITY'] = 'exclamation';
        $this->icon['OUTBOUND PROCESS'] = 'arrow-left';
        $this->icon['OUTBOUND...'] = 'arrow-left';
        $this->icon['PICKUP'] = 'box';
        $this->icon['PICKUP PROCESS'] = 'box';
        $this->icon['PROBLEM SHIPMENT'] = 'ship';
        $this->icon['RETURN'] = 'undo';
        $this->icon['TRANSPORT IRREGULARITY'] = 'truck';


        $this->color['DELIVERED'] = 'success';
        $this->color['OTHERS'] = 'info';
        $this->color['OTHER'] = 'info';
        $this->color['UNDELIVERED'] = 'danger';
        $this->color['BEA CUKA'] = 'info';
        $this->color['DELIVERY PROBLEM'] = 'warning';
        $this->color['GATEWAY PROCESS'] = 'info';
        $this->color['HOLD PROCESS'] = 'warning';
        $this->color['INBOUND PROCESS'] = 'info';
        $this->color['IRREGULARITY'] = 'warning';
        $this->color['OUTBOUND PROCESS'] = 'info';
        $this->color['OUTBOUND...'] = 'info';
        $this->color['PICKUP'] = 'warning';
        $this->color['PICKUP PROCESS'] = 'warning';
        $this->color['PROBLEM SHIPMENT'] = 'warning';
        $this->color['RETURN'] = 'danger';
        $this->color['TRANSPORT IRREGULARITY'] = 'warning';
    }

    public function set_type($type = 'sandbox')
    {
        if ($type == 'sandbox') {
            $this->api_key = $this->sandbox_api_key;
            $this->username = $this->sandbox_username;
            $this->url = $this->sandbox_url;
        } else if ($type == 'production' || $type == 'live') {
            $this->api_key = $this->prod_api_key;
            $this->username = $this->prod_username;
            $this->url = $this->prod_url;
        }
    }
    /**
     * Generate AIRWAYBILL
     */
    public function create_airwaybill($request = array())
    {

        $data = array();
        if (!isset($request['OLSHOP_ORDERID'])) {
            $data['status'] = 400;
            $data['message'] = 'Order ID belum diisi';
            return $data;
            die();
        }

        if (
            !isset($request['OLSHOP_SHIPPER_NAME'])  ||
            !isset($request['OLSHOP_SHIPPER_ADDR1'])  ||
            !isset($request['OLSHOP_SHIPPER_ZIP'])  ||
            !isset($request['OLSHOP_SHIPPER_CITY'])  ||
            !isset($request['OLSHOP_SHIPPER_PHONE'])
        ) {
            $data['status'] = 401;
            $data['message'] = 'Salah satu data pengirim belum diisi';
            return $data;
            die();
        }

        if (
            !isset($request['OLSHOP_RECEIVER_NAME'])  ||
            !isset($request['OLSHOP_RECEIVER_ADDR1'])  ||
            !isset($request['OLSHOP_RECEIVER_ZIP'])  ||
            !isset($request['OLSHOP_RECEIVER_CITY'])  ||
            !isset($request['OLSHOP_RECEIVER_PHONE'])
        ) {
            $data['status'] = 401;
            $data['message'] = 'Salah satu data penerima belum diisi';
            return $data;
            die();
        }

        if (!isset($request['OLSHOP_QTY'])) {
            $data['status'] = 403;
            $data['message'] = 'QTY belum dipilih';
            return $data;
            die();
        }

        if (!isset($request['OLSHOP_GOODSDESC'])) {
            $data['status'] = 405;
            $data['message'] = 'Deskripsi barang belum diisi';
            return $data;
            die();
        }

        if ($request['OLSHOP_INS_FLAG']) {
            $request['OLSHOP_INS_FLAG'] = 'Y';
        } else {
            $request['OLSHOP_INS_FLAG'] = 'N';
        }
        if ($this->username == $this->sandbox_username) {
            $request['OLSHOP_ORIG'] = 'CGK10000';
            $request['OLSHOP_DEST'] = 'BDO10000';
        }

        $fd = array();
        $fd['username'] = $this->username;
        $fd['api_key'] = $this->api_key;
        $fd['OLSHOP_BRANCH'] = $request['OLSHOP_BRANCH'];
        if ($fd['username'] == $this->username) $fd['OLSHOP_BRANCH'] = 'CGK000';
        $fd['OLSHOP_CUST'] = $request['OLSHOP_CUST'];
        // if ($fd['username'] == $this->username) $fd['OLSHOP_CUST'] = 10950700;
        $fd['OLSHOP_ORDERID'] = $request['OLSHOP_ORDERID'];
        $fd['OLSHOP_SHIPPER_NAME'] = $request['OLSHOP_SHIPPER_NAME'];
        $fd['OLSHOP_SHIPPER_ADDR1'] = $request['OLSHOP_SHIPPER_ADDR1'];
        $fd['OLSHOP_SHIPPER_ADDR2'] = $request['OLSHOP_SHIPPER_ADDR2'];
        $fd['OLSHOP_SHIPPER_CITY'] = $request['OLSHOP_SHIPPER_CITY'];
        $fd['OLSHOP_SHIPPER_ZIP'] = $request['OLSHOP_SHIPPER_ZIP'];
        $fd['OLSHOP_SHIPPER_PHONE'] = $request['OLSHOP_SHIPPER_PHONE'];
        $fd['OLSHOP_RECEIVER_NAME'] = $request['OLSHOP_RECEIVER_NAME'];
        $fd['OLSHOP_RECEIVER_ADDR1'] = $request['OLSHOP_RECEIVER_ADDR1'];
        $fd['OLSHOP_RECEIVER_ADDR2'] = $request['OLSHOP_RECEIVER_ADDR2'];
        $fd['OLSHOP_RECEIVER_CITY'] = $request['OLSHOP_RECEIVER_CITY'];
        $fd['OLSHOP_RECEIVER_ZIP'] = $request['OLSHOP_RECEIVER_ZIP'];
        $fd['OLSHOP_RECEIVER_PHONE'] = $request['OLSHOP_RECEIVER_PHONE'];
        $fd['OLSHOP_QTY'] = $request['OLSHOP_QTY'];
        $fd['OLSHOP_WEIGHT'] = $request['OLSHOP_WEIGHT'];
        $fd['OLSHOP_GOODSDESC'] = $request['OLSHOP_GOODSDESC'];
        $fd['OLSHOP_GOODSTYPE'] = $request['OLSHOP_GOODSTYPE'];
        $fd['OLSHOP_INS_FLAG'] = $request['OLSHOP_INS_FLAG'];
        $fd['OLSHOP_ORIG'] = $request['OLSHOP_ORIG'];
        $fd['OLSHOP_DEST'] = $request['OLSHOP_DEST'];
        $fd['OLSHOP_SERVICE'] = $request['OLSHOP_SERVICE'];
        $fd['OLSHOP_COD_FLAG'] = $request['OLSHOP_COD_FLAG'];
        $fd['OLSHOP_COD_AMOUNT'] = (int) $request['OLSHOP_COD_AMOUNT'];
        $fd['OLSHOP_GOODSVALUE'] = (int) trim($request['OLSHOP_GOODSVALUE']);

        $data['status'] = 200;
        $data['message'] = 'Berhasil';

        $seme_curl = new Seme_Curl();
        $response = $seme_curl->post($this->url . 'tracing/api/generatecnote/', $fd);
        if (!isset($response->header->http_code) && $response->header->http_code != 200) {
            $data['status'] = 500;
            $data['message'] = "Access Denied";
            return $data;
        }

        $data['fd'] = $fd;

        $data['url'] = $this->url . 'tracing/api/generatecnote/';
        $data['head'] = $response->header;
        $data['data'] = $response->body;
        return $data;
    }

    /**
     * Generate JNE Online Booking (JOB) Direct Agent
     */
    public function create_job($request = array())
    {

        $data = array();
        // if (!isset($request['OLSHOP_ORDERID'])) {
        //     $data['status'] = 400;
        //     $data['message'] = 'Order ID belum diisi';
        //     return $data;
        //     die();
        // }

        if (
            !isset($request['ORIGIN_DESC'])  ||
            !isset($request['ORIGIN_CODE'])  ||
            !isset($request['DESTINATION_DESC'])  ||
            !isset($request['DESTINATION_CODE'])
        ) {
            $data['status'] = 401;
            $data['message'] = 'Data origin/destination belum diisi';
            return $data;
            die();
        }

        if (
            !isset($request['SHIPPER_NAME'])  ||
            !isset($request['SHIPPER_ADDR1'])  ||
            !isset($request['SHIPPER_ZIP'])  ||
            !isset($request['SHIPPER_CITY'])  ||
            !isset($request['SHIPPER_REGION'])  ||
            !isset($request['SHIPPER_CONTACT'])  ||
            !isset($request['SHIPPER_PHONE'])
        ) {
            $data['status'] = 401;
            $data['message'] = 'Salah satu data pengirim belum diisi';
            return $data;
            die();
        }

        if (
            !isset($request['RECEIVER_NAME'])  ||
            !isset($request['RECEIVER_ADDR1'])  ||
            !isset($request['RECEIVER_ZIP'])  ||
            // !isset($request['RECEIVER_CITY'])  ||
            !isset($request['RECEIVER_REGION'])  ||
            !isset($request['RECEIVER_COUNTRY'])  ||
            !isset($request['RECEIVER_CONTACT'])  ||
            !isset($request['RECEIVER_PHONE'])
        ) {
            $data['status'] = 401;
            $data['message'] = 'Salah satu data penerima belum diisi';
            return $data;
            die();
        }

        if (!isset($request['QTY'])) {
            $data['status'] = 403;
            $data['message'] = 'QTY belum dipilih';
            return $data;
            die();
        }

        if (!isset($request['GOODS_DESC'])) {
            $data['status'] = 405;
            $data['message'] = 'Deskripsi barang belum diisi';
            return $data;
            die();
        }

        // if ($this->username == $this->sandbox_username) {
        //     $request['ORIG'] = 'CGK10000';
        //     $request['DEST'] = 'BDO10000';
        // }

        $fd = array();
        $fd['username'] = $this->username;
        $fd['api_key'] = $this->api_key;
        $fd['SHIPPER_NAME'] = $request['SHIPPER_NAME'];
        $fd['SHIPPER_ADDR1'] = $request['SHIPPER_ADDR1'];
        if (isset($request['SHIPPER_ADDR2']) && strlen($request['SHIPPER_ADDR2'])) $fd['SHIPPER_ADDR2'] = $request['SHIPPER_ADDR2'];
        if (isset($request['SHIPPER_ADDR3']) && strlen($request['SHIPPER_ADDR3'])) $fd['SHIPPER_ADDR3'] = $request['SHIPPER_ADDR3'];
        $fd['SHIPPER_CITY'] = $request['SHIPPER_CITY'];
        $fd['SHIPPER_ZIP'] = $request['SHIPPER_ZIP'];
        $fd['SHIPPER_REGION'] = $request['SHIPPER_REGION'];
        $fd['SHIPPER_COUNTRY'] = $request['SHIPPER_COUNTRY'];
        $fd['SHIPPER_CONTACT'] = $request['SHIPPER_CONTACT'];
        $fd['SHIPPER_PHONE'] = $request['SHIPPER_PHONE'];
        $fd['RECEIVER_NAME'] = $request['RECEIVER_NAME'];
        $fd['RECEIVER_ADDR1'] = $request['RECEIVER_ADDR1'];
        if (isset($request['RECEIVER_ADDR2']) && strlen($request['RECEIVER_ADDR2'])) $fd['RECEIVER_ADDR2'] = $request['RECEIVER_ADDR2'];
        if (isset($request['RECEIVER_ADDR3']) && strlen($request['RECEIVER_ADDR3'])) $fd['RECEIVER_ADDR3'] = $request['RECEIVER_ADDR3'];
        $fd['RECEIVER_ZIP'] = $request['RECEIVER_ZIP'];
        $fd['RECEIVER_CITY'] = $request['RECEIVER_CITY'];
        $fd['RECEIVER_REGION'] = $request['RECEIVER_REGION'];
        $fd['RECEIVER_COUNTRY'] = $request['RECEIVER_COUNTRY'];
        $fd['RECEIVER_CONTACT'] = $request['RECEIVER_CONTACT'];
        $fd['RECEIVER_PHONE'] = $request['RECEIVER_PHONE'];
        $fd['ORIGIN_DESC'] = $request['ORIGIN_DESC'];
        $fd['ORIGIN_CODE'] = $request['ORIGIN_CODE'];
        $fd['DESTINATION_CODE'] = $request['DESTINATION_CODE'];
        $fd['DESTINATION_DESC'] = $request['DESTINATION_DESC'];
        $fd['SERVICE_CODE'] = $request['SERVICE_CODE'];
        $fd['WEIGHT'] = $request['WEIGHT'];
        $fd['QTY'] = $request['QTY'];
        $fd['GOODS_DESC'] = $request['GOODS_DESC'];
        $fd['GOODS_AMOUNT'] = $request['GOODS_AMOUNT'];
        $fd['INSURANCE_FLAG'] = $request['INSURANCE_FLAG'];
        $fd['INSURANCE_AMOUNT'] = $request['INSURANCE_AMOUNT'];
        $fd['DELIVERY_PRICE'] = $request['DELIVERY_PRICE'];
        $fd['BOOK_CODE'] = $request['BOOK_CODE'];
        $fd['AWB_TYPE'] = $request['AWB_TYPE'];
        $fd['CUST_ID'] = $request['CUST_ID'];
        $fd['BRANCH'] = $request['BRANCH'];
        $fd['COD_FLAG'] = $request['COD_FLAG'];
        $fd['COD_AMOUNT'] = $request['COD_AMOUNT'];
        $fd['SPECIAL_INS'] = $request['SPECIAL_INS'];

        $data['status'] = 200;
        $data['message'] = 'Berhasil';

        $seme_curl = new Seme_Curl();
        $response = $seme_curl->post($this->url . 'job/direct', $fd);
        if (!isset($response->header->http_code) && $response->header->http_code != 200) {
            $data['status'] = 500;
            $data['message'] = "Access Denied";
            return $data;
        }

        $data['fd'] = $fd;

        $data['url'] = $this->url . 'job/direct';
        $data['request'] = $fd;
        $data['head'] = $response->header;
        $data['data'] = $response->body;
        return $data;
    }

    /**
     * Menghitung Tarif
     */
    public function calculate_tarif($from = "", $thru = "", $weight = "")
    {
        $data = array();
        if (strlen($from) < 1) {
            $data['status'] = 402;
            $data['message'] = 'ORIGIN Code (kode asal) belum diisi';
            return $data;
            die();
        }

        if (strlen($thru) < 1) {
            $data['status'] = 402;
            $data['message'] = 'DESTINATION Code (kode tujuan) belum diisi';
            return $data;
            die();
        }

        if (strlen($weight) < 1) {
            $data['status'] = 402;
            $data['message'] = 'Berat belum diisi';
            return $data;
            die();
        }

        if ($this->username == $this->sandbox_username) {
            $from = 'CGK10000';
            $thru = 'BDO10000';
        }

        $fd = array();
        $fd['username'] = $this->username;
        $fd['api_key'] = $this->api_key;
        $fd['from'] = $from;
        $fd['thru'] = $thru;
        $fd['weight'] = $weight;

        $data['status'] = 200;
        $data['message'] = "berhasil";

        $seme_curl = new Seme_Curl();
        $response = $seme_curl->post($this->url . 'tracing/api/pricedev', $fd);
        if (isset($response->header->http_code) && $response->header->http_code != 200) {
            $data['status'] = 500;
            $data['message'] = "Access Denied";
            return $data;
        }
        $data['data'] = $response->body;

        return $data;
    }

    /**
     * Tracking
     */
    public function tracking($resi = '')
    {

        $data = array();
        if (!strlen($resi)) {
            $data['status'] = 400;
            $data['message'] = 'NO RESI tidak ada';
            return $data;
            die();
        }

        $data['status'] = 200;
        $data['message'] = 'Berhasil';
        $fd = array();
        $fd['username'] = $this->username;
        $fd['api_key'] = $this->api_key;

        $seme_curl = new Seme_Curl();
        $response = $seme_curl->post($this->url . 'tracing/api/list/v1/cnote/' . $resi, $fd);
        if (!isset($response->header->http_code) && $response->header->http_code != 200) {
            $data['status'] = 500;
            $data['message'] = "Access Denied";
            return $data;
        }

        $data['url'] = $this->url . 'tracing/api/list/v1/cnote/' . $resi;
        $data['head'] = $response->header;
        $data['data'] = $response->body;
        return $data;
    }

    /**
     * Get Destination
     */
    public function get_destination()
    {

        $data = array();

        $data['status'] = 200;
        $data['message'] = 'Berhasil';
        $fd = array();
        $fd['username'] = $this->username;
        $fd['api_key'] = $this->api_key;

        $seme_curl = new Seme_Curl();
        $response = $seme_curl->post($this->url . 'insert/getdestination', $fd);
        if (!isset($response->header->http_code) && $response->header->http_code != 200) {
            $data['status'] = 500;
            $data['message'] = "Access Denied";
            return $data;
        }

        $data['url'] = $this->url . 'insert/getdestination/';
        $data['head'] = $response->header;
        $data['data'] = $response->body;
        return $data;
    }

    /**
     * Get Origin
     */
    public function get_origin()
    {

        $data = array();

        $data['status'] = 200;
        $data['message'] = 'Berhasil';
        $fd = array();
        $fd['username'] = $this->username;
        $fd['api_key'] = $this->api_key;

        $seme_curl = new Seme_Curl();
        $response = $seme_curl->post($this->url . 'insert/getorigin', $fd);
        if (!isset($response->header->http_code) && $response->header->http_code != 200) {
            $data['status'] = 500;
            $data['message'] = "Access Denied";
            return $data;
        }

        $data['url'] = $this->url . 'insert/getorigin/';
        $data['head'] = $response->header;
        $data['data'] = $response->body;
        return $data;
    }
}
