<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseDonnee
 *
 * @author loknight
 */


class BaseDonnee {
        private $dbName = "acu";//mettre le nom de votre base de donnée
        private $pass; //donnez le mot de passe de votre bd 
        private $user = "root"; //donnez le nom d'utilisateur de la bd (probablement "root")
        private $port;
        
        private $db;
        
        
        
        public function __construct(){
            include 'configs/config.php';
            $this->pass = $appConfig['DBPassword'];
            $this->port = $appConfig['DBport'];
        }
        
        public function getDB(){
                $db = null;
                try{
                        $db = new PDO('mysql:host=localhost;port='.$this->port.';dbname='.$this->dbName, $this->user, $this->pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                }
                catch (Exception $e){
                                die('Erreur : ' . $e->getMessage());
                        }
                return $db;
        }
        
        /**
         * Retourne liste de champs
         * @param type $sql
         * @return type
         */
        public function requete($sql){
                $resu = null;

                $db = $this->getDB();
                foreach  ($db->query($sql) as $row) {
                        $resu[] = $row;
                }
                return $resu;
        }
        
        
        
        /**
         * Exécute la requete et Retourne une liste d'objets
         * @param type $sql : requete SQL
         * @return type
         */
        public function requeteObjet($sql){
                $resu = null;
                $db = $this->getDB();
                //prepare la requete
                try{
                    $sth = $db->prepare($sql);
                    //execute la requete
                    if(!$sth->execute()){
                        return false;
                    }
                    
                    //transforme les occurences en liste d'objets
                    while(($result = $sth->fetch(PDO::FETCH_OBJ)) != null){
                        $resu[] = $result;
                    }
                }
                catch(Exception $e){
                    die('Erreur : ' . $e->getMessage());
                }
                return $resu;
        }
        
        /**
         * 
         * @param type $sth
         * @return boolean
         */
        public function requeteObjetPrepare($sth){
                $resu = null;
                //prepare la requete
                try{
                    //execute la requete
                    if(!$sth->execute()){
                        return false;
                    }
                    
                    //transforme les occurences en liste d'objets
                    while(($result = $sth->fetch(PDO::FETCH_OBJ)) != null){
                        $resu[] = $result;
                    }
                }
                catch(Exception $e){
                    die('Erreur : ' . $e->getMessage());
                }
                return $resu;
        }
        
       
        
        
}
