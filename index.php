<?php

//debug();


require_once 'restafari.php';
require_once 'routifari.php';

$requestContentType = restafari::getContentType();
$requestMethod = restafari::getRequestMethod();

initSmarty();

try {
    $routafari = new routifari();
    $requestUrl = $_GET['request_url'];
    $routafari->launch($requestContentType, $requestMethod, $requestUrl);
} catch (Exception $exc) {
    echo '404, page introuvable: '.$exc->getMessage();
    //echo $exc->getTraceAsString();
    //devrait afficher 404 avec message associé;
    //$smarty->assign('argument', '');
    //$smarty->assign('module', 'index.tpl');
    //$smarty->display('site.tpl');
}

function debug() {
    print_r($_GET);
    print_r($_POST);
    print_r($_SERVER);
    print_r($_REQUEST);
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

function initSmarty() {
    define('SMARTY_DIR', 'smarty/libs/');
    require_once(SMARTY_DIR . 'Smarty.class.php');
    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir = 'templates_c/';
    $smarty->config_dir = 'configs/';
    $smarty->cache_dir = 'cache/';
}
