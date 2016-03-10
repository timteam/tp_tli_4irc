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

}
