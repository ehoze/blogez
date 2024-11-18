<?php 
$domainURL = 'http://';
$domainURL .= $_SERVER['HTTP_HOST'];
// $domainURL = $_SERVER['SERVER_NAME'];
$domainURL .= '/blogez2/';
$text = <<<EOT
<link rel="stylesheet" href="{$domainURL}public/assets/boot/css/bootstrap.css">
<link rel="stylesheet" href="{$domainURL}public/assets/boot/css/bootstrap.css.map">
<link rel="stylesheet" href="{$domainURL}public/assets/boot/css/bootstrap.min.css">
<link rel="stylesheet" href="{$domainURL}public/assets/boot/css/bootstrap.min.css.map">


<script src="{$domainURL}public/assets/boot/js/bootstrap.js"></script>
<script src="{$domainURL}public/assets/boot/js/bootstrap.js.map"></script>
<script src="{$domainURL}public/assets/boot/js/bootstrap.min.js"></script>
<script src="{$domainURL}public/assets/boot/js/bootstrap.min.js.map"></script>
EOT;
echo $text;


// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-grid.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-grid.css.map">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-grid.min.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-grid.min.css.map">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-grid.rtl.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-grid.rtl.css.map">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-grid.rtl.min.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-grid.rtl.min.css.map">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-reboot.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-reboot.css.map">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-reboot.min.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-reboot.min.css.map">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-reboot.rtl.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-reboot.rtl.css.map">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-reboot.rtl.min.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-reboot.rtl.min.css.map">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-utilities.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-utilities.css.map">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-utilities.min.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-utilities.min.css.map">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-utilities.rtl.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-utilities.rtl.css.map">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-utilities.rtl.min.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap-utilities.rtl.min.css.map">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap.css.map">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap.min.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap.min.css.map">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap.rtl.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap.rtl.css.map">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap.rtl.min.css">
// <link rel="stylesheet" href="{$domainURL}assets/boot/css/bootstrap.rtl.min.css.map">
// <script src="{$domainURL}assets/boot/js/bootstrap.bundle.js"></script>
// <script src="{$domainURL}assets/boot/js/bootstrap.bundle.js.map"></script>
// <script src="{$domainURL}assets/boot/js/bootstrap.bundle.min.js"></script>
// <script src="{$domainURL}assets/boot/js/bootstrap.bundle.min.js.map"></script>
// <script src="{$domainURL}assets/boot/js/bootstrap.esm.js"></script>
// <script src="{$domainURL}assets/boot/js/bootstrap.esm.js.map"></script>
// <script src="{$domainURL}assets/boot/js/bootstrap.esm.min.js"></script>
// <script src="{$domainURL}assets/boot/js/bootstrap.esm.min.js.map"></script>
// <script src="{$domainURL}assets/boot/js/bootstrap.js"></script>
// <script src="{$domainURL}assets/boot/js/bootstrap.js.map"></script>
// <script src="{$domainURL}assets/boot/js/bootstrap.min.js"></script>
// <script src="{$domainURL}assets/boot/js/bootstrap.min.js.map"></script>