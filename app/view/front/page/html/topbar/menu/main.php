<?php
$user_name = '';
if (isset($sess->user->fnama)) if (strlen($sess->user->fnama) > 1) $user_name = $sess->user->fnama;
if (!isset($this->current_page)) $this->current_page = "";
if (!isset($this->current_parent)) $this->current_parent = "";
$current_page = $this->current_page;
$current_parent = $this->current_parent;
$parent = array();
foreach ($sess->user->menus->left as $key => $v) {
	$parent[$v->identifier] = 0;
	if (count($v->childs) > 0) {
		foreach ($v->childs as $f) {
			if ($current_page == $f->identifier) {
				$current_page = $v->identifier;
				$parent[$v->identifier] = 1;
			}
		}
	}
}
$user_foto = '';
if (isset($sess->user->foto)) $user_foto = $sess->user->foto;
if (empty($user_foto)) $user_foto = 'media/pengguna/default.png';
$user_foto = $this->cdn_url($user_foto);
?>
<?php foreach ($sess->user->menus->left as $key => $v) { ?>
    <?php $children_count = count($v->childs); ?>
    <?php if ($children_count > 0) { ?>
        <li class="dropdown">
            <a href="<?=$children_count > 0 ? 'javascript:void(0)' : '' ?>" class="<?=$children_count > 0 ? 'dropdown-toggle' : '' ?>" <?=$children_count > 0 ? 'data-toggle="dropdown"' : '' ?>>
                <?= $v->name; ?> <i class="fa fa-angle-down"></i>
            </a>
            <ul class="<?=$children_count > 0 ? 'dropdown-menu' : '' ?>">
                <?php foreach ($v->childs as $f) { ?>
                    <?php if ($f->utype == "external") { ?>
                        <li>
                            <a href="<?= $f->path; ?>" class="<?php if ($this->current_page == $f->identifier) echo 'active'; ?>">
                                <?= $f->name; ?>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li>
                            <a href="<?= base_url($f->path); ?>" class="<?php if ($this->current_page == $f->identifier) echo 'active'; ?>">
                                <?= $f->name; ?>
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </li>
    <?php } else { ?>
        <li class="<?php if ($current_page == $key) echo 'active'; ?>"><a href="<?= base_url($v->path); ?>" class="<?php if ($current_page == $key) echo 'active'; ?>"><i class="<?= $v->fa_icon; ?>"></i> <span><?= $v->name; ?></span></a></li>
    <?php } ?>
<?php } ?>
