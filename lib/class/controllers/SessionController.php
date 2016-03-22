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
            return "Le pseudonyme n'existe pas.";
        } else if (password_verify($password, $array[0]["password"])) {
            session_start();
            return "Connexion réussie !";
        }
        else{
            return "Le couple pseudonyme/mot de passe est faux.";
        }
    }
    
    public function sessionActionDelete() {
        session_destroy();
    }
    
    public function registerActionGet() {
        include "lib/class/DAO/UserDAO.php";
        $DAO = new UserDAO();

        $this->getSmarty()->display('connexion/inscription.tpl');
    }
    
    public function registerActionPost() {
        include "lib/class/DAO/UserDAO.php";
        $DAO = new UserDAO();    
        
        $parameters = $this->getRequestParametres();
        
        if($parameters == NULL){
            return "TO FIX : Erreur dans la récupération des paramètres";
        }
        
        $login = $parameters['login'];
        $pass = $parameters['pass'];
        $email = $parameters['email'];
        
        $result = isParametersUser($login, $pass, $email);
        
        if(!$result['result']){
            
        }
        
        $cryptedPassword = password_hash($pass, PASSWORD_DEFAULT);

        return $DAO->insertUser($user, $cryptedPassword, $email);
    }
    
    
    /*
     * Author : Antoine Bouquet
     * Permet de vérifier les paramètres avant l'inscription de l'utilisateur
     * Conditions : 
     *          - pas de caractères ', ni " sur tous les champs
     *          - 
     */
    private function isParametersUser($user, $pass, $email){
        $verificationSimpleCote = strpos($user, "'") == false && strpos($user, "'") == false && strstr($user, "'") == false;
        $verificationDoubleCote = strpos($user, "\"") == false && strstr($user, "\"") == false && strstr($user, "\"") == false;
        $verificationEmail = strpos($email, "@") < strpos($email, ".");
    }
}
