<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SessionController
 *
 * @author timotheetroncy
 */
require_once 'Controller.php';
class SessionController extends Controller{
    //put your code here
    
    public function sessionActionGet() {
        include "lib/class/DAO/UserDAO.php";
        $DAO = new UserDAO();
        $this->getRequestParametres();
        
        $this->getSmarty()->display('connexion/connexion.tpl');
    }
    
    public function sessionActionPost() {
        include "lib/class/DAO/UserDAO.php";
        $DAO = new UserDAO();

        $array = $DAO->selectUserWithName($user);
        if ($array == null) {
            return null;
        } else if (password_verify($password, $array[0]["password"])) {
            session_start();
            return $array;
        }

        return null;
    }
    
    public function sessionActionDelete() {
        session_destroy();
    }
    
    public function registerActionGet() {
        include "lib/class/DAO/UserDAO.php";
        $DAO = new UserDAO();

        $this->getSmarty()->display('inscription.tpl');
    }
    
    public function registerActionPost() {
        include "lib/class/DAO/UserDAO.php";
        $DAO = new UserDAO();

        $cryptedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $DAO->insertUser($user, $cryptedPassword, $email);
    }
}
