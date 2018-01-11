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
    private $parameters = [];

    /**
     * Builder constructor.
     * @param string $class
     */
    public function __construct(string $class)
    {
        $this->class = $class;
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

        return $model->{$name}(...$arguments);
    }
}