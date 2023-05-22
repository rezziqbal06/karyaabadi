<?php
namespace Authentication\Library;

register_namespace(__NAMESPACE__);
/**
* Define forgot password email in a library
*
* @version 1.0.0
*
* @package Authentication\Library
* @since 1.0.0
*/
class Forgot_Password
{
    private $subject = 'Lupa Password';
    private $site_email;
    private $data;

    public function __construct($config, $reseller, $seme_email, $data)
    {
        $this->config = $config;
        $this->reseller = $reseller;
        $this->seme_email = $seme_email;
        $this->data = $data;

        $this->initialize();
    }

    private function initialize()
    {
        $this->initialize_site_name();
        $this->initialize_email();

        return $this;
    }

    private function initialize_site_name()
    {
        $this->site_name = 'Example Site';
        if (isset($this->reseller->nama) && strlen($this->reseller->nama)) {
            $this->site_name = $this->reseller->nama;
        } elseif (isset($this->config->semevar->site_name)) {
            $this->site_name = $this->config->semevar->site_name;
        }

        return $this;
    }

    private function initialize_email()
    {
        $this->site_email = 'noreply@example.com';
        if (isset($this->reseller->email) && strlen($this->reseller->email) > 4) {
            $this->site_email = $this->reseller->email;
        } elseif (isset($this->config->semevar->site_email)) {
            $this->site_email = $this->config->semevar->site_email;
        }


        $this->site_replyto = 'reply@example.com';
        if (isset($this->reseller->email) && strlen($this->reseller->email) > 4) {
            $this->site_replyto = $this->reseller->email;
        } elseif (isset($this->config->semevar->site_replyto)) {
            $this->site_replyto = $this->config->semevar->site_replyto;
        }

        return $this;
    }

    private function replacer()
    {
        $replacer = array();
        $replacer['email'] = $this->data->email;
        $replacer['nama'] = $this->data->nama;
        $replacer['link_href'] = $this->data->link_href;
        $replacer['link_text'] = $this->data->link_text;
        $replacer['site_name'] = $this->site_name;

        return $replacer;
    }

    /**
     * Trigger send email
     *
     * @return boolean  Return true if success, otherwise false
     */
    public function send()
    {
        $this->seme_email->flush();
        $this->seme_email->replyto($this->site_name, $this->site_replyto);
        $this->seme_email->from($this->site_email, $this->site_name);
        $this->seme_email->subject($this->subject.' - '.$this->site_name);
        $this->seme_email->to($this->data->email, $this->data->nama);
        $this->seme_email->template('forgot_password');
        $this->seme_email->replacer($this->replacer());

        return $this->seme_email->send();
    }
}
