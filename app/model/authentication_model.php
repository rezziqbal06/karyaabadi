<?php
 /**
 * Data model wrapper for providing data authentication process
 *
 * @version 1.0.0
 *
 * @package Authentication\Model
 * @since 1.0.0
 */
class Authentication_Model extends JI_Model
{
    public $email = null;
    public $table = null;
    public $table_alias = null;
    public $password = null;
    public $encrypted_password = null;
    public $hash_method = PASSWORD_BCRYPT;
    private $allowed_regex = '/[^a-zA-Z0-9]/';

    const PASSWORD_TOKEN_MIN = 17;
    const PASSWORD_TOKEN_MAX = 24;


    /**
    * Authentication Model Class
    *  This class will provide some global requirement for
    *  - login
    *  - register
    *  - forgot
    * @param string $password  Plain password string
    */
    public function __construct($password=null, $table = 'b_user', $table_alias='aliased_table')
    {
        parent::__construct();
        $this->password = $password;
        $this->table = $table;
        $this->table_alias = $table_alias;
        $this->identifier = array("email");
        $this->conumtext = new Conumtext();
    }

    private function _setter($keyname, $value='')
    {
        if (!is_null($value) && strlen($value)) {
            $this->{$keyname} = $value;
        }

        return $this->{$keyname};
    }

    /**
     * Validate email string
     * @return boolean return true if valid otherwise false
     */
    private function validate_email()
    {
        if (!is_null($this->email)) {
            $this->email = filter_var($this->email, FILTER_VALIDATE_EMAIL);
        }
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * Run validation procedure
     * @return boolean True if all procedure is valid other wise is false;
     */
    public function validate()
    {
        if (!$this->validate_email()) {
            return false;
        }
        return true;
    }

    /**
     * Set or get plain password
     * @param  string $password               plain password string
     * @return string           current inserted plain password
     */
    public function password($password=null)
    {
        return $this->_setter('password', $password);
    }

    /**
     * Set or get current authentication table
     * @param  string $table               Table name *optional
     *
     * @return string           current authentication table
     */
    public function table($table=null)
    {
        return $this->_setter('table', $table);
    }

    /**
     * Set or get current email
     * @param  string $table               email *optional
     * @return string           current email
     */
    public function email($email=null)
    {
        return $this->_setter('email', $email);
    }

    /**
     * Set or get identifier string, separated by comma
     * @param  string $identifier_string               Table name *optional
     *
     * @return string           current string identifier to the current table table
     */
    public function identifier($identifier=null)
    {
        if (!is_null($identifier) && strlen($identifier)) {
            $exploded = explode(',', $identifier);
            if (is_array($exploded) && count($exploded)) {
                $exploded = array_map('trim', $exploded);
            } else {
                $identifier = trim($identifier);
            }

            $this->identifier = $exploded;
        }

        return $this->identifier;
    }

    /**
     * Sanitize string with given regex
     *
     * @return string Sanitized string from unwanted text
     */
    private function sanitize($string)
    {
        return preg_replace($this->allowed_regex, '', $string);
    }

    /**
     * Sanitize given password string
     *
     * @return object Current class object
     */
    private function password_sanitize()
    {
        if (!is_null($this->password)) {
            $this->password = $this->sanitize($this->password);
        }
        return $this;
    }

    /**
     * Convert current plain password string into hashed string
     *
     * @return Authentication_Model object
     */
    private function password_hash()
    {
        if (!is_null($this->password)) {
            $this->encrypted_password = password_hash($this->password, $this->hash_method);
        }
        return $this;
    }

    /**
     * Procedure to convert plain password into hashed password value
     *
     * @return Authentication_Model object
     */
    public function encrypted_password()
    {
        if (!is_null($this->password)) {
            $this->password_sanitize()->password_hash();
        }
        return $this->encrypted_password;
    }

    /**
    * Verify password string from inputted password
    *   with current inserted password
    * @param  string $password  Password string from database
    *
    * @return boolean           true if verified otherwise unverified
    */
    public function verify_password($password)
    {
        return password_verify($this->sanitize($password), $this->encrypted_password);
    }

    /**
     * Run table model initialization
     * @return Authentication_Model curren class object
     */
    public function initialize($table='', $table_alias='')
    {
        if (strlen($table)) {
            $this->_setter('table', $table);
        }

        if (strlen($table_alias)) {
            $this->_setter('table_alias', $table_alias);
        }

        $this->db->from($this->table, $this->table_alias);
        return $this;
    }

    public function data_update($du)
    {
        return $this->db->update($this->table.'` `'.$this->table_alias, $du);
    }

    private function identities($keyword)
    {
        foreach ($this->identifier as $identifier) {
            $this->db->where_as("$this->table_alias.$identifier", $this->db->esc($keyword));
        }
        return $this;
    }

    public function data($keyword='')
    {
        if (strlen($keyword) && is_array($this->identifier) && count($this->identifier)) {
            return $this->identities($keyword)->db->get_first();
        } else {
            return new stdClass();
        }
    }

    public function api_web_token($api_web_token='')
    {
        $strlen = strlen($api_web_token);
        // var_dump($strlen >= self::PASSWORD_TOKEN_MIN); die();
        // var_dump($strlen); die();
        // var_dump($strlen <= self::PASSWORD_TOKEN_MAX); die();
        if ($strlen >= self::PASSWORD_TOKEN_MIN && $strlen <= self::PASSWORD_TOKEN_MAX) {
            $data = $this->initialize()->db->where("api_web_token", $api_web_token)->get_first();
            if (isset($data->id)) {
                return $data;
            } else {
                return new stdClass();
            }
        } else {
            $du = array();
            $du['api_web_token'] = $this->conumtext->genRand("str", self::PASSWORD_TOKEN_MIN, self::PASSWORD_TOKEN_MAX);
            $this->initialize()->identities($this->email)->data_update($du);

            return $du['api_web_token'];
        }
    }

    public function after_reset_password($id)
    {
        $du = array();
        $du['api_web_token'] = 'null';
        $du['password'] = $this->encrypted_password();
        $this->initialize()->db->where("id", $id);
        return $this->data_update($du);
    }
}
