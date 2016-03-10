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
        
        $smarty->assign('argument',$DAO->selectAll());
        $smarty->assign('module','pathologie.tpl');
        $smarty->display('site.tpl');
    }
}
