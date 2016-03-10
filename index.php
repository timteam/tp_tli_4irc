<?php
include 'lib/class/BaseDonnee.php';
define('SMARTY_DIR', 'smarty/libs/');
require_once(SMARTY_DIR . 'Smarty.class.php');
$smarty = new Smarty();

$smarty->template_dir = 'templates/';
$smarty->compile_dir = 'templates_c/';
$smarty->config_dir = 'configs/';
$smarty->cache_dir = 'cache/';

if(!empty($_GET)){
    $firstKey = array_keys($_GET);
    include "lib/class/$firstKey[0].php";
}else{
   $smarty->display('index.tpl');
} 
