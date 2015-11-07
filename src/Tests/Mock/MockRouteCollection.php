<?php

namespace Majora\RestClient\Tests\Mock;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

abstract class MockRouteCollection
{
    public static function initRouteCollection()
    {
        $routeCollection = new RouteCollection();

        foreach (self::getRoutes() as $routeParam){
            $route = new Route($routeParam['path']);
            $route->setMethods($routeParam['method']);

            $routeCollection->add($routeParam['name'], $route);
        }

        return $routeCollection;
    }

    private function getRoutes()
    {
        return array(
            array(
                'method' => 'GET',
                'name' => 'my_route_cget',
                'path' => '/my/route/cget',
            ),
            array(
                'method' => 'GET',
                'name' => 'my_route_get',
                'path' => '/my/route/get/{id}',
            ),
            array(
                'method' => 'POST',
                'name' => 'my_route_post',
                'path' => '/my/route/post'
            ),
        );
    }
}
