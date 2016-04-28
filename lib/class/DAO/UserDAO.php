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
    
    function __construct() {
        try {
            parent::__construct();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function selectAll() {
        return ($this->connexion->requete("SELECT * FROM acu.user"));
    }

    public function selectById($id) {
        $db = $this->connexion->getDB();
        $sth = $db->prepare("SELECT * FROM acu.user WHERE idU = :id");
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        return ($this->connexion->requeteObjetPrepare($sth));
    }
    
    public function insertUser($user, $password, $email){
        $array = array();
        $db = $this->connexion->getDB();
        $sth = $db->prepare("INSERT INTO acu.user (name, password, email) VALUES ( :user, :password, :email)");
        $sth->bindParam(':user', $user, PDO::PARAM_STR, 20);
        $sth->bindParam(':password', $password, PDO::PARAM_STR, 255);
        $sth->bindParam(':email', $email, PDO::PARAM_STR, 50);
        $result = $this->connexion->requeteObjetPrepare($sth);
        
        if(isset($result) && !$result){
            $array["user"] = null;
            $array["message"] = "Erreur : Le pseudonyme est déjà utilisé";
        }
        else{    
            $array["user"] = $user;
            $array["message"] = "Inscription réussie.";
        
        }
        return $array;
        
    }
    
    public function selectUserWithName($user){
        $db = $this->connexion->getDB();
        $sth = $db->prepare("SELECT * FROM acu.user WHERE name = :user");
        $sth->bindParam(':user', $user, PDO::PARAM_INT);
        return ($this->connexion->requeteObjetPrepare($sth));
    }
}
