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
        $requestParametres = $this->getRequestParametres();
        if (isset($requestParametres['meridien'])){
        $listeCodeMeridien = $requestParametres['meridien'];
        }else{
            $listeCodeMeridien = array();
        }
        if(isset($requestParametres['type'])){
        $listeTypePatho = $requestParametres['type'];
        }else{
            $listeTypePatho = array();
        }
        if(isset($requestParametres['caracteristique'])){
            $listeCaractPatho = $requestParametres['caracteristique'];
        }else{
            $listeCaractPatho = array();
        }
        if(isset($requestParametres['keyword'])){
            $listeIdMotCles = $requestParametres['keyword'];
        }else{
            $listeIdMotCles = array();
        }
        
        $pathologieDAO = new PathologieDAO();

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


        $this->executeMethod($listFiltred['liste'], 'tableauPathologie.tpl');
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
