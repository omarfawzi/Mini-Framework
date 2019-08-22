<?php

namespace App;

use Closure;
use Exception;

class MatchedRoute
{
    /** @var string $route */
    private $route;

    /** @var string|Closure $result */
    private $result;

    /** @var array $parameters */
    private $parameters;

    /**
     * MatchedRoute constructor.
     *
     * @param string         $route
     * @param Closure|string $result
     * @param array          $parameters
     */
    public function __construct(string $route, $result, array $parameters)
    {
        $this->route      = $route;
        $this->result     = $result;
        $this->parameters = $parameters;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return Closure|string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }
}