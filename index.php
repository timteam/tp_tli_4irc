<?php

define('SMARTY_DIR', 'smarty/libs/');
require_once(SMARTY_DIR . 'Smarty.class.php');
$smarty = new Smarty();

$smarty->template_dir = 'templates/';
$smarty->compile_dir = 'templates_c/';
$smarty->config_dir = 'configs/';
$smarty->cache_dir = 'cache/';

if (!empty($_GET)) {
    include "lib/class/Controller.php";
    //parameters["action"] must contain the controller Action
    $controller = new Controller();
    $action = $_GET["action"];
    if (is_callable(array($controller, $action."Action"))) {
        
        $controller->{$action . "Action"}($_GET);
    } else {
        echo "error in url";
    }
    
} else {
   $smarty->assign('argument','');
   $smarty->assign('module','index.tpl');
   $smarty->display('site.tpl');
}
?>
