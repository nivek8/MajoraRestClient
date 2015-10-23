<?php

namespace Majora\RestClient;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteCollectionBuilder
{
    /**
     * @param array $config
     * @return RouteCollection
     */
    public function build(array $config)
    {
        $routeCollection = new RouteCollection();

        foreach($config as $routeName => $routeConfig)
        {
            $route = new Route(
                $this->generateFromToken($routeConfig['tokens']),
                $routeConfig['defaults'],
                $routeConfig['requirements'],
                array(),
                $this->generateFromToken($routeConfig['hosttokens'])
            );

            $routeCollection->add($routeName, $route);
        }

        return $routeCollection;
    }

    /**
     * @param array $tokens
     * @return string
     */
    private function generateFromToken(array $tokens)
    {
        $path = '';

        foreach($tokens as $token)
        {
            if ('variable' === $token[0]){
                $path = $token[1].'{'.$token[3].'}'.$path;
                continue;
            }

            $path = $token[1].$path;
        }

        return $path;
    }
}
