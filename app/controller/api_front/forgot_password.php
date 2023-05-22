<?php
namespace API\Front;

register_namespace(__NAMESPACE__);

/**
 * Define all general method(s) and constant(s) for b_user table,
 *   can be inherited a Concern class also can be reffered as class constants
 *
 * @version 1.0.0
 *
 * @package API\Front
 * @since 1.0.0
 */
class Forgot_Password extends \JI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->lib("seme_log");
    $this->lib('seme_email');
    $this->lib('seme_email/forgot_password', '', 'inc');

    $this->load("a_company_concern");
    $this->load("api_front/a_company_model", 'acm');
    $this->load("b_user_concern");
    $this->load("api_front/b_user_model", 'bum');
  }

  /**
   * Generate new link for reset password link
   *
   * @param  int $user_id               ID from `b_user` table
   *
   * @return string         Reset password url token with base url
   */
  private function generateLink($user_id)
  {
      $this->lib("conumtext");
      $token = $this->conumtext->genRand($type="str", $min=18, $max=24);
      $this->bum->setToken($user_id, $token, $kind="api_web");

      return base_url('account/password/reset/'.$token);
  }

  private function preparedData($user)
  {
      $data = new \stdClass();
      $data->nama = $user->fnama.' ';
      $data->email = $user->email;
      $data->link_href = $this->generateLink($user->id);
      $data->link_text = $data->link_href;

      return $data;
  }

  public function index()
  {
    $dt = $this->__init();

    //default result
    $data = array();
    $data['apisess'] = '';
    $data['user'] = new \stdClass();

    //check apikey
    $apikey = $this->input->get('apikey');
    $current_reseller = $this->current_reseller_api();

    //check email
    $email = $this->input->post("email", '');
    if ( strlen($email) <= 6 ) {
        $this->status = 1718;
        $this->message = API_ADMIN_ERROR_CODES[$this->status];
        $this->__json_out($data);
        die();
    }

    $bum = $this->bum->email($email);
    if (!isset($bum->id)) {
        $this->status = 1719;
        $this->message = API_ADMIN_ERROR_CODES[$this->status];
        $this->__json_out($data);
        die();
    }

    $this->status = 200;
    $prepared_email = new \Authentication\Library\Forgot_Password(
        $this->config,
        $current_reseller,
        $this->seme_email,
        $this->preparedData($bum)
    );

    $this->message = 'Success, please check your email if you are registered';
    if ($this->config_semevar('send_email', false)) {
        $prepared_email->send();
        $this->message = 'Success, please check your email if you are registered';
    }

    $this->__json_out($data);
  }
}
