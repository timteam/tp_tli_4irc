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

class PathologieDAO extends DAO{
    
    function __construct() {
        parent::__construct();
    }
    
    protected function selectAll() {
        return ($this->connexion->requete("SELECT * FROM acu.patho"));
    }

    protected function selectById($id) {
        return ($connexion::requete("SELECT * FROM acu.patho WHERE idP = $id"));
    }
    
    /**
     * Récupère la liste des Symptones par rapport à une pathologie sélectionnée.
     * @param type $id
     * @return type liste de symptones qui est en générale unique
     */
    protected function selectPathoByIdSymptone($id){
        return ($connexion::requete("SELECT * FROM acu.patho p where p.idP in (
                                        select idP from acu.symptPatho sp where sp.idS = "
                                        + $id +")"));
    }
    
    /**
     * Récupère la liste des Symptones par rapport à une pathologie sélectionnée.
     * @param type $listSymptones
     * @return type liste de symptones
     */
    protected function selectPathoByListIdSymptone($listSymptones){
        $parameters = "";
        foreach($listSymptones['sId'] as $id){
            $parameters = $parameters + $id +", ";
        }
        $parameters = $parameters->substr($parameters,0,2);
        $parameters = $parameters + ")";
        
        return ($connexion::requete("SELECT * FROM acu.patho p where p.idP in (
                                        select idP from acu.symptPatho sp where sp.idS in ("
                                        + $parameters +"))"));
    }
}
