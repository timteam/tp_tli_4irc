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
require_once 'KeywordsDAO.php';

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
        $db = $this->connexion->getDB();
        $sth = $db->prepare("SELECT * FROM acu.patho WHERE idP = :id");
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        return ($this->connexion->requeteObjetPrepare($sth));
    }
    
    /**
     * Récupère la liste des Symptomes par rapport à une pathologie sélectionnée.
     * @param type $id
     * @return type liste de symptones qui est en générale unique
     */
    public function selectPathoByIdSymptome($id){
        $db = $this->connexion->getDB();
        $sth = $db->prepare("SELECT * FROM acu.patho p where p.idP in (
                                        select idP from acu.symptPatho sp where sp.idS = :id)");
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        return ($this->connexion->requeteObjetPrepare($sth));
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
        
        $db = $this->connexion;
        $sth = $db->prepare("SELECT * FROM acu.patho p where p.idP in (
                                        select idP from acu.symptPatho sp where sp.idS in (:parameters))");
        $sth->bindParam(':parameters', $parameters, PDO::PARAM_INT);
        
        return ($this->connexion->requeteObjetPrepare($sth));
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
    
    
    
    public function selectPathoByLists($argCodeMeridien, $argTypePatho, $argIdKeyWords) {
        //prepare la requete
        $db = $this->connexion;
        $sth = $db->prepare("SELECT patho.idP, patho.desc, patho.type , meridien.nom FROM acu.patho"
                                            . " JOIN acu.meridien ON  patho.mer = meridien.code"
                                            . " JOIN acu.symptPatho ON symptPatho.idP = patho.idP"
                                            . " JOIN acu.keySympt ON keySympt.idS = symptPatho.idS"
                                            . " WHERE meridien.code IN ( :argCodeMeridien )"
                                            . " OR patho.type IN ( :argTypePatho )"
                                            . " OR keySympt.idK IN ( :argIdKeyWords )"
                                            . " ORDER BY meridien.nom");
        $sth->bindParam(':argCodeMeridien', $argCodeMeridien, PDO::PARAM_STR, 5);
        $sth->bindParam(':argTypePatho', $argTypePatho, PDO::PARAM_STR, 10);
        $sth->bindParam(':argIdKeyWords', $argIdKeyWords, PDO::PARAM_INT);
        return ($this->connexion->requeteObjetPrepare($sth));
    }
    
    
    public function findByParameters($meridiens, $types, $caracs, $keyWords){
        
        $sql = "SELECT patho.idP, patho.desc, patho.type , meridien.nom "
                                        . " FROM acu.patho"
                                        . " JOIN acu.meridien on  patho.mer = meridien.code"
                                        . " JOIN acu.symptPatho ON symptPatho.idP = patho.idP"
                                        . " JOIN acu.keySympt ON keySympt.idS = symptPatho.idS";
        $sql .= " WHERE 1";
        if(!empty($meridiens)){
            $sql .= " and ("; $i = 0;
            foreach  ($meridiens as $meridien) {
                if($i != 0)
                        $sql .= " OR";
                    
                $sql .= " patho.mer like '".$meridien."'";
                $i++;
            }
            $sql .= ") ";
        }
        
        if(!empty($types)){
            $sql .= " and ("; $i = 0;
            foreach  ($types as $type) {
                if($i != 0)
                        $sql .= " OR";
                    
                $sql .= " patho.type like '".$type."%'";
                $i++;
            }
            $sql .= ") ";
        }
        
        if(!empty($caracs)){
            $sql .= " and ("; $i = 0;
            foreach  ($caracs as $carac) {
                if($i != 0)
                        $sql .= " OR";
                    
                $sql .= " (patho.type like '%".$carac."%' and patho.type not like '".$carac."%' )";
                $i++;
            }
            $sql .= ") ";
        }
        
        if(!empty($keyWords)){
            $sql .= " and ("; $i = 0;
            foreach  ($keyWords as $keyWord) {
                if($i != 0)
                        $sql .= " OR";
                    
                $sql .= " keySympt.idK = ".$keyWord;
                $i++;
            }
            $sql .= ") ";
        }
        
        
        $sql .= " order by meridien.nom";
        
        return ($this->connexion->requeteObjet($sql));
    }
    
}
