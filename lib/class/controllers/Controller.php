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
abstract class Controller {

    private $smarty;
    private $requestContentType;
    private $requestParametres;
    private $urlParametres;

    public function __construct($requestContentType, $parametres) {
        if ($requestContentType == 'text/html') {
            $this->initializeSmarty();
        }
        $this->requestContentType = $requestContentType;
        //Si même clé dans $getParametres et $postParametres
        //paramètre post écrase paramètre get
        $this->requestParametres = $parametres;
    }

    /**
     * Initialise le template
     */
    private function initializeSmarty() {
        require_once(SMARTY_DIR . 'Smarty.class.php');
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
    protected function executeMethod($methodDAO, $template) {
            $this->smarty->assign('argument', $methodDAO);
            $this->smarty->assign('module', $template);
            $this->smarty->display('site.tpl');
    }
    
    function getSmarty() {
        return $this->smarty;
    }

    function getRequestContentType() {
        return $this->requestContentType;
    }
    function getRequestParametres() {
        return $this->requestParametres;
    }

    function getUrlParametres() {
        return $this->urlParametres;
    }
}
