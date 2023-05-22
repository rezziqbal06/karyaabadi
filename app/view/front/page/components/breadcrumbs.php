<?php
/**
 * Prerequisited:
 * - in a controller class, make sure the $this->current_page are defined and contain within format: PARENTNAME_MODULENAME
 * - for submodule, make sure the $this->current_submodule are defined and contain with string, e.g.: baru
 * 
 * Usage:
 * - on view, call this component by executing $this->getThemeElement('page/components/breadcrumbs') 
 */
$links = (isset($this->current_page) && strlen($this->current_page)) ? explode('_', $this->current_page) : array();
$link_to_page = (isset($this->current_page) && strlen($this->current_page)) ? str_replace('_', '/', $this->current_page) : '';
?>
<ul class="breadcrumb breadcrumb-top">
    <li>Admin</li>
    <?php if(isset($this->current_submodule) && strlen($this->current_submodule)){ ?>
        <?php $i=0; foreach($links as $link){ $i++;?>
            <?php if($i>1){ ?>
            <li><a href="<?=base_url_admin($link_to_page)?>"><?=ucfirst($link)?></a></li>
            <?php }else{ ?>
            <li><?=ucfirst($link)?></li>
            <?php } ?>
        <?php } ?>
        <li><?=ucfirst($this->current_submodule)?></li>
    <?php }else{ ?>
        <?php foreach($links as $link){ ?>
            <li><?=ucfirst($link)?></li>
        <?php } ?>
    <?php } ?>
</ul>