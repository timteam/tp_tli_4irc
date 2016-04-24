<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * sert à définir les routes et à lancer l'action correspondant à la requête 
 *
 * @author timotheetroncy
 */
class routifari {

    //put your code here
    private $routes;
    private $smarty;

    public function __construct() {
        //Pour un $controller = 'homeLand' on obtient 'HomelandController' (première lettre capitale + 'Controller')
        //Pour un $controllerMethodName = 'HomeLand' avec méthode GET, on obtient la méthode de controller 'homelandActionGet'
        //new route ($method, $contentType, $route, $controller,     $controllerMethodName)
        //
        $this->routes[] = new route('GET', 'HTML', '/erreur404', 'erreur404', 'erreur404'); //shows error404 page
        $this->routes[] = new route('GET', 'HTML', '/', 'home', 'home'); //shows homepage
        $this->routes[] = new route('GET', 'HTML', '/home', 'home', 'home'); //shows homepage
        $this->routes[] = new route('GET', 'HTML', '/infos', 'infos', 'infos'); //shows info page
        $this->routes[] = new route('GET', 'HTML', '/sessions', 'session', 'session'); //shows login form
        $this->routes[] = new route('POST', 'HTML', '/sessions', 'session', 'session'); //login
        $this->routes[] = new route('DELETE', 'HTML', '/sessions', 'session', 'session'); //logout & redirects to ''
        $this->routes[] = new route('GET', 'HTML', '/users/register', 'session', 'register'); //shows registration form
        $this->routes[] = new route('POST', 'HTML', '/users', 'session', 'register'); //register user to DB
        $this->routes[] = new route('GET', 'HTML,JSON', '/symptomes', 'symptomes', 'symptomes'); //shows symptoms
        $this->routes[] = new route('GET', 'HTML,JSON', '/liste-pathologies', 'pathologies', 'listePathologies'); //shows array of pathos
        $this->routes[] = new route('GET', 'HTML,JSON', '/pathologies', 'pathologies', 'pathologies'); //shows pathos
        $this->routes[] = new route('GET', 'JSON', '/meridiens', 'meridiens', 'meridiens'); //shows méridiens
        //addition
        $route = new route('GET', 'HTML,JSON', '/calculatrice/addition/{number1}/{number2}', 'calculatrice', 'addition');
        $route->addParameterRule('number1', '/^-?\d{1,15}$/');
        $route->addParameterRule('number2', '/^-?\d{1,15}$/');
        $this->routes[] = $route;
        //end addition
        //soustraction
        $route = new route('GET', 'HTML,JSON', '/calculatrice/soustraction/{number1}/{number2}', 'calculatrice', 'soustraction');
        $route->addParameterRule('number1', '/^-?\d{1,15}$/');
        $route->addParameterRule('number2', '/^-?\d{1,15}$/');
        $this->routes[] = $route;
        //end soustraction
        //multiplication
        $route = new route('GET', 'HTML,JSON', '/calculatrice/multiplication/{number1}/{number2}', 'calculatrice', 'multiplication');
        $route->addParameterRule('number1', '/^-?\d{1,15}$/');
        $route->addParameterRule('number2', '/^-?\d{1,15}$/');
        $this->routes[] = $route;
        //end multiplication
        //division
        $route = new route('GET', 'HTML,JSON', '/calculatrice/division/{number1}/{number2}', 'calculatrice', 'division');
        $route->addParameterRule('number1', '/^-?\d{1,15}$/');
        $route->addParameterRule('number2', '/^-?[1-9]\d{0,15}$/');
        $this->routes[] = $route;
        //end division
    }

    public function launch($requestContentType, $requestMethod, $requestUrl, $parametres) {
        try {
            $UpRequestMethod = strtoupper($requestMethod);
            $LowRequestContentType = strtolower($requestContentType);
            $parsedURL = array_values(array_filter(explode('/', $requestUrl, 50), 'strlen'));
            $foundRoute = $this->getFirstMatchingRoute($LowRequestContentType, $UpRequestMethod, $parsedURL);
            //La première route correspondante est exécutée
            if (is_null($foundRoute)) {
                throw new Exception("aucune route ne correspond");
            } else {
                $this->launchAction($foundRoute, $LowRequestContentType, $parametres);
            }
        } catch (Exception $e) {
            require_once(SMARTY_DIR . 'Smarty.class.php');
            $php_self = $_SERVER['PHP_SELF'];
            $array = explode("index.php", $php_self);
            $this->smarty = new Smarty();
            $this->smarty->template_dir = 'templates/';
            $this->smarty->compile_dir = 'templates_c/';
            $this->smarty->config_dir = 'configs/';
            $this->smarty->cache_dir = 'cache/';
            $this->smarty->assign('route', $array[0]);
            $this->smarty->assign('argument', null);
            $this->smarty->assign('user', false);
            $this->smarty->assign('module', 'erreur404.tpl');
            $this->smarty->display('site.tpl');
        }
    }

    private function getFirstMatchingRoute($LowRequestContentType, $UpRequestMethod, $parsedURL) {
        foreach ($this->routes as $route) {
            if ($route->requestMatchesRoute($LowRequestContentType, $UpRequestMethod, $parsedURL)) {
                return $route;
            }
        }
        return null;
    }

    private function launchAction(route $route, $requestContentType, $parametres) {
        $controllerName = $route->getController();
        $actionName = $route->getControllerActionName();
        if (file_exists('lib/class/controllers/' . $controllerName . '.php')) {
            include 'lib/class/controllers/' . $controllerName . '.php';
            $controller = new $controllerName($requestContentType, $parametres, $route->getUrlReqParamsValues());
            if (is_callable(array($controller, $actionName))) {
                $controller->{$actionName}();
            } else {
                throw new Exception("methode \"$actionName\" inconnue dans le Controleur: " . $controllerName);
            }
        } else {
            throw new Exception("Le fichier controleur n'existe pas");
        }
    }

}

class route {

    private $method;
    private $contentTypes; // array of content types
    private $route; // array of url elements
    private $controller; // target controller filename
    private $controllerActionName; // target method name of target controller
    private $urlParametersRules; // associative array: array (parameterName => array(parameterRule))
    private $urlParametersName; // array of url parameters defined between {}. The array key is the place of parameter in url
    private $urlReqParamsValues; // Url parameters values to return to controllers

    public function __construct($method, $contentTypes, $route, $controller, $controllerActionName) {
        $this->method = strtoupper($method);
        switch ($this->method) {
            case 'GET': break;
            case 'POST': break;
            case 'PUT':break;
            case 'DELETE':break;
            default:throw new Exception("Méthode HTTP invalide dans la définition des routes");
        }
        $this->contentTypes = array_values(array_filter(explode(',', strtoupper($contentTypes))));
        foreach ($this->contentTypes as $key => $contentType) {
            switch ($contentType) {
                case 'HTML': $this->contentTypes[$key] = 'text/html';
                    break;
                case 'JSON': $this->contentTypes[$key] = 'application/json';
                    break;
                case 'XML': $this->contentTypes[$key] = 'text/xml';
                    break;
                default:throw new Exception("Format invalide dans la définition des routes");
            }
        }
        $this->route = array_values(array_filter(explode('/', $route)));
        $this->controller = ucfirst(strtolower($controller)) . 'Controller';
        $this->controllerActionName = strtolower($controllerActionName) . 'Action' . ucfirst(strtolower($method));
        $this->prepareUrlParameters();
    }

    //vient ajouter à la liste des paramètres (urlParameters) l'ensemble des paramètres trouvés entre {}
    private function prepareUrlParameters() {
        $this->urlParametersName = array();
        $parametreName = array();
        //key contient la position du paramètre dans l'url
        foreach ($this->route as $key => $routeElement) {
            preg_match_all('/{(.*?)}/', $routeElement, $parametreName);
            if (!empty($parametreName[1])) {
                $this->urlParametersRules[$key] = array($parametreName[1][0], array());
                //             indice param url     nom paramètre        tableau des regex
                $this->urlParametersName[$key] = $parametreName[1][0];
                //tableau des noms de paramètres
            }
        }
        //On teste s'il y a des paramètres dupliqués
        if (!(count($this->urlParametersName) == count(array_count_values($this->urlParametersName)))) {
            //un des noms de paramètres d'url est dupliqué
            throw new Exception("Au moins un des noms de paramètres d'url est dupliqué dans la définition des routes");
        }
    }

    public function getMethod() {
        return $this->method;
    }

    public function getContentTypes() {
        return $this->contentTypes;
    }

    public function getRoute() {
        return $this->route;
    }

    public function getController() {
        return $this->controller;
    }

    public function getControllerActionName() {
        return $this->controllerActionName;
    }

    public function addParameterRule($parameterName, $regex) {
        if (!in_array($parameterName, $this->urlParametersName)) {
            throw new Exception("Ajout de règle de paramètre impossible: Le nom de la contrainte sur paramètre d'url ne correspond à aucun nom de paramètre d'url");
        }
        foreach ($this->urlParametersRules as $elementPos => $arrayParam) {
            if ($arrayParam[0] == $parameterName) {
                $this->urlParametersRules[$elementPos][1][] = $regex;
            }
        }
    }

    public function requestMatchesRoute($LowRequestContentType, $UpRequestMethod, $parsedURL) {
        if (in_array($LowRequestContentType, $this->getContentTypes()) && $UpRequestMethod == $this->getMethod() && $this->urlMatchesRoute($parsedURL)) {
            return true;
        }
        return false;
    }

    public function urlMatchesRoute($parsedURL) {
        if (count($parsedURL) != count($this->route)) {
            return false;
        } else {
            $this->urlReqParamsValues = array();
            foreach ($this->route as $pathPlace => $pathElement) {
                if ($this->routeElementAtPosIsParameter($pathPlace)) {
                    foreach ($this->urlParametersRules[$pathPlace][1] as $regex) {
                        if (!preg_match($regex, $parsedURL[$pathPlace])) {
                            return false;
                        }
                    }
                    $this->urlReqParamsValues[$this->urlParametersName[$pathPlace]] = $parsedURL[$pathPlace];
                } else {
                    if (!isset($parsedURL[$pathPlace]) || $pathElement != $parsedURL[$pathPlace]) {
                        return false;
                    }
                }
            }
            return true;
        }
    }

    function getUrlReqParamsValues() {
        return $this->urlReqParamsValues;
    }

    private function routeElementAtPosIsParameter($pos) {
        if (isset($this->urlParametersName[$pos]) && $this->urlParametersName[$pos] != null) {
            return true;
        } else {
            return false;
        }
    }

}
