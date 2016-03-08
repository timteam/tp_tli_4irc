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
        private $dbName = "smite";//mettre le nom de votre base de donnée
        private $pass = ""; //donnez le mot de passe de votre bd 
        private $user = "root"; //donnez le nom d'utilisateur de la bd (probablement "root")

        private function getDB(){
                $db = null;
                try{
                        $db = new PDO('mysql:host=localhost;dbname='.$this->dbName, $this->user, $this->pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                }
                catch (Exception $e){
                                die('Erreur : ' . $e->getMessage());
                        }
                return $db;
        }

        public function requete($sql){
                $resu = null;

                $db = $this->getDB();
                foreach  ($db->query($sql) as $row) {
                        $resu[] = $row;
                }
                return $resu;
        }
}