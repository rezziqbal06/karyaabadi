<?php
class Booking extends JI_Controller
{
    public $is_log = 1;
    public function __construct()
    {
        parent::__construct();
        $this->lib('seme_log');
        $this->lib("jne");
        $this->load('c_order_concern');
        $this->load('cron/c_order_model', 'com');
    }

    public function _tracking($no_resi = "")
    {
        $kode_tracking = false;
        $data = [];
        if (!strlen($no_resi)) {
            return $kode_tracking;
        }
        $this->jne->set_type('live');
        $res = $this->jne->tracking($no_resi);
        if ($res['status'] == 200) {
            $body = json_decode($res['data']);
            if (isset($body->detail)) {
                $data = $body;
                if (isset($data->history)) {
                    $data->history = array_reverse($data->history);
                    $kode_tracking = $data->history[0]->code ?? false;
                }
            } else {
            }
        } else {
        }
        return $kode_tracking;
    }

    public function update_kode()
    {
        $bookings = [];
        $now = date("Y-m-d");
        $data = $this->com->getBookings($now, 50);
        if (count($data)) {
            foreach ($data as $k => $v) {
                $kode_tracking = $this->_tracking($v->no_resi);
                if ($kode_tracking) {
                    $res = $this->com->update($v->id, ['kode_tracking' => $kode_tracking, 'udate' => $now]);
                    if ($res) {
                        if ($this->is_log) $this->seme_log->write('cron/booking::update_kode -- berhasil update ID: ' . $v->id . ' KODE: ' . $kode_tracking);
                    } else {
                        if ($this->is_log) $this->seme_log->write('cron/booking::update_kode -- gagal update ID: ' . $v->id . ' KODE: ' . $kode_tracking);
                    }
                } else {
                    if ($this->is_log) $this->seme_log->write('cron/booking::update_kode -- kode tracking tidak ditemukan ID: ' . $v->id . ' KODE: ' . $kode_tracking ?? '-');
                }
            }
        } else {
            if ($this->is_log) $this->seme_log->write('cron/booking::update_kode -- tidak ada yang perlu diupdate');
        }
    }
}
