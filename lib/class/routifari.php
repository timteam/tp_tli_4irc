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
        $this->routes = array(
            //       ($method, $contentType, $route, $controller,     $controllerMethodName)
            new route('GET',    'HTML',         '/erreur404',       'erreur404',    'erreur404'), //shows error404 page
            new route('GET',    'HTML',         '/',                'home',         'home'), //shows homepage
            new route('GET',    'HTML',         '/home',            'home',         'home'), //shows homepage
            new route('GET',    'HTML',         '/sessions',        'session',      'session'), //shows login form
            new route('POST',   'HTML',         '/sessions',        'session',      'session'), //login
            new route('DELETE', 'JSON',         '/sessions',        'session',      'session'), //logout & redirects to ''
            new route('GET',    'HTML',         '/users/register',  'session',      'register'), //shows registration form
            new route('POST',   'HTML',         '/users',           'session',      'register'), //register user to DB
            new route('GET',    'HTML,JSON',    '/symptomes',       'symptomes',    'symptomes'), //shows symptoms
            new route('GET',    'HTML,JSON',    '/pathologies',     'pathologies',  'pathologies'), //shows pathos
            new route('GET',    'JSON',         '/meridiens',       'meridiens',    'meridiens'), //shows méridiens
        );

        /**
         * @Route(
         *     "articles/{nb=int}/comments",
         *     defaults={"_format": "html"},
         *     requirements={
         *         "_locale": "en|fr",
         *         "_format": "html|rss",
         *         "year": "\d+"
         *     }
         * )
         * //GET  /users/xxx                                                      gets and renders current user data in a profile view
         * //PUT /users/xxx                                                       updates new information about user
         */
    }

    public function launch($requestContentType, $requestMethod, $requestUrl, $parametres) {
        try
        {
            $UpRequestMethod = strtoupper($requestMethod);
            $LowRequestContentType = strtolower($requestContentType);
            $parsedURL = array_values(array_filter(explode('/', $requestUrl, 50)));

            //La première route correspondante est exécutée
            $routeFound = false;
            foreach ($this->routes as $route) {
                if (in_array($LowRequestContentType, $route->getContentTypes()) && $UpRequestMethod == $route->getMethod() && $parsedURL == $route->getRoute()) {
                    $this->launchAction($route, $LowRequestContentType, $parametres);
                    $routeFound = true;
                    break;
                }
            }
            if (!$routeFound) {
                throw new Exception("aucune route de correspond");
            }
        }catch(Exception $e){
            require_once(SMARTY_DIR . 'Smarty.class.php');
            $this->smarty = new Smarty();
            $this->smarty->template_dir = 'templates/';
            $this->smarty->compile_dir = 'templates_c/';
            $this->smarty->config_dir = 'configs/';
            $this->smarty->cache_dir = 'cache/';
            $this->smarty->assign('argument', null);
            $this->smarty->assign('module', 'erreur404.tpl');
            $this->smarty->display('site.tpl');      
        }
    }

    public function launchAction(route $route, $requestContentType, $parametres) {
        $controllerName = $route->getController();
        $actionName = $route->getControllerActionName();
        if (file_exists('lib/class/controllers/' . $controllerName . '.php')) {
            include 'lib/class/controllers/' . $controllerName . '.php';
            $controller = new $controllerName($requestContentType, $parametres);
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
    private $contentTypes;
    private $route;
    private $controller;
    private $controllerActionName;

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
                default:throw new Exception("Format invalide dans la définition des routes");
            }
        }
        $this->route = array_values(array_filter(explode('/', $route)));
        $this->controller = ucfirst(strtolower($controller)) . 'Controller';
        $this->controllerActionName = strtolower($controllerActionName) . 'Action' . ucfirst(strtolower($method));
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

}
