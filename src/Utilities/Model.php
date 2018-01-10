<?php

namespace Bondacom\Antenna\Utilities;

use Bondacom\Antenna\Drivers\DriverInterface;
use Bondacom\Antenna\Exceptions\AntennaServerException;
use Illuminate\Support\Collection;

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
     * @return
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
        return $this->driver()->$method(...$parameters);
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
     * @return \Illuminate\Support\Collection
     * @throws AntennaServerException
     */
    private function all(array $parameters = []) : Collection
    {
        return $this->driver->all($parameters);
    }

    /**
     * @param $id
     * @return AntennaModel
     * @throws AntennaServerException
     */
    private function find($id)
    {
        $model = new static(['id' => $id]);
        $model->refresh();

        return $model;
    }

    /**
     * @param array $data
     * @return AntennaModel
     * @throws AntennaServerException
     */
    private function create(array $data)
    {
        $model = new static($data);
        $model->save();

        return $model;
    }

    /**
     * @return bool
     */
    private function delete()
    {
        return $this->driver->delete($this->attributes['id']);
    }

    /**
     * @return $this
     * @throws AntennaServerException
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
     * @throws AntennaServerException
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
     * @param $id
     * @return Builder
     */
    protected function belongsTo($class, $id)
    {
        return new Builder($class, [
            'app_id' => $id
        ]);
    }

    /**
     * @param array $parameters
     */
    public function append(array $parameters)
    {
        $this->driver->append($parameters);
    }
}