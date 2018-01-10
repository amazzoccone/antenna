<?php

namespace Bondacom\Antenna\Utilities;

class Builder
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var array
     */
    private $parameters;

    /**
     * Builder constructor.
     * @param string $class
     * @param array $parameters
     */
    public function __construct(string $class, $parameters)
    {
        $this->class = $class;
        $this->parameters = $parameters;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function append(array $data)
    {
        $this->parameters = array_merge($this->parameters, $data);
        
        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $model = new $this->class();

        if (!method_exists($model, $name)) {
            //TODO: Throw exception
        }

        return $model->append($this->parameters)->{$name}($arguments);
    }
}