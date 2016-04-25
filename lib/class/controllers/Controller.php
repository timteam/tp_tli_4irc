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

    public function __construct($requestContentType, $parametres, $urlParams) {
        if ($requestContentType == 'text/html') {
            $this->initializeSmarty();
        }
        $this->requestContentType = $requestContentType;
        //Si même clé dans $getParametres et $postParametres
        //paramètre post écrase paramètre get
        $this->requestParametres = $parametres;
        $this->urlParametres = $urlParams;
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
            //$_SESSION['user']
            if(isset($_SESSION['user'])){
                $this->smarty->assign('user', $_SESSION['user']);
            }  else {
                $this->smarty->assign('user',false);
            }
            $php_self = $_SERVER['PHP_SELF'];
            $array = explode("index.php", $php_self);
            $this->smarty->assign('route', $array[0]);
            $this->smarty->assign('argument', $methodDAO);
            $this->smarty->assign('module', $template);
            $this->smarty->display('site.tpl');
    }
    
    protected function getSmarty() {
        return $this->smarty;
    }

    protected function getRequestContentType() {
        return $this->requestContentType;
    }
    protected function getRequestParametres() {
        return $this->requestParametres;
    }
    protected function getUrlParametres() {
        return $this->urlParametres;
    }
}
