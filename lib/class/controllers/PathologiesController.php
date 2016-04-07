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
        require "lib/class/DAO/SymptomeDAO.php";
        $DAO = new PathologieDAO();
        //print_r($DAO->selectAllforPathologies());
        
        $list = $DAO->selectAllforPathologies();
        
        $DAOS = new SymptomeDAO();
        
        
        $allList = array();
        $meridiensList = array();
        $listSymp = array();
        $name = null;
        //$i = 0;
        foreach ($list['Pathologies'] as $value) {
            if($name == null){
                $name = $value->nom;
            }
            if(strcmp($name, $value->nom) != 0){
                $allList['liste'][$name]= $meridiensList;
                $name = $value->nom;
                $meridiensList = array();
                //$i=0;
                //echo('</br>------ Initialisation : ');
                //print($meridiensList);
                //echo(' ---------</br>');
                //echo('</br>------ nom : '.$name.' ---------</br>');
            }
            
            $idP = $value->idP;
            //echo (' <br> '.$idP.' <br> ');
            $listSymp = $DAOS->selectSymptonesByPatho($idP);
            //echo('</br>------ OBJET : ');
            //print_r($listSymp);
            //echo(' ---------</br>');
            if($listSymp != null){
                $meridiensList[$value->idP]= $listSymp;
            }
            
            //print_r($meridiensList);
            //$i++;
        }
        
        $allList['Keywords']= $list['Keywords'];
        $allList['Meridiens']= $list['Meridiens'];
        $allList['Pathologies']= $list['Pathologies'];
        //echo '<br> ----------------- COUCOU ---------------</br> ';
        //print_r($allList);
        $this->listForTable = $allList;
        $this->executeMethod($allList, 'pathologie.tpl');   
    }
    
    
    
    /**
     * Pour filtrer la liste des pathos
     * @param type $listeCodeMeridien
     * @param type $listeTypePatho
     * @param type $listeCaractPatho
     * @param type $listeIdMotCles
     */
    public function listePathologiesActionGet($listeCodeMeridien, $listeTypePatho, $listeCaractPatho, $listeIdMotCles ){
        require "lib/class/DAO/PathologieDAO.php";
        require "lib/class/DAO/SymptomeDAO.php";
        require "lib/class/DAO/MeridienDAO.php";
        require "lib/class/DAO/KeywordsDAO.php";
        
        $DAO = new PathologieDAO();
        
        $listFiltred = array();
        foreach($listeCodeMeridien as $codeMeridien){
            
        }
        
        
        $this->executeMethod($allList, 'pathologie.tpl');   
    }
}
