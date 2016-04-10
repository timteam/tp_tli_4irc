<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HomeController
 *
 * @author timotheetroncy
 */
require_once 'Controller.php';
class HomeController extends Controller{
    
    public function homeActionGet(){
        $this->executeMethod(null, 'home.tpl');   
    }
    
    public function home_numbersActionGet(){
        $urlParams = $this->getUrlParametres();
        print_r($urlParams);
        //$this->executeMethod(null, 'home.tpl'); 
    }
    
}
