<?php

class Router{
    private $routes;
    
    public function __construct() 
    {
        $routersPath = ROOT.'/components/Routes.php';
        $this->routes = include $routersPath;
    }
    
    private function getURI()
    {
        if(!empty($_SERVER['REQUEST_URI']))
        {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run() 
    {

         // Get query string
        $uri = $this->getUri();

        //Check for such request in routes.php
        if(array_key_exists($uri, $this->routes))
        {
            foreach ($this->routes as $uriPattern => $path){
                if(preg_match("~$uriPattern~", $uri)){ 
                // Determine which controller
                // AND action will process the request                
                    $segments = explode('/', $path);

                    $controllerName = array_shift($segments).'Controller';
                    $controllerName = ucfirst($controllerName);

                    $actionName = 'action'.ucfirst(array_shift($segments));


                    $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';
                    if(file_exists($controllerFile)){
                        include_once($controllerFile);
                    }
                    $controllerObject = new $controllerName;
                    $result = $controllerObject->$actionName();

                    if($result != null){
                       break;
                   }
               }            
           }
       }else{
        //if not then we redirect to the home page
        header("Location: http://test");
       }
   }
}