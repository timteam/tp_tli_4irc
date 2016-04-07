<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InfoController
 *
 * @author Antoine
 */

require_once 'Controller.php';
class InfosController extends Controller{
    public function InfosActionGet(){
        $this->executeMethod(null, 'infos.tpl');   
    }
}
