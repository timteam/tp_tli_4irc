<?php
define('NB_MINUTES', '30');

debug();
verifyTimeout();
require_once 'lib/class/restafari.php';
require_once 'lib/class/routifari.php';

initSmarty();

//We get the HTTP request Method and the HTTP request Content
$requestContentType = restafari::getContentType();
$requestMethod = restafari::getRequestMethod();

try {
    //Les paramètres Get et post étant mergés pour plus de simplicité dans les controllers ($requestParameters),
    //Si un paramètre Post a la même clé qu'un paramètre Get,
    //Le paramètre Post écrase le paramètre Get
    $safeParams = safeParametres($_REQUEST);
    $routafari = new routifari();
    $routafari->launch($requestContentType, $requestMethod, $safeParams['request_url'], $safeParams);
} catch (Exception $exc) {
    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir = 'templates_c/';
    $smarty->config_dir = 'configs/';
    $smarty->cache_dir = 'cache/';
    $smarty->smarty->getassign('argument', $methodDAO);
    $smarty->smarty->assign('module', $template);
    $smarty->smarty->display('site.tpl');
}

function debug() {
    //print_r($_GET);
    //print_r($_POST);
    //print_r($_SERVER);
    //print_r($_REQUEST);
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

function initSmarty() {
    define('SMARTY_DIR', 'smarty/libs/');
    require_once(SMARTY_DIR . 'Smarty.class.php');
}

//Vient prévenir les injections SQL
//Même si avec PDO normalement, pas besoin
function safeParametres($array){
//    $return = array();
//    foreach ($array as $key => $value) {
//        $return[$key] = mysql_real_escape_string($value);
//    }
//    return $return;
    return $array;
}



function verifyTimeout(){
    session_start();
    
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > NB_MINUTES*60)) {
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
}
