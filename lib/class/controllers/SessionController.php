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
class SessionController extends Controller{
    //put your code here
    
        public function inscriptionAction() {

        include "lib/class/DAO/UserDAO.php";
        $DAO = new UserDAO();

        $this->getSmarty()->display('inscription.tpl');
    }

    public function connexionAction() {

        include "lib/class/DAO/UserDAO.php";
        $DAO = new UserDAO();
        $this->getSmarty()->display('connexion.tpl');
    }

    public function inscriptionValidatedAction($user, $password, $email) {
        include "lib/class/DAO/UserDAO.php";
        $DAO = new UserDAO();

        $cryptedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $DAO->insertUser($user, $cryptedPassword, $email);
    }

    public function connexionValidatedAction($user, $password) {
        include "lib/class/DAO/UserDAO.php";
        $DAO = new UserDAO();

        $array = $DAO->selectUserWithName($user);
        if ($array == null) {
            return null;
        } else if (password_verify($password, $array[0]["password"])) {
            return $array;
        }

        return null;
    }
}
