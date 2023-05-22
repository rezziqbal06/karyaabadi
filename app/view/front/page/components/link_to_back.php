<?php
/**
 * Prerequisited:
 * - in a controller class, make sure the $this->current_page are defined and contain within format: PARENTNAME_MODULENAME
 * 
 * Usage:
 * - on view, call this component by executing $this->getThemeElement('page/components/link_to_back') 
 */
$link_to_page = (isset($this->current_page) && strlen($this->current_page)) ? str_replace('_', '/', $this->current_page) : '';
?>
<a id="aback" href="<?=base_url_admin($link_to_page)?>" class="btn btn-default">
    <i class="fa fa-chevron-left"></i>
    Kembali
</a>