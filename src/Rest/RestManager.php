<?php

namespace Majora\RestClient\Rest;

use Majora\RestClient\Exceptions\InvalidRouteNameException;
use Majora\RestClient\Route\RouteManager;
use Majora\RestClient\Map\MapFileManager;

class RestManager
{
    const GET_METHOD = 'GET';
    const POST_METHOD = 'POST';
    const PUT_METHOD = 'PUT';
    const DELETE_METHOD = 'DELETE';
    const HEAD_METHOD = 'HEAD';
    const PATCH_METHOD = 'PATCH';

    /**
     * @var RouteManager
     */
    private $routeManager;

    /**
     * @var MapFileManager
     */
    private $mapFileManager;

    /**
     * @var RestClientInterface
     */
    private $restClient;

    /**
     * @param RouteManager        $routeManager
     * @param MapFileManager      $mapFileManager
     * @param RestClientInterface $restClient
     * @param string              $url
     */
    public function __construct(
        RouteManager $routeManager,
        MapFileManager $mapFileManager,
        RestClientInterface $restClient,
        $url
    ) {
        $this->routeManager = $routeManager;
        $this->routeManager->load($url);

        $this->mapFileManager = $mapFileManager;
        $this->restClient = $restClient;
    }

    /**
     * @param string $namespace
     *
     * @return self
     */
    public function call($namespace)
    {
        $this->mapFileManager->load($namespace);

        return $this;
    }

    /**
     * @param array|null  $routeParamaters
     * @param string|null $routeName
     *
     * @return mixed
     */
    public function get($routeParameters = null, $routeName = null)
    {
        return $this->restClient->request(
            self::GET_METHOD,
            $this->generateUrl($routeParameters, $routeName)
        );
    }

    /**
     * @param array|null $routeParameters
     * @param array|null $routeName
     *
     * @return mixed
     */
    public function post($routeParameters = null, $routeName = null)
    {
        return $this->restClient->request(
            self::POST_METHOD,
            $this->generateUrl($routeParameters, $routeName)
        );
    }

    /**
     * @param array|null $routeParameters
     * @param array|null $routeName
     *
     * @return mixed
     */
    public function put($routeParameters = null, $routeName = null)
    {
        return $this->restClient->request(
            self::PUT_METHOD,
            $this->generateUrl($routeParameters, $routeName)
        );
    }

    /**
     * @param array|null $routeParameters
     * @param array|null $routeName
     *
     * @return mixed
     */
    public function delete($routeParameters = null, $routeName = null)
    {
        return $this->restClient->request(
            self::DELETE_METHOD,
            $this->generateUrl($routeParameters, $routeName)
        );
    }

    /**
     * @param array|null $routeParameters
     * @param array|null $routeName
     *
     * @return mixed
     */
    public function head($routeParameters = null, $routeName = null)
    {
        return $this->restClient->request(
            self::HEAD_METHOD,
            $this->generateUrl($routeParameters, $routeName)
        );
    }

    /**
     * @param array|null $routeParameters
     * @param array|null $routeName
     *
     * @return mixed
     */
    public function patch($routeParameters = null, $routeName = null)
    {
        return $this->restClient->request(
            self::PATCH_METHOD,
            $this->generateUrl($routeParameters, $routeName)
        );
    }

    /**
     * generateRouteUrl.
     *
     * @param array  $routeParameters
     * @param string $routeName
     *
     * @return string
     */
    private function generateUrl($routeParameters, $routeName)
    {
        if (!is_null($routeName) && !$this->mapFileManager->routeExist(self::GET_METHOD, $routeName)) {
            throw new InvalidRouteNameException();
        }

        if (null === $routeName) {
            $routeName = $this->mapFileManager->getRouteName(self::GET_METHOD);
        }

        return $this->routeManager->generateUrl($routeName, $routeParameters);
    }
}
