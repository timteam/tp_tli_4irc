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

    public function pathologiesActionGet() {
        require "lib/class/DAO/PathologieDAO.php";
        require "lib/class/DAO/SymptomeDAO.php";
        $DAO = new PathologieDAO();
        //print_r($DAO->selectAllforPathologies());
        
        $list = $DAO->selectAllforPathologies();
        
        $DAOS = new SymptomeDAO();
        
        
        $allList = array();
        $meridiensListé = array();
        $listSymp = array();
        $name = null;
        $i = 0;
        foreach ($list['Pathologies'] as $value) {
            if($name == null){
                $name = $value->nom;
            }
            if(strcmp($name, $value->nom) != 0){
                $allList[$name]= $meridiensList;
                $name = $value->nom;
                $meridiensList = array();
                $i=0;
                echo('</br>------ Initialisation : ');
                //print($meridiensList);
                echo(' ---------</br>');
                echo('</br>------ nom : '.$name.' ---------</br>');
            }
            
            $idP = $value->idP;
            echo (' <br> '.$idP.' <br> ');
            $listSymp = $DAOS->selectSymptonesByPatho($idP);
            echo('</br>------ OBJET : ');
            print_r($listSymp);
            echo(' ---------</br>');
            if($listSymp != null){
                $meridiensList[$value->idP]= $listSymp;
            }
            
            //print_r($meridiensList);
            $i++;
        }
         //print_r($allList);
        $allList['Keywords']= $list['Keywords'];
        $allList['Meridiens']= $list['Meridiens'];
        $allList['Pathologies']= $list['Pathologies'];
        
        $this->executeMethod($allList, 'pathologie.tpl');   
    }
}
