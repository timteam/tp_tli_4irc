<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseDonnee.php';

abstract class DAO{
    protected static $connexion;
    
    function __construct(){
        try{
            $this->$connexion = BaseDonnee::getDB();
        }catch(Exception $e){
            //printf("Echec de connexion : \n" + $e);
            throw new Exception("Echec de connexion : \n" + $e);
        }
        
    }
      
    abstract protected function selectAll();
    abstract protected function selectById($id);
    
    
} 
?>