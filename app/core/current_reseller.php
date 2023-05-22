<?php
/**
 * Generic class for logo file object
 *
 * @version 1.0.0
 *
 * @package ResellerDomain\Generic
 * @since 1.0.0
 */
class Current_Reseller_Logo {
    public $height;
    public $width;
    public $path;

    public function __construct($path, $height=0, $width=0)
    {
        $this->path = $path;
        $this->height = $height;
        $this->width = $width;
    }
}

/**
 * Generic class for current reseller
 *
 * @version 1.0.0
 *
 * @package ResellerDomain\Generic
 * @since 1.0.0
 */
#[AllowDynamicProperties]
class Current_Reseller {
    private $config;

    public function __construct($current_reseller_data, $seme_framework_config)
    {
        $this->config = $seme_framework_config;
        foreach ($current_reseller_data as $k => $v) {
            $this->{$k} = $v;
        }
    }

    public function logo()
    {
        if (isset($this->logo_panjang) && strlen($this->logo_panjang) > 4) {
            return new \Current_Reseller_Logo($this->logo_panjang);
        } else {
            return new \Current_Reseller_Logo($this->config->semevar->site_logo->path);
        }
    }
}
