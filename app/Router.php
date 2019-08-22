<?php

namespace App;

use Closure;
use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class Router
{
    /** @var string[] */
    private const ALLOWED_METHODS = ['get', 'post'];

    /** @var Closure[][]|string[][] $routes */
    protected $routes;

    /** @var string[][] $regex */
    protected $regex;

    /**
     * @param $method
     * @param $arguments
     * @throws Exception
     */
    public function __call($method, $arguments)
    {
        if (array_search($method, self::ALLOWED_METHODS) === false) {
            throw new InvalidArgumentException("Method Not Allowed", 405);
        }
        $this->addRoutes($method, $arguments[0], $arguments[1]);
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $request      = Request::createFromGlobals();
        $route        = strtok($request->getRequestUri(), '?');
        $method       = strtolower($request->getMethod());
        $matchedRoute = $this->getMatchedRoute($method, $route);
        if ($matchedRoute !== false) {
            if ($matchedRoute instanceof MatchedRoute) {
                $result = is_callable($matchedRoute->getResult()) ? $matchedRoute->getResult()->call(
                    $this,
                    $request,
                    ...$matchedRoute->getParameters()
                ) : $matchedRoute->getResult();
            } else {
                $result = is_callable($matchedRoute) ? $matchedRoute->call($this, $request) : $matchedRoute;
            }
            echo $result;
        } else {
            throw new InvalidArgumentException("Route : $route not found ..");
        }
    }

    /**
     * @param string  $method
     * @param string  $route
     * @param Closure $callback
     * @throws Exception
     */
    private function addRoutes(string $method, string $route, $callback)
    {
        if ($route[0] !== '/') {
            $route = '/'.$route;
        }
        $routeExists = $this->isRouteExists($method, $route);
        $regexExists = $this->isRegexExists($method, $route);
        if (!$routeExists && !$regexExists) {
            $this->routes[$method][$route] = $callback;
            $this->regex[$method][$route]  = $this->formRouteRegex($route);
        } else {
            if ($routeExists) {
                throw new Exception("Route : {$route} already exists");
            } else {
                throw new Exception("Regex : {$this->regex[$method][$route]} already exists");
            }
        }
    }

    /**
     * @param string $route
     * @return string|null
     */
    private function formRouteRegex(string $route): string
    {
        $regex      = '^';
        $routeParts = explode('/', $route);
        foreach ($routeParts as $routePart) {
            if ($this->isVariableRoutePart($routePart)) {
                $routeVariable = substr($routePart, 1, strlen($routePart) - 2);
                if ($this->isValidRegex("$routeVariable")) {
                    $regex .= $routeVariable;
                } else {
                    $regex .= "(\w+)";
                }
            } else {
                $regex .= $routePart;
            }
            $regex .= "\/";
        }
        $regex = rtrim($regex, "\/");

        return $regex.'$';
    }

    /**
     * @param string $method
     * @param string $route
     * @return MatchedRoute|bool|Closure|string
     */
    private function getMatchedRoute(string $method, string $route)
    {
        if ($this->isRouteExists($method, $route)) {
            return $this->routes[$method][$route];
        }

        return $this->matchRouteToPattern($method, $route);
    }

    /**
     * @param string $method
     * @param string $route
     * @return bool
     */
    private function isRegexExists(string $method, string $route): bool
    {
        return isset($this->regex[$method][$route]);
    }

    /**
     * @param string $routeVariable
     * @return bool
     */
    private function isRegexPart(string $routeVariable): bool
    {
        return $routeVariable[0] == '(' && $routeVariable[strlen($routeVariable) - 1] == ')';
    }

    /**
     * @param string $method
     * @param string $route
     * @return bool
     */
    private function isRouteExists(string $method, string $route): bool
    {
        return isset($this->routes[$method][$route]);
    }

    /**
     * @param string $routeVariable
     * @return bool
     */
    private function isValidRegex(string $routeVariable): bool
    {
        return $this->isRegexPart($routeVariable) && preg_match("/$routeVariable/", null) !== false;
    }

    /**
     * @param string $routePart
     * @return bool
     */
    private function isVariableRoutePart(string $routePart): bool
    {
        return $routePart[0] == '{' && $routePart[strlen($routePart) - 1] == '}';
    }

    /**
     * @param string $method
     * @param string $route
     * @return MatchedRoute|bool
     */
    private function matchRouteToPattern(string $method, string $route)
    {
        $methodPatterns = $this->regex[$method];
        foreach ($methodPatterns as $savedRoute => $pattern) {
            $patternMatches = preg_match("/$pattern/", $route, $matches);
            if ($patternMatches !== false && $patternMatches !== 0) {
                return new MatchedRoute($savedRoute, $this->routes[$method][$savedRoute], array_slice($matches, 1));
            }
        }

        return false;
    }


}
