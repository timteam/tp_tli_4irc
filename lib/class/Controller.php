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
require_once(SMARTY_DIR . 'Smarty.class.php');

include "DAO/PathologieDAO.php";

class Controller {

    private $DAO;
    private $smarty;
    
    //put your code here
    public function pathosAction() {
        
        $this->DAO = new PathologieDAO();
        $this->initialize();
        $this->executeMethod($this->DAO->selectAllWithMeridien(),'pathologie.tpl');
    }
    
    /**
     * Initialise le template
     */
    private function initialize(){
        $this->smarty = new Smarty();
        $this->smarty->template_dir = 'templates/';
        $this->smarty->compile_dir = 'templates_c/';
        $this->smarty->config_dir = 'configs/';
        $this->smarty->cache_dir = 'cache/';
    }
    /**
     * Execute la méthode choisit
     * @param type $methodDAO =  
     */
    private function executeMethod($methodDAO,$template){
        $this->smarty->assign('argument', $methodDAO);
        $this->smarty->assign('module', $template);
        $this->smarty->display('site.tpl');
    }

}
