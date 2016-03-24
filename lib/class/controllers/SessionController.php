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

        $array = $DAO->selectUserWithName($user);
        if ($array == null) {
            echo "Le pseudonyme n'existe pas.";
        } else if (password_verify($password, $array[0]["password"])) {
            session_start();
            echo "Connexion réussie !";
        }
        else{
            echo "Le couple pseudonyme/mot de passe est faux.";
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
            echo "TO FIX : Erreur dans la récupération des paramètres";
            return;
        }
        
        $login = $parameters['login'];
        $pass = $parameters['pass'];
        $email = $parameters['email'];
        
        if(!$this->isParametersUser($login, $pass, $email)){
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
     *          - 
     */
    private function isParametersUser($user, $pass, $email){
        $verificationVide = !empty($user) && !empty($pass) && !empty($email);
        $verificationSimpleCote = strpos($user, "'") == false && strpos($pass, "'") == false && strstr($email, "'") == false;
        $verificationDoubleCote = strpos($user, "\"") == false && strstr($pass, "\"") == false && strstr($email, "\"") == false;
        $verificationEmail = strpos($email, "@") < strpos($email, ".");
        
        return $verificationVide && $verificationSimpleCote && $verificationDoubleCote && $verificationEmail;
    }
}
