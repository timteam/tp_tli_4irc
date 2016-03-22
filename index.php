<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$php_self = $_SERVER['PHP_SELF'];
$array = explode("index.php", $php_self);
define('ROOT_PATH', $array[0]);

define('SMARTY_DIR', 'smarty/libs/');
require_once(SMARTY_DIR . 'Smarty.class.php');
$smarty = new Smarty();

$smarty->template_dir = 'templates/';
$smarty->compile_dir = 'templates_c/';
$smarty->config_dir = 'configs/';
$smarty->cache_dir = 'cache/';

if (!empty($_GET) && isset($_GET["action"])) {
    include "lib/class/Controller.php";
    //parameters["action"] must contain the controller Action
    $controller = new Controller();
    $action = $_GET["action"];
    if (is_callable(array($controller, $action."Action"))) {
        
        $controller->{$action . "Action"}("Antoine", "mdp", "test@test.com");
    } else {
        echo "error in url";
    }
    
} else {
   $smarty->assign('argument','');
   $smarty->assign('module','index.tpl');
   $smarty->display('site.tpl');
}
?>
