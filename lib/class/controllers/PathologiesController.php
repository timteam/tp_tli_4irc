<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author timotheetroncy
 */
require_once 'Controller.php';

class PathologiesController extends Controller {

    public $listForTable;

    public function pathologiesActionGet() {
        require "lib/class/DAO/PathologieDAO.php";

        $DAO = new PathologieDAO();
        $list = $DAO->selectAllforPathologies();

        $allList = array();

        $allList['liste'] = $this->traitement($list['Pathologies']);
        $allList['Keywords'] = $list['Keywords'];
        $allList['Meridiens'] = $list['Meridiens'];
        $allList['Pathologies'] = $list['Pathologies'];
        $this->listForTable = $allList;
        $this->executeMethod($allList, 'pathologie.tpl');
    }

    private function traitement($list) {
        require "lib/class/DAO/SymptomeDAO.php";
        $DAOS = new SymptomeDAO();

        $finalList = array();
        $meridiensList = array();
        $listSymp = array();
        $name = null;
        foreach ($list as $value) {
            if ($name == null) {
                $name = $value->nom;
            }
            if (strcmp($name, $value->nom) != 0) {
                $finalList[$name] = $meridiensList;
                $name = $value->nom;
                $meridiensList = array();
            }

            $idP = $value->idP;
            $listSymp = $DAOS->selectSymptonesByPatho($idP);
            if ($listSymp != null) {
                $meridiensList[$value->desc] = $listSymp;
            }
        }
        return $finalList;
    }

    /**
     * Pour filtrer la liste des pathos
     * @param type $listeCodeMeridien
     * @param type $listeTypePatho
     * @param type $listeCaractPatho
     * @param type $listeIdMotCles
     */
    public function listePathologiesActionGet() {
        require "lib/class/DAO/PathologieDAO.php";
        //index pour ajouter des éléments 
        $index = 0;
        //Liste à retourner
        $liste = array();
        //Initialiser base
        $pathologieDAO = new PathologieDAO();
        
        $requestParametres = $this->getRequestParametres();
        $listTemp = array();
        if (isset($requestParametres['meridien'])){
            $listeCodeMeridien = $requestParametres['meridien'];
            
            
        }
        
        
        //Pour les types
        
        
        if(isset($requestParametres['type'])){
            $retourTypePatho = $requestParametres['type'];
            //S'il y a des caractéristiques.
            if(isset($requestParametres['caracteristique'])){
                $retourCaractPatho = $requestParametres['caracteristique'];
                //S'il n'y a qu'un seul type 
                if(!is_array($retourTypePatho)){
                    $listeTypePatho = array();
                    $listeTypePatho[0] = $retourTypePatho;
                //Sinon
                }else{
                    $listeTypePatho = $retourTypePatho;
                }
                
                //S'il n'y a qu'une seule caracteristique
                if(!is_array($retourCaractPatho)){
                    $listeCaractPatho = array();
                    $listeCaractPatho[0] = $retourCaractPatho;
                //Sinon
                }else{
                    $listeCaractPatho = $retourCaractPatho;
                }
                
                // Traitement pour fusionner les 2 chaines
                foreach ($listeTypePatho as $type) {
                    foreach ($listeCaractPatho as $carac) {
                        $listType[$i] = $type . $carac;
                        $i++;
                    }
                }
                
                //Traitement SQL
                foreach ($listType as $typeComplet) {
                    $retourRequete = $pathologieDAO->findByTypePatho($typeComplet);
                    $listTemp = array();
                    if(is_array($retourRequete)){
                        $listTemp = $retourRequete;
                    }else{
                        $listTemp[0] = $retourRequete;
                    }
                    
                    foreach ($listTemp as $t){
                        //Ajoute mon élément
                        $liste[$index] = $t;
                        $index++;
                    }
                }
                
            //Ou non
            }else{
                //S'il n'y a qu'un seul type 
                if(!is_array($retourTypePatho)){
                    $listeTypePatho = array();
                    $listeTypePatho[0] = $retourTypePatho;
                //Sinon
                }else{
                    $listeTypePatho = $retourTypePatho;
                }
                foreach ($listeTypePatho as $typeTemp) {
                    $retourRequete = $pathologieDAO->findByTypePatho($typeTemp);
                    if(!is_array($retourRequete)){
                        $listTemp[0] = $retourRequete;
                    }else{
                        $listTemp = $retourRequete;
                    }
                    
                    foreach ($listTemp as $temp) {
                        $liste[$index] = $temp;
                        $index++;
                    }
                    
                }
            }
        }
        elseif(isset($requestParametres['caracteristique'])){
            $retourCaractPatho = $requestParametres['caracteristique'];
            //S'il n'y a qu'une seule caracteristique
            if(!is_array($retourCaractPatho)){
                $listeCaractPatho = array();
                $listeCaractPatho[0] = $retourCaractPatho;
            //Sinon
            }else{
                $listeCaractPatho = $retourCaractPatho;
            }
            
            foreach ($listeCaractPatho as $carac) {
                $retourRequete = $pathologieDAO->findByTypePatho($type);
                if(is_array($retourRequete)){
                    $listType[$i] = $retourRequete;
                }else{
                   foreach ($listTemp as $temp) {
                    $listType[$i] = $temp;
                    $i++;
                   }
                } 
            }
        }
        
        
        
        if(isset($requestParametres['caracteristique'])){
            $listeCaractPatho = $requestParametres['caracteristique'];
        }
        if(isset($requestParametres['keyword'])){
            $listeIdMotCles = $requestParametres['keyword'];
        }
        
/*
        $argTypePatho = "";

        $listType = array();
        $i = 0;
        
        foreach ($listeTypePatho as $type) {
            
            //Si on a sélectionné des caractères on filtre
            if (count($listeCaractPatho) > 0) {

                foreach ($listeCaractPatho as $carac) {
                    $listType[$i] = $type . $carac;
                    $i++;
                }

                //Sinon on récupère tous les champs.
            } else {
                $listTemp = $pathologieDAO->findByTypePatho($type);
                foreach ($listTemp as $temp) {
                    $listType[$i] = $temp;
                    $i++;
                }
            }
        }
        $argCodeMeridien = $this->listToString($listeCodeMeridien);
        $argTypePatho = $this->listToString($listType);
        $argIdKeyWords = $this->listToString($listeIdMotCles);

        $listFiltred = array();
        $listFiltred['liste'] = $pathologieDAO->selectPathoByLists($argCodeMeridien, $argTypePatho, $argIdKeyWords);

*/
        $this->executeMethod(traitement($liste), 'pathologieTableau.tpl');
    }

    public function listToString($list) {
        $listString = "";
        foreach ($code as $list) {
            if (listString == "") {
                $listString = "'" . $code . "'";
            } else {
                $listString = $listString . ", '" . $code . "'";
            }
        }
    }

}
