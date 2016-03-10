<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'DAO.php';

class SymptoneDAO extends DAO{
    
    protected function selectAll() {
        return ($connexion::requete("SELECT * FROM acu.symptone"));
    }

    protected function selectById($id) {
        return ($connexion::requete("SELECT * FROM acu.symptone WHERE ids = "+$id));
    }

}