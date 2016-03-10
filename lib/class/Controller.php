<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author timotheetroncy
 */
class Controller {
    //put your code here
    public function pathosAction(){
        
        include "DAO/PathologieDAO.php";
        $DAO = new PathologieDAO();
        
        
require_once(SMARTY_DIR . 'Smarty.class.php');
$smarty = new Smarty();

$smarty->template_dir = 'templates/';
$smarty->compile_dir = 'templates_c/';
$smarty->config_dir = 'configs/';
$smarty->cache_dir = 'cache/';
        
        $smarty->assign('argument',$DAO->selectAll());
        $smarty->assign('module','pathologie.tpl');
        $smarty->display('site.tpl');
    }
}
