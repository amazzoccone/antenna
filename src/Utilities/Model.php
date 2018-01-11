<?php

namespace Bondacom\Antenna\Utilities;

use Bondacom\Antenna\Drivers\DriverInterface;

abstract class Model
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * Check if must go to the server to update it.
     *
     * @var bool
     */
    protected $isDirty = false;

    /**
     * AntennaModel constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->driver = $this->newDriverInstance();
        $this->fill($attributes);
    }

    /**
     * @return \Bondacom\Antenna\Drivers\ModelInterface
     */
    abstract public function newDriverInstance();

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->$method(...$parameters);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }

    /**
     * @param array $parameters
     * @return array
     * @throws \Bondacom\Antenna\Exceptions\AntennaServerException
     */
    private function all(array $parameters = []) : array
    {
        return $this->driver->all($parameters);
    }

    /**
     * @param $id
     * @return AntennaModel
     * @throws \Bondacom\Antenna\Exceptions\AntennaServerException
     */
    private function find($id)
    {
        $this->attributes['id'] = $id;
        $this->refresh();

        return $this;
    }

    /**
     * @param array $data
     * @return AntennaModel
     * @throws \Bondacom\Antenna\Exceptions\AntennaServerException
     */
    private function create(array $data)
    {
        $this->fill($data);
        $this->save();

        return $this;
    }

    /**
     * @return bool
     * @throws \Bondacom\Antenna\Exceptions\AntennaServerException
     */
    private function delete()
    {
        return $this->driver->delete($this->attributes['id']);
    }

    /**
     * @return $this
     * @throws \Bondacom\Antenna\Exceptions\AntennaServerException
     */
    public function save()
    {
        if (!$this->isDirty) {
            return $this;
        }

        $result = empty($this->attributes['id']) ?
            $this->driver->create($this->attributes) :
            $this->driver->update($this->attributes, $this->attributes['id']);

        $this->fill($result);
        $this->isDirty = false;

        return $this;
    }

    /**
     * Reload the current model instance with fresh attributes from the server.
     *
     * @return $this
     * @throws \Bondacom\Antenna\Exceptions\AntennaServerException
     */
    public function refresh()
    {
        $data = $this->driver->find($this->attributes['id']);

        $this->fill($data);
        $this->isDirty = false;

        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string $key
     * @return mixed
     */
    private function getAttribute($key)
    {
        if (!$key) {
            return;
        }

        // If we have it we will return it
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    private function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
        $this->isDirty = true;

        return $this;
    }

    /**
     *
     * @param array $data
     * @return $this
     */
    private function fill($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }

        return $this;
    }

    /**
     * @param $class
     * @return Builder
     */
    protected function newQuery($class)
    {
        return new Builder($class);
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function append(array $parameters)
    {
        $this->driver->append($parameters);

        return $this;
    }
}