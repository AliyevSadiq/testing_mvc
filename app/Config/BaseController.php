<?php

class BaseController
{
    static $_instance;
    protected $_controller, $_action, $_params, $_body;

    private function __construct()
    {
        $request = $_SERVER['REQUEST_URI'];
        $requestParams = strstr($request, '?', true) ?: $request;
        $splits = explode('/', trim($requestParams, '/'));

        // Controller
        $controllerName = !empty($splits[0]) ? $splits[0] : 'Index';
        $this->_controller = ucfirst($controllerName) . 'Controller';

        // Action
        $actionName = $splits[1] ?? 'index';
        $this->_action = $actionName . 'Action';

        // Parameters
        $this->_params = [];
        $paramCount = count($splits);

        if ($paramCount > 2) {
            for ($i = 2; $i < $paramCount; $i += 2) {
                $key = $splits[$i] ?? '';
                $value = $splits[$i + 1] ?? '';
                $this->_params[$key] = $value;
            }
        }

        foreach ($_GET as $key => $value) {
            $this->_params[htmlspecialchars($key)] = htmlspecialchars($value);
        }
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function route()
    {
        $controllerClassName = $this->getController();

        if (!class_exists($controllerClassName)) {
            throw new Exception("Controller");
        }

        $controllerReflection = new ReflectionClass($controllerClassName);

        if (!$controllerReflection->implementsInterface('IController')) {
            throw new Exception("Interface");
        }

        $actionName = $this->getAction();

        if (!$controllerReflection->hasMethod($actionName)) {
            throw new Exception("Action");
        }

        $controllerInstance = $controllerReflection->newInstance();
        $actionMethod = $controllerReflection->getMethod($actionName);
        $arguments = [];

        foreach ($actionMethod->getParameters() as $parameter) {
            $className = $parameter->getType()->getName();
            $arguments[] = new $className();
        }

        $actionMethod->invokeArgs($controllerInstance, $arguments);
    }

    public function getController()
    {
        return $this->_controller;
    }

    public function getAction()
    {
        return $this->_action;
    }

    public function getParams()
    {
        return $this->_params;
    }

    public function setParams(array $params)
    {
        $this->_params = $params;
        return $this;
    }

    public function getBody()
    {
        return $this->_body;
    }

    public function setBody($body)
    {
        $this->_body = $body;
        return $this;
    }
}	