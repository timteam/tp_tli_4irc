<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserDAO
 *
 * @author Antoine
 */

require_once 'DAO.php';

class UserDAO extends DAO{
    protected function selectAll() {
        return ($connexion::requete("SELECT * FROM acu.user"));
    }

    protected function selectById($id) {
        return ($connexion::requete("SELECT * FROM acu.user WHERE idU = $id"));
    }
    
    function insertUser($user, $password){
        return ($connexion::requete("INSERT INTO acu.user (name, password) VALUES (\"$user\", \"$password\""));
    }
}
