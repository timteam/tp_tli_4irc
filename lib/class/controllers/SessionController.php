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
        
        $this->getSmarty()->display('connexion/connexion.tpl');
    }
    
    public function sessionActionPost() {
        include "lib/class/DAO/UserDAO.php";
        $DAO = new UserDAO();

        $parameters = $this->getRequestParametres();
        
        if($parameters == NULL){
            echo "TO FIX : Erreur dans la récupération des paramètres";
            return;
        }
        
        $login = $parameters['login'];
        $pass = $parameters['pass'];
        
        if(!$this->isParametersUserConnection($login, $pass)){
            echo "Un ou plusieurs champs est (sont) vide(s) ou incorrect(s).";
            return;
        }
        
        $array = $DAO->selectUserWithName($login);
        if ($array == null) {
            echo "Le pseudonyme n'existe pas.";
        } else if (password_verify($pass, $array[0]["password"])) {
            if (!isset($_SESSION['user']) && !empty($_SESSION['user'])) {
                echo "TO FIX : Problème modification \$_SESSION['user'] : " + $_SESSION['user'];
            } else {
                $_SESSION['user'] = $login;
                $_SESSION['LAST_ACTIVITY'] = time();
            }
            
            echo "Connexion réussie !";
        }
        else{
            echo "Le couple pseudonyme/mot de passe est faux.";
        }
    }
    
    public function sessionActionDelete() {
        session_unset();     // unset $_SESSION variable for the run-time 
        session_destroy();   // destroy session data in storage
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
            echo "TO FIX : Erreur dans la récupération des paramètres";
            return;
        }
        
        $login = $parameters['login'];
        $pass = $parameters['pass'];
        $email = $parameters['email'];
        
        if(!$this->isParametersUserInscription($login, $pass, $email)){
            echo "Un ou plusieurs champs est (sont) vide(s) ou incorrect(s).";
            return;
        }
        
        $cryptedPassword = password_hash($pass, PASSWORD_DEFAULT);

        echo $DAO->insertUser($login, $cryptedPassword, $email)['message'];
    }
    
    
    /*
     * Author : Antoine Bouquet
     * Permet de vérifier les paramètres avant l'inscription de l'utilisateur
     * Conditions : 
     *          - pas de caractères ', ni " sur tous les champs
     *          - champs non-vide
     *          - email bien formé 
     * 
     */
    private function isParametersUserInscription($user, $pass, $email){
        $verificationVide = !empty($user) && !empty($pass) && !empty($email);
        $verificationSimpleCote = strpos($user, "'") == false && strpos($pass, "'") == false && strpos($email, "'") == false;
        $verificationDoubleCote = strpos($user, "\"") == false && strpos($pass, "\"") == false && strpos($email, "\"") == false;
        $verificationEspace = strpos($user, "\"") == false && strpos($pass, "\"") == false && strpos($email, "\"") == false;
        $verificationEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        
        return $verificationVide && $verificationSimpleCote && $verificationDoubleCote && $verificationEmail && $verificationEspace;
    }
    
    /* Permet de vérifier les paramètres avant la connexion de l'utilisateur
     * Conditions : 
     *          - pas de caractères ', ni " sur tous les champs
     *          - 
     */
    private function isParametersUserConnection($user, $pass){
        $verificationVide = !empty($user) && !empty($pass);
        $verificationSimpleCote = strpos($user, "'") == false && strpos($pass, "'") == false;
        $verificationDoubleCote = strpos($user, "\"") == false && strpos($pass, "\"") == false;
        $verificationEspace = strpos($user, " ") == false && strpos($pass, " ") == false;
        
        return $verificationVide && $verificationSimpleCote && $verificationDoubleCote && $verificationEspace;
    }
}
