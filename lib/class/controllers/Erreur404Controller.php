<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'Controller.php';
class Erreur404Controller extends Controller{
    
    public function erreur404ActionGet(){
        $this->executeMethod(null, 'erreur404.tpl');   
    }
    
}
