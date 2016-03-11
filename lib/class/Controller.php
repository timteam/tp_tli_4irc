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

class Controller {

    //put your code here
    public function pathosAction() {

        include "DAO/PathologieDAO.php";
        $DAO = new PathologieDAO();
        $smarty = new Smarty();
        $smarty->template_dir = 'templates/';
        $smarty->compile_dir = 'templates_c/';
        $smarty->config_dir = 'configs/';
        $smarty->cache_dir = 'cache/';

        $array = array();
        
        foreach ($DAO->selectAllWithMeridien() as $value) {
            $array[$value['nom']]['nom'] = $value['nom'];
            $array[$value['nom']]['desc'][] = $value['desc'];
        }
        
        //var_dump($array);
        
        $smarty->assign('argument', $array);
        $smarty->assign('module', 'pathologie.tpl');
        $smarty->display('site.tpl');
    }
    
    public function inscriptionAction() {

        include "DAO/UserDAO.php";
        $DAO = new UserDAO();
        $smarty = new Smarty();
        $smarty->template_dir = 'templates/';
        $smarty->compile_dir = 'templates_c/';
        $smarty->config_dir = 'configs/';
        $smarty->cache_dir = 'cache/';

        //var_dump($array);
        
        $smarty->display('inscription.tpl');
    }
    
    public function connexionAction() {

        include "DAO/UserDAO.php";
        $DAO = new UserDAO();
        $smarty = new Smarty();
        $smarty->template_dir = 'templates/';
        $smarty->compile_dir = 'templates_c/';
        $smarty->config_dir = 'configs/';
        $smarty->cache_dir = 'cache/';
        
        $smarty->display('connexion.tpl');
    }
    
    public function inscriptionValidatedAction($user, $password, $email) {

        include "DAO/UserDAO.php";
        $DAO = new UserDAO();
        $smarty = new Smarty();
        $smarty->template_dir = 'templates/';
        $smarty->compile_dir = 'templates_c/';
        $smarty->config_dir = 'configs/';
        $smarty->cache_dir = 'cache/';

        $array = $DAO->insertUser($user, $password, $email);
        
        //var_dump($array);
        
        $smarty->assign('argument', $array);
        $smarty->assign('module', 'pathologie.tpl');
        $smarty->display('site.tpl');
    }
    
    public function connexionValidatedAction($user, $password) {

        include "DAO/UserDAO.php";
        $DAO = new UserDAO();
        $smarty = new Smarty();
        $smarty->template_dir = 'templates/';
        $smarty->compile_dir = 'templates_c/';
        $smarty->config_dir = 'configs/';
        $smarty->cache_dir = 'cache/';

        $array = $DAO->selectUserWithNameAndPassword($user, $password);
        
        if($array == null){
            $smarty->display('connexionErreur.tpl');
        }
        else{   
            $smarty->display('connexionValide.tpl');
        }
    }

}
