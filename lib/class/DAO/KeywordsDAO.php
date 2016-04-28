<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'DAO.php';

class KeywordsDAO extends DAO{
    
    public function selectAll() {
        return ($this->connexion->requete("SELECT * FROM acu.keywords"));
    }

    public function selectById($id) {
        $db = $this->connexion->getDB();
        $sth = $db->prepare("SELECT * FROM acu.keywords WHERE idK = :id");
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        return ($this->connexion->requeteObjetPrepare($sth));
    }
    

}