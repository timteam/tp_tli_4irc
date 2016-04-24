<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HomeController
 *
 * @author timotheetroncy
 */
require_once 'Controller.php';

class CalculatriceController extends Controller {

    public function additionActionGet() {
        $urlParameters = $this->getUrlParametres();
        echo $urlParameters['number1'] + $urlParameters['number2'];
    }

    public function soustractionActionGet() {
        $urlParameters = $this->getUrlParametres();
        echo $urlParameters['number1'] - $urlParameters['number2'];
    }

    public function multiplicationActionGet() {
        $urlParameters = $this->getUrlParametres();
        echo $urlParameters['number1'] * $urlParameters['number2'];
    }

    public function divisionActionGet() {
        $urlParameters = $this->getUrlParametres();
        echo $urlParameters['number1'] / $urlParameters['number2'];
    }

}
