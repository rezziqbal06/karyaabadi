<?php
class Migrate extends JI_Controller
{
    private $module_name = 'Migrate';

    public function __construct()
    {
        parent::__construct();
        $this->load('schema_model', 's');
    }

    public function index()
    {
        $this->cli->print_command_title($this->module_name);
        $this->cli->print_command_item('migrate', 'create', 'Generates new data migration file on db/migration/*.json');
        $this->cli->print_command_item('migrate', 'current', 'Current database migration');
    }

    public function sql()
    {
        $schema_file = SEMEROOT.DS.'sql/'.$this->config->database->name.'-'.$this->config->environment.'.sql';

        $content = '';
        $content .= 'SET FOREIGN_KEY_CHECKS=0;'."\r\n";
        $content .= 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";'."\r\n";
        $content .= 'SET time_zone = "+00:00";'."\r\n";

        foreach ($this->s->tables() as $table_name) {
            $table_name = strtolower($table_name);
            $content .= 'DROP TABLE IF EXISTS '.$table_name.';'."\r\n";
            foreach ($this->s->showCreateTable($table_name) as $row) {
                $content .= $row->{'Create Table'}.";\n\n";
            }
        }
        $content .= 'SET FOREIGN_KEY_CHECKS=1;'."\r\n";
        $this->_file_write($schema_file, $content);

        $this->cli->print_success('Saved at '.$this->cli->file_location($schema_file));
    }

    public function schema()
    {
        $cdate = date('ymdHis');
        $ldate = $cdate;
        $migrate_content = new stdClass();
        $migrate_content->cdate = $cdate;
        $migrate_content->ldate = $ldate;
        $migrate_content->tables = new stdClass();

        $schema_file = SEMEROOT.DS.$this->schema_file;
        $migrate_existing = $this->_file_check($schema_file, json_encode($migrate_content, JSON_PRETTY_PRINT));
        $migrate_existing = json_encode($migrate_existing, JSON_PRETTY_PRINT);

        if (isset($migrate_existing->cdate)) {
            $migrate_content->cdate = $migrate_existing->cdate;
        }

        $tables = $this->s->tables();
        foreach ($tables as $table_name) {
            $table_name = strtolower($table_name);
            if ($table_name == $this->migrate_table) {
                continue;
            }
            if (!isset($migrate_content->tables->{$table_name})) {
                $migrate_content->tables->{$table_name} = new stdClass();
            }
            if (!isset($migrate_content->tables->{$table_name}->columns)) {
                $migrate_content->tables->{$table_name}->columns = new stdClass();
            }
            if (!isset($migrate_content->tables->{$table_name}->indexes)) {
                $migrate_content->tables->{$table_name}->indexes = new stdClass();
            }
            if (!isset($migrate_content->tables->{$table_name}->relations)) {
                $migrate_content->tables->{$table_name}->relations = new stdClass();
            }

            $table_defs = $this->s->describeTable($table_name);
            foreach ($table_defs as $def) {
                $name = strtolower($def->Field);
                if (!isset($migrate_content->tables->{$table_name}->columns->{$name})) {
                    $migrate_content->tables->{$table_name}->columns->{$name} = new stdClass();
                }
                $migrate_content->tables->{$table_name}->columns->{$name}->name = $def->Field;
                $migrate_content->tables->{$table_name}->columns->{$name}->type = $def->Type;
                $migrate_content->tables->{$table_name}->columns->{$name}->length = '';
                $migrate_content->tables->{$table_name}->columns->{$name}->value = array();
                $migrate_content->tables->{$table_name}->columns->{$name}->is_null = (strtolower($def->Null) == 'no') ? false : true;
                $migrate_content->tables->{$table_name}->columns->{$name}->default_value = $def->Default;
                $migrate_content->tables->{$table_name}->columns->{$name}->is_index = false;

                $type = $this->__parseType($def->Type);
                if (isset($type->type)) {
                    if ($type->type == 'enum') {
                        $migrate_content->tables->{$table_name}->columns->{$name}->type = $type->type;
                        $migrate_content->tables->{$table_name}->columns->{$name}->value = $type->values;
                        $migrate_content->tables->{$table_name}->columns->{$name}->length = $type->length;
                    } elseif ($type->type == 'int') {
                        $migrate_content->tables->{$table_name}->columns->{$name}->type = $type->type;
                        $migrate_content->tables->{$table_name}->columns->{$name}->value = $type->values;
                        $migrate_content->tables->{$table_name}->columns->{$name}->length = $type->length;
                        $migrate_content->tables->{$table_name}->columns->{$name}->is_unsigned = (stripos($def->Type, "unsigned") !== false) ? true : false;
                        $migrate_content->tables->{$table_name}->columns->{$name}->is_zerofill = (stripos($def->Type, "zerofill") !== false) ? true : false;
                    } elseif ($type->type == 'string') {
                        $migrate_content->tables->{$table_name}->columns->{$name}->type = $type->type;
                        $migrate_content->tables->{$table_name}->columns->{$name}->length = $type->length;
                        unset($migrate_content->tables->{$table_name}->columns->{$name}->value);
                    } elseif ($type->type == 'timestamp') {
                        $migrate_content->tables->{$table_name}->columns->{$name}->type = $type->type;
                        $migrate_content->tables->{$table_name}->columns->{$name}->on_update = (stripos($def->Extra, "on update") !== false) ? 'current_timestamp()' : false;
                        if (!$migrate_content->tables->{$table_name}->columns->{$name}->on_update) {
                            unset($migrate_content->tables->{$table_name}->columns->{$name}->on_update);
                        }
                        unset($migrate_content->tables->{$table_name}->columns->{$name}->length);
                        unset($migrate_content->tables->{$table_name}->columns->{$name}->value);
                    }
                }

                if (isset($def->Key)) {
                    $migrate_content->tables->{$table_name}->columns->{$name}->is_index = false;
                    if ($def->Key == 'PRI') {
                        $migrate_content->tables->{$table_name}->columns->{$name}->is_index = true;
                        $migrate_content->tables->{$table_name}->columns->{$name}->is_primary = true;
                        $migrate_content->tables->{$table_name}->columns->{$name}->is_auto_increment = (stripos($def->Extra, "auto_increment") !== false) ? true : false;
                    } elseif ($def->Key == 'MUL') {
                        unset($migrate_content->tables->{$table_name}->columns->{$name}->is_primary);
                        unset($migrate_content->tables->{$table_name}->columns->{$name}->is_auto_increment);
                        $migrate_content->tables->{$table_name}->columns->{$name}->is_index = true;
                    } else {
                        unset($migrate_content->tables->{$table_name}->columns->{$name}->is_primary);
                        unset($migrate_content->tables->{$table_name}->columns->{$name}->is_auto_increment);
                        unset($migrate_content->tables->{$table_name}->columns->{$name}->is_index);
                    }
                }
            }
        }
        $this->_file_write($schema_file, json_encode($migrate_content, JSON_PRETTY_PRINT));
        $this->cli->print_success('Saved at '.$this->cli->file_location($schema_file));
    }
}
