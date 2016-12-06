<?php
/**
 * Created by PhpStorm.
 * User: Enrique
 * Date: 06/12/2016
 * Time: 13:18
 */

namespace MiW16\Results\Controller;

use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;

abstract class AbstractController
{
    protected $routes;
    protected $urlGenerator;

    public function __construct($routes)
    {
        $this->routes = $routes;
        $this->urlGenerator = new UrlGenerator($this->routes, new RequestContext('/public'));
    }

    protected function toRoute($routeName){
        header("Location: ".$this->urlGenerator->generate($routeName));
        exit;
    }
}