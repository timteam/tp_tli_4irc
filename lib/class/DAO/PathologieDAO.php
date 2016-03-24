<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DAOPathologie
 *
 * @author Antoine
 */

require_once 'DAO.php';
require_once 'MeridienDAO.php';
require_once 'keywordsDAO.php';

class PathologieDAO extends DAO{
    
    function __construct() {
        try {
            
        parent::__construct();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }

    }
    
    public function selectAll() {
        return ($this->connexion->requeteObjet("SELECT * FROM acu.patho"));
    }

    public function selectById($id) {
        return ($this->connexion->requeteObjet("SELECT * FROM acu.patho WHERE idP = $id"));
    }
    
    /**
     * Récupère la liste des Symptomes par rapport à une pathologie sélectionnée.
     * @param type $id
     * @return type liste de symptones qui est en générale unique
     */
    public function selectPathoByIdSymptome($id){
        return ($this->connexion->requeteObjet("SELECT * FROM acu.patho p where p.idP in (
                                        select idP from acu.symptPatho sp where sp.idS = "
                                        + $id +")"));
    }
    
    /**
     * Récupère la liste des Symptomes par rapport à une pathologie sélectionnée.
     * @param type $listSymptomes
     * @return type liste de symptones
     */
    public function selectPathoByListIdSymptome($listSymptomes){
        $parameters = "";
        foreach($listSymptomes['sId'] as $id){
            $parameters = $parameters + $id +", ";
        }
        $parameters = $parameters->substr($parameters,0,2);
        $parameters = $parameters + ")";
        
        return ($this->connexion->requeteObjet("SELECT * FROM acu.patho p where p.idP in (
                                        select idP from acu.symptPatho sp where sp.idS in ("
                                        + $parameters +"))"));
    }
    
    
    
    public function selectAllWithMeridien() {
        return ($this->connexion->requeteObjet("SELECT patho.idP, patho.desc, patho.type , meridien.nom FROM acu.patho"
                                        . " JOIN acu.meridien on  patho.mer = meridien.code  "
                                        . " order by meridien.nom"));
    }
    
    public function selectAllforPathologies(){
        $meridien = new MeridienDAO();
        $keywords = new keywordsDAO();
        $list = array(
            "Pathologies" => $this->selectAllWithMeridien(),
            "Keywords" => $keywords->selectAll(),
            "Meridiens" => $meridien->selectAll()
        );
        return $list;
    }
    
    

}
