<?php

namespace Bondacom\Antenna\Utilities;

use Bondacom\Antenna\Exceptions\AntennaMethodNotExistsException;

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
        $model->append($this->parameters);

        return empty($arguments) ?
            $model->{$name}() :
            $model->{$name}($arguments[0] ?? []);
    }
}