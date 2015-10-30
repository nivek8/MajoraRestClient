<?php

namespace Majora\RestClient\Tests\Mock;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

abstract class MockRouteCollection
{
    public static function initRouteCollection()
    {
        $routeCollection = new RouteCollection();
        $route = new Route('/my/route/path');
        $route->setMethods('GET');

        $routeCollection->add('my_route_name', $route);

        return $routeCollection;
    }
}
