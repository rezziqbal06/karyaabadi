<style>
.fa-stack {
    width: 1em;
    height: 1em;
    line-height: 1;
    vertical-align: top;
}
.fa-stack-td {
    position: absolute;
    top: 0;
    width: 100%;
    text-align: center;
    color: grey;
    font-size: 1.25em;
}
.fa-stack-tr {
    position: absolute;
    top: 0;
    width: 100%;
    text-align: right;
    font-size: 0.8em;
}
</style>
<?php
/**
 * Prerequisited:
 * - in a controller class, make sure the $this->current_page are defined and contain within format: PARENTNAME_MODULENAME
 * 
 * Usage:
 * - on view, call this component by executing $this->getThemeElement('page/components/link_to_baru') 
 */
$link_to_page = (isset($this->current_page) && strlen($this->current_page)) ? str_replace('_', '/', $this->current_page).'/baru' : '';
?>
<a href="<?=base_url_admin($link_to_page)?>" class="btn btn-default">
    <span class="fa-stack">
        <i class="fa fa-file-text-o fa-stack-td"></i>
        <i class="fa fa-plus fa-stack-tr text-success"></i>
    </span>
    Baru
</a>