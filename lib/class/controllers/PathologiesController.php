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
require_once 'Controller.php';
class PathologiesController extends Controller {

    public function pathologiesActionGet() {
        require "lib/class/DAO/PathologieDAO.php";
        $DAO = new PathologieDAO();
        //print_r($DAO->selectAllforPathologies());
        
        $array = $DAO->selectAllforPathologies();
        $this->executeMethod($array, 'pathologie.tpl');   
    }
}
