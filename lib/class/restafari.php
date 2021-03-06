<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Utilisé pour récupérer la méthode et le Content-type de la requete http 
 *
 * @author timotheetroncy
 */
class restafari {

    //Content-Types acceptés: text/html ou application/json
    //Si content-type n'est pas défini, on renvoie du html
    //Si rempli mais non pris en charge, on renvoie du html
    //Les forms html envoient du x-www-form-urlencoded --> revoi du text/html
    public static function getContentType() {
        $defaultValue = 'text/html';
        if (!isset($_SERVER["CONTENT_TYPE"])) {
            return $defaultValue;
        }
        $contentType = strtolower(filter_input(INPUT_SERVER, 'CONTENT_TYPE', FILTER_SANITIZE_ENCODED));

        switch ($contentType) {
            case 'text/html':
                return $contentType;
            case 'application/json':
                return $contentType;
            default:
                return $defaultValue;
        }
    }

    //Methodes acceptées: 'PUT', 'GET', 'DELETE', 'POST'
    //pour permettre de récupérer la méthode via un formulaire classique en POST
    //On va vérifie la valeur du champ POST '_method'
    //<form method="post" ...>
    //<input type="hidden" name="_method" value="put" />
    //Les liens <a> ne peuvent contenir une autre méthode que GET sans utiliser JS
    public static function getRequestMethod() {
        $defaultValue = 'GET';
        if (!isset($_SERVER['REQUEST_METHOD'])) {
            return $defaultValue;
        }
        //récupérer le méthode http ('HEAD', 'PUT', 'GET', 'DELETE', 'POST', 'TRACE', 'CONNECT')
        $requestMethod = strtoupper(filter_input(INPUT_SERVER, $_SERVER['REQUEST_METHOD'], FILTER_SANITIZE_STRING));
        switch ($requestMethod) {
            case 'GET':
                return $requestMethod;
            case 'POST':
                $this->getRequestMethodOnFormPost();
                return $requestMethod;
            case 'PUT':
                return $requestMethod;
            case 'DELETE':
                return $requestMethod;
            default:
                return $defaultValue;
        }
    }

// Lit la valeur du hidden input de nom '_method'
// Si non sétté ou invalide, retourne POST
    private static function getRequestMethodOnFormPost() {
        $defaultValue = 'POST';
        if (!isset($_POST['_method'])) {
            return $defaultValue;
        }
        $requestMethod = strtoupper(filter_input(INPUT_SERVER, $_SERVER['REQUEST_METHOD'], FILTER_SANITIZE_STRING));

        switch ($requestMethod) {
            case 'GET':
                return $requestMethod;
            case 'POST':
                return $requestMethod;
            case 'PUT':
                return $requestMethod;
            case 'DELETE':
                return $requestMethod;
            default:
                return $defaultValue;
        }
    }

}
