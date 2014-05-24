<?php

namespace Anax\MVC;

/**
 * Dispatching to controllers.
 *
 */
class CDispatcherBasic implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectionAware;



    /**
     * Properties
     *
     */
    private $controllerName;    // Name of controller
    private $controller;        // Actual controller
    private $action;            // Name of action
    private $params;            // Params



    /**
     * Prepare the name.
     *
     * @param string $name to prepare.
     *
     * @return string as the prepared name.
     */
    public function prepareName($name)
    {
        $name = empty($name) ? 'index' : $name;
        $name = strtolower($name);
        $name = str_replace(['-', '_'], ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
<<<<<<< HEAD

=======
        
>>>>>>> upstream/master
        return $name;
    }



    /**
     * Set the name of the controller.
     *
     * @param string $name of the controller, defaults to 'index'.
     *
     * @return void
     */
    public function setControllerName($name = 'index')
    {
        $name = $this->prepareName($name) . 'Controller';

        $this->controllerName = $name;

        $this->controller = $this->di->has($name)
            ? $this->di->get($name)
            : null;
    }



    /**
     * Check if a controller exists with this name.
     *
     * @return void
     */
    public function isValidController()
    {
        return is_object($this->controller);
    }



    /**
     * Set the name of the action.
     *
     * @param string $name of the action, defaults to 'index'.
     *
     * @return void
     */
    public function setActionName($name = 'index')
    {
        $this->action = lcfirst($this->prepareName($name)) . 'Action';
    }



    /**
     * Set the params.
     *
     * @param array $params all parameters, defaults to empty.
     *
     * @return void
     */
    public function setParams($params = [])
    {
        $this->params = $params;
    }



    /**
     * Dispatch to a controller, action with parameters.
     *
     * @return mixed result from dispatched controller action.
     */
    public function isCallable()
    {
        $handler = [$this->controller, $this->action];
<<<<<<< HEAD
        return is_callable($handler);
=======
        return method_exists($this->controller, $this->action) && is_callable($handler);
>>>>>>> upstream/master
    }



    /**
     * Dispatch to a controller, action with parameters.
     *
     * @return mixed result from dispatched controller action.
     */
    public function dispatch()
    {
        $handler = [$this->controller, 'initialize'];
<<<<<<< HEAD
        if (is_callable($handler)) {
            call_user_func($handler);
        }
        $handler = [$this->controller, $this->action];

        if (is_callable($handler)) {
            return call_user_func_array($handler, $this->params);
=======
        if (method_exists($this->controller, 'initialize') && is_callable($handler)) {
            call_user_func($handler);
        }

        if ($this->isCallable()) {
            return call_user_func_array([$this->controller, $this->action], $this->params);
>>>>>>> upstream/master
        } else {
            throw new \Exception(
                "Trying to dispatch to a non callable item. Controllername = '"
                . $this->controllerName
<<<<<<< HEAD
                . ", Controller = '"
                . $this->controller
=======
>>>>>>> upstream/master
                . "', Action = '"
                . $this->action
                . "'."
            );
        }
    }


    /**
     * Forward to a controller, action with parameters.
     *
     * @param array $forward with details for controller, action, parameters.
     *
     * @return mixed result from dispatched controller action.
     */
    public function forward($forward = [])
    {
        $controller = isset($forward['controller'])
            ? $forward['controller']
            : null;

        $action = isset($forward['action'])
            ? $forward['action']
            : null;
<<<<<<< HEAD

=======
        
>>>>>>> upstream/master
        $params = isset($forward['params'])
            ? $forward['params']
            : [];

        $this->setControllerName($controller);
        $this->setActionName($action);
        $this->setParams($params);

<<<<<<< HEAD
        return $this->dispatch();
=======
        if ($this->isCallable()) {
            return $this->dispatch();
        } else {
            throw new \Exception(
                "Trying to forward to a non callable item. Controllername = '"
                . $this->controllerName
                . "', Action = '"
                . $this->action
                . "'."
            );
        }
>>>>>>> upstream/master
    }
}
