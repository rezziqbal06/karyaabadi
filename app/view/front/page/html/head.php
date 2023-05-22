	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<title><?=$this->getTitle()?></title>

		<meta name="description" content="<?=$this->getDescription()?>">
		<meta name="keyword" content="<?=$this->getKeyword()?>"/>
		<meta name="author" content="<?=$this->getAuthor()?>">
		<meta name="robots" content="<?=$this->getRobots()?>" />

		<!-- Icons -->
		<!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
		<link rel="apple-touch-icon" sizes="180x180" href="<?=base_url()?>/skin/front/icon/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?=base_url()?>/skin/front/icon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>/skin/front/icon/favicon-16x16.png">
		<link rel="manifest" href="<?=base_url()?>/skin/front/icon/site.webmanifest">
		<link rel="mask-icon" href="<?=base_url()?>/skin/front/icon/safari-pinned-tab.svg" color="#5bbad5">
		<link rel="shortcut icon" href="<?=base_url()?>/skin/front/icon/favicon.ico">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="msapplication-config" content="<?=base_url()?>/skin/front/icon/browserconfig.xml">
		<meta name="theme-color" content="#ffffff">
		<!-- END Icons -->

		<!-- Stylesheets -->
		<!-- END Stylesheets -->

		<?php $this->getAdditionalBefore()?>
		<?php $this->getAdditional()?>
		<?php $this->getAdditionalAfter()?>

		<!-- Modernizr (browser feature detection library) -->
		<script src="<?=$this->cdn_url("skin/admin/")?>js/vendor/modernizr.min.js"></script>

	</head>
