<?php
/**
 * Source: https://stackoverflow.com/questions/34034730/how-to-enable-color-for-php-cli#answer-69580828
 */
class Cli_Output
{
    private $codes;
    private $format;
    public $formatted;
    private $order_num;
    const MAX_CHARACTERS_LENGTH = 80;

    public function __construct()
    {
        $this->format = [];
        $this->formatted = null;
        $this->init_codes();
        $this->order_num = 1;
    }

    private function init_codes()
    {
        $this->codes = [
            'bold'=>1,
            'italic'=>3, 'underline'=>4, 'strikethrough'=>9,
            'black'=>30, 'red'=>31, 'green'=>32, 'yellow'=>33,'blue'=>34, 'magenta'=>35, 'cyan'=>36, 'white'=>37,
            'blackbg'=>40, 'redbg'=>41, 'greenbg'=>42, 'yellowbg'=>44,'bluebg'=>44, 'magentabg'=>45, 'cyanbg'=>46, 'lightgreybg'=>47
          ];
        return $this;
    }

    public function pad($text='', $pad=80, $char=' ')
    {
        return str_pad($text, $pad, $char);
    }

    public function text($text='')
    {
        if (!is_null($this->formatted)) {
            $text = "\e[" . implode(';', $this->formatted) . 'm' . $text . "\e[0m";
        }

        return $text;
    }

    public function format(array $current_format=[], $text='')
    {
        if (is_array($current_format) && count($current_format)) {
            $this->current_format = $current_format;
        } else {
            $this->current_format = array();
        }
        $codes = $this->codes;
        $this->formatted = array_map(function ($v) use ($codes) { return $codes[$v]; }, $this->current_format);

        if (mb_strlen($text)) {
            return $this->text($text);
        } else {
            return $this;
        }
    }

    public function output($text, $last='')
    {
        echo $text. "$last";
    }

    public function print_main_command($description='List of available Seme CLI commands:')
    {
        $this->output($this->format([ 'green'], '🆂🅴🅼🅴🅲🅻🅸') , "\n");
        $this->output($this->format(['bold', 'magenta'], '𝐒𝐞𝐦𝐞 𝐅𝐫𝐚𝐦𝐞𝐰𝐨𝐫𝐤 '), "\n");
        $this->output(
            $this->format(['bold'], '   Command Line Interface (CLI)')
        , "\n");
        $this->output(
            $this->format([], $description)
        , "\n");
        $this->output($this->format(['red'], $this->pad('', self::MAX_CHARACTERS_LENGTH, '-')), "\n");
    }

    public function print_command_title($module_name)
    {
        $this->output(
            $this->pad(
                $this->format(['bold', 'blue'], $module_name).
                $this->format([], ' commands:')
            , 14)
        , "\n");
        $this->output($this->format(['red'], $this->pad('', self::MAX_CHARACTERS_LENGTH, '-')), "\n");
    }

    public function print_command_item($command_name, $params='', $description='')
    {
        $this->output($this->format([], $this->pad($this->order_num.'. ', 4)), "");
        $this->output($this->format(['bold', 'cyan'], $this->pad('seme ', 6)), "");

        if (strlen($params)) {
            $this->output($this->format(['yellow'], $this->pad($command_name.' ', 8)), "");
            $this->output($this->format(['green'], $this->pad($params.' ', 12)), "");
        } else {
            $this->output($this->format(['yellow'], $this->pad($command_name, 20)), "");
        }

        $this->output($this->format(['italic'], $this->pad($description, 40)), "\n");

        $this->order_num++;
    }

    public function print_success($description='')
    {
        $this->output(
            $this->pad(
                $this->format(['bold', 'green'], 'Success! ').
                $this->format([], $description)
            , 14)
        , "\n");
        $this->output(
            $this->format(
                ['italic', 'blue', 'lightgreybg'],
                str_pad(
                    ceil(microtime(true) - SEME_START).'s',
                    self::MAX_CHARACTERS_LENGTH, '.', STR_PAD_LEFT
                )
            )
        , "\n");
    }

    public function file_location($file_location)
    {
        $length_1 = strlen(SEMEROOT)+1;
        $length_2 = strlen($file_location) - $length_1;
        return $this->format(['yellow'], substr($file_location, $length_1,  $length_2));
    }
}
