<?php
$admin_foto = '';
if(isset($sess->admin->foto))$admin_foto = $sess->admin->foto;
if(empty($admin_foto)) $admin_foto = 'media/pengguna/default.png';
$admin_foto = base_url($admin_foto);
?>
<!-- User Dropdown -->
<li class="dropdown">
    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
        <img src="<?=$admin_foto?>" alt="avatar" onerror="this.null;this.src='<?=base_url('media/pengguna/default.png')?>';"> <i class="fa fa-angle-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
        <li class="">
            <h6><b><?=strtoupper($sess->user->fnama.' '.$sess->user->lnama)?></b></h6>
            <h6 class="text-muted"><?=$sess->user->utype?></h6>
        </li>
        <li>
            <a href="<?=base_url('profil')?>" title="Profil">
                <i class="fa fa-cogs fa-fw pull-right"></i>
                <b>Profil Saya</b></br>
                <small>Pengaturan &amp; Profil Karyawan</small>
            </a>
        </li>
        <li class="divider"></li>
        <li>
            <a href="<?=base_url('logout'); ?>"><i class="fa fa-ban fa-fw pull-right"></i> Logout</a>
        </li>
    </ul>
</li>
<!-- END User Dropdown -->
