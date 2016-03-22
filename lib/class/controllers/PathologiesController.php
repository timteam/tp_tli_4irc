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
        include "lib/class/DAO/PathologieDAO.php";
        $DAO = new PathologieDAO();
        //print_r($this->getRequestParametres());
        $this->executeMethod($DAO->selectAllWithMeridien(), 'pathologie.tpl');   
    }
}
