<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'DAO.php';

class SymptomeDAO extends DAO{
    
    function __construct() {
        try {
            
        parent::__construct();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

    }
    
    public function selectAll() {
        return ($this->connexion->requeteObjet("SELECT * FROM acu.symptone"));
    }

    public function selectById($id) {
        $db = $this->connexion->getDB();
        $sth = $db->prepare("SELECT * FROM acu.symptone WHERE ids = :id");
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        return ($this->connexion->requeteObjetPrepare($sth));
    }
    /**
     * Récupère la liste des sympthomes par rapport à une pathologie
     * @param type $id
     * @return type
     */
    public function selectSymptonesByPatho($id){
        $db = $this->connexion->getDB();
        $sth = $db->prepare("SELECT s.* FROM acu.symptPatho sp left join acu.symptome s on s.idS = sp.idS where sp.idP = :id");
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        return ($this->connexion->requeteObjetPrepare($sth));
    }
}