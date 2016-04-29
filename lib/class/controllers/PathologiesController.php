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
        if ($this->getRequestContentType() == "text/xml") {
            $this->pathosToXml($allList['Pathologies']);
            // return XML representation
        } else {
            $this->executeMethod($allList, 'pathologie.tpl');
        }
    }

    private function pathosToXml($pathosList) {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><pathologies/>');

        foreach ($pathosList as $key1 => $value1) {
            $patho = $xml->addChild('patho');
            foreach($value1 as $key2 => $value2){
                $patho->addChild($key2, htmlspecialchars($value2));
            }
        }
        Header('Content-type: text/xml');
        print($xml->asXML());
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
        $finalList[$name] = $meridiensList;
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
        //Initialiser base
        $pathologieDAO = new PathologieDAO();

        $requestParametres = $this->getRequestParametres();
        $listeCodeMeridien = array();
        if (isset($requestParametres['meridien'])) {
            $retourRequete = $requestParametres['meridien'];
            if (is_array($retourRequete)) {
                $listeCodeMeridien = $retourRequete;
            } else {
                $listeCodeMeridien[0] = $retourRequete;
            }
        }

        $listeType = array();
        if (isset($requestParametres['type'])) {
            $retourRequete = $requestParametres['type'];
            if (is_array($retourRequete)) {
                $listeType = $retourRequete;
            } else {
                $listeType[0] = $retourRequete;
            }
        }
        $listeCaracteristiques = array();
        if (isset($requestParametres['caracteristique'])) {
            $retourRequete = $requestParametres['caracteristique'];
            if (is_array($retourRequete)) {
                $listeCaracteristiques = $retourRequete;
            } else {
                $listeCaracteristiques[0] = $retourRequete;
            }
        }
        $listeKeyWords = array();
        if (isset($requestParametres['keyword'])) {
            $retourRequete = $requestParametres['keyword'];
            if (is_array($retourRequete)) {
                $listeKeyWords = $retourRequete;
            } else {
                $listeKeyWords[0] = $retourRequete;
            }
        }

        $retourRequete = $pathologieDAO->findByParameters($listeCodeMeridien, $listeType, $listeCaracteristiques, $listeKeyWords);

        $liste = array();
        if (is_array($retourRequete)) {
            $liste = $retourRequete;
        } else {
            $liste[0] = $retourRequete;
        }
        if (empty($liste[0])) {
            echo "<p>Aucune photologie ne correspond à votre recherche.</p>";
        } else {
            $this->executeAjax($this->traitement($liste), 'pathologieTableau.tpl');
        }
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
