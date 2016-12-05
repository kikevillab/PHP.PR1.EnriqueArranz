<?php // demoRouting/src/index.php

require_once __DIR__ . '/../bootstrap.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use MiW16\Results\Controller\UserController;

// look inside *this* directory
$locator = new FileLocator(array(__DIR__));
$loader  = new YamlFileLoader($locator);
$routes  = $loader->load(ROUTE_FILE);

$context = new RequestContext(filter_input(INPUT_SERVER, 'REQUEST_URI'));

$matcher = new UrlMatcher($routes, $context);

$path_info = filter_input(INPUT_SERVER, 'PATH_INFO');

try {
    $parameters = $matcher->match($path_info);
    /** @var UserController $controller */
    $controller = new $parameters['_controller']($routes);
    if(isset($parameters['_param'])){
        $controller->$parameters['_action']($parameters[$parameters['_param']]);
    }else {
        $controller->$parameters['_action']();
    }

    echo '<pre>';
    var_dump($parameters);
    echo '</pre>';
} catch (ResourceNotFoundException $e) {
    echo 'Caught exception: The resource could not be found' . PHP_EOL;
} catch (MethodNotAllowedException $e) {
    echo 'Caught exception: the resource was found but the request method is not allowed'. PHP_EOL;
}

// Obtener parámetros a partir del nombre de la ruta
echo '---' . PHP_EOL . '<pre>Inverso "route1": ';
var_dump($routes->get('show_user')->setOption('id_user', 3)->getPath());
echo '</pre>';